<?php

namespace App\Http\Livewire\Forum;

use Livewire\Component;
use App\Rules\Turnstile;
use WireUi\Traits\Actions;
use App\Models\CustomField;
use Livewire\WithPagination;
use App\Rules\ThrottleThread;
use App\Models\Thread as ThreadsModal;
use Illuminate\Support\Facades\Validator;
use App\Notifications\SendReplyVerificationEmail;

class Thread extends Component
{
    use Actions;
    use ThreadActions;
    use WithPagination;

    public $custom_fields;

    public $captcha;

    public $replies_sorting;

    public $extra_attributes = [];

    public $form = ['body' => '', 'guest_name' => '', 'guest_email' => ''];

    public ThreadsModal $thread;

    protected $messages = [
        'form.guest_name.required'  => 'Name cannot be empty.',
        'form.guest_email.required' => 'Email cannot be empty.',
        'form.guest_email.email'    => 'Email Address format is not valid.',
    ];

    public function mount(ThreadsModal $thread)
    {
        $this->replies_sorting = site_config('replies_sorting') ?? 'latest';
        if (! request()->has('page') && $this->replies_sorting == 'oldest') {
            $replies = $this->thread->replies()->oldest('id')->paginate();

            if ($replies->lastPage() > 1) {
                return to_route('threads.show', ['thread' => $thread->slug, 'page' => $replies->lastPage()]);
            }
        }
        $this->thread = $thread;
        if (! $this->thread->approved && (! auth()->user() || auth()->user()?->cant('approve'))) {
            return to_route('threads')->with('info', __('The thread is under review.'));
        }

        $loggedIn = auth()->user();
        if (! $loggedIn?->roles->where('name', 'super')->first() &&
        $thread->category->view_group &&
        $thread->category->view_group != $loggedIn?->roles->where('id', $thread->category->view_group)->first()?->id) {
            abort('403', __('You do not have permissions to view this thread.'));
        }

        $this->thread->increment('views');
        $this->custom_fields = CustomField::ofModel('Reply')->get();
        // $this->extra_attributes = $this->faq->extra_attributes->toArray();
        foreach ($this->custom_fields as $custom_field) {
            $this->extra_attributes[$custom_field->name] ??= null;
        }
    }

    public function render()
    {
        $this->emit('page-changed');
        $this->thread = $this->thread->loadMissing(['categories', 'user', 'acceptedReply']);

        $replies = $this->thread->replies()->with(['flag', 'user']);

        if ($this->replies_sorting == 'latest') {
            $replies = $replies->latest('id');
        } else {
            $replies = $replies->oldest('id');
        }

        return view('livewire.forum.thread', [
            'replies' => $replies->paginate(),
        ])->layout('layouts.public');
    }

    public function reply()
    {
        if (auth()->guest() && ! (site_config('guest_reply') ?? null)) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }

        if (auth()->user() && auth()->user()->cant('create-replies')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }

        $settings = site_config();
        $captcha_rules = ['nullable'];
        if (auth()->guest()) {
            if (($settings['captcha'] ?? null) && ($settings['captcha_provider'] == 'recaptcha')) {
                $captcha_rules = ['required', 'captcha'];
            } elseif (($settings['captcha'] ?? null) && ($settings['captcha_provider'] == 'trunstile')) {
                $captcha_rules = ['required', new Turnstile];
            } elseif (($settings['captcha'] ?? null) && ($settings['captcha_provider'] == 'local')) {
                $captcha_rules = ['required', 'localCaptcha'];
            }
        }

        $validator = Validator::make(
            [
                'form' => $this->form,
                // 'form.body'        => $this->form['body'],
                // 'form.guest_name'  => $this->form['guest_name'],
                // 'form.guest_email' => $this->form['guest_email'],
                'captcha'          => $this->captcha,
                'extra_attributes' => $this->extra_attributes,
            ],
            [
                'captcha'            => $captcha_rules,
                'form.body'          => ['required', 'min:5', new ThrottleThread('replies')],
                'form.guest_name'    => auth()->guest() ? 'required' : 'nullable',
                'form.guest_email'   => auth()->guest() ? 'required' : 'nullable',
                'extra_attributes.*' => [function ($attribute, $value, $fail) {
                    $attribute = explode('.', $attribute)[1];
                    $field = $this->custom_fields->where('name', $attribute)->first();
                    if ($field->required && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => str($attribute)->lower()]));
                    }
                }],
            ],
            [
                'form.body.required'        => trans('validation.required', ['attribute' => 'body']),
                'form.guest_name.required'  => trans('validation.required', ['attribute' => 'name']),
                'form.guest_email.required' => trans('validation.required', ['attribute' => 'email']),
                'form.guest_email.email'    => trans('validation.email', ['attribute' => 'email']),
                'captcha.required'          => trans('validation.custom.g-recaptcha-response.required'),
                'captcha.captcha'           => trans('validation.custom.g-recaptcha-response.captcha'),
            ]
        );

        if ($validator->fails()) {
            $this->setErrorBag($validator->errors());
            $this->emit('resetCaptcha');

            return null;
        }

        // $validated = $validator->validated();
        // $this->validate();
        $reply = $this->thread->replies()->create(check_banned_words($this->form, true));
        $reply->extra_attributes->set($this->extra_attributes);
        $reply->saveQuietly();
        $message = __('Your reply has been successfully saved.');
        if (auth()->guest()) {
            $reply->notify(new SendReplyVerificationEmail($reply));
            $message = __('We have sent you email, please confirm your reply.');
        }

        return to_route('threads.show', $this->thread->slug)->with('message', $message);
    }

    // protected function rules()
    // {
    //     return [
    //         'form.body'          => 'required',
    //         'form.guest_name'    => auth()->guest() ? 'required' : 'nullable',
    //         'form.guest_email'   => auth()->guest() ? 'required' : 'nullable',
    //         'recaptcha'          => auth()->guest() ? 'required|captcha' : 'nullable',
    //         'extra_attributes.*' => [function ($attribute, $value, $fail) {
    //             $attribute = explode('.', $attribute)[1];
    //             $field = $this->custom_fields->where('name', $attribute)->first();
    //             if ($field->required && empty($value)) {
    //                 $fail(trans('validation.required', ['attribute' => str($attribute)->lower()]));
    //             }
    //         }],
    //     ];
    // }
}
