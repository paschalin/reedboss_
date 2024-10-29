<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Models\UserMeta;
use WireUi\Traits\Actions;
use App\Models\CustomField;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ExtraProfile extends Component
{
    use Actions;
    use WithFileUploads;

    public $image;

    public $custom_fields;

    public $dob;

    public $extra_attributes;

    public $meta;

    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
        $this->meta = $this->user->meta_data;
        $this->dob = $this->meta['dob'] ?? null;
        $this->custom_fields = CustomField::ofModel('User')->get();
        $this->extra_attributes = $this->user->extra_attributes->toArray();
        $this->meta['disable_messages'] = ($this->meta['disable_messages'] ?? null) == 1;
        foreach ($this->custom_fields as $custom_field) {
            $this->extra_attributes[$custom_field->name] ??= null;
        }
    }

    public function render()
    {
        return view('livewire.user.extra_profile')->layoutData(['title' => __('Extra Profile Information')]);
    }

    public function save()
    {
        $this->validate();
        $user = auth()->user();
        $this->meta['dob'] = $this->dob;
        if ($this->image) {
            Storage::disk('site')->delete($this->user->meta_data['image']);
            $this->meta['image'] = $this->image->store('images', 'site');
        }
        foreach ($this->meta as $key => $value) {
            if (in_array($key, ['bio', 'signature'])) {
                $value = strip_tags($value);
            }
            UserMeta::updateOrCreate(['meta_key' => $key, 'user_id' => $user->id], ['meta_value' => $value]);
        }
        $this->user->extra_attributes->set($this->extra_attributes);
        $this->user->save();
        $this->emit('saved');
        $this->notification()->success(
            $title = __('Saved!'),
            $description = __('Profile has been successfully saved.')
        );
    }

    public function deleteImage()
    {
        Storage::disk('site')->delete($this->meta['image']);
        UserMeta::updateOrCreate(['meta_key' => 'image', 'user_id' => auth()->id()], ['meta_value' => null]);
        $this->meta['image'] = null;

        $this->notification()->success(
            $title = __('Saved!'),
            $description = __('Profile image has been deleted.')
        );

        return back()->with('message', __('Image has been deleted.'));
    }

    protected function rules()
    {
        return [
            'image'                 => 'nullable|image|max:1000|dimensions:max_width=1600,max_height=600',
            'dob'                   => 'nullable|date:Y-m-d',
            'meta.display_name'     => 'required',
            'meta.dob'              => 'nullable',
            'meta.bio'              => 'nullable',
            'meta.signature'        => 'nullable',
            'meta.facebook_link'    => 'nullable',
            'meta.twitter_link'     => 'nullable',
            'meta.instagram_link'   => 'nullable',
            'meta.linkedin_link'    => 'nullable',
            'meta.github_link'      => 'nullable',
            'meta.dribbble_link'    => 'nullable',
            'meta.disable_messages' => 'nullable',
            'extra_attributes.*'    => [function ($attribute, $value, $fail) {
                $attribute = explode('[', explode('.', $attribute)[1])[0];
                $field = $this->custom_fields->where('name', $attribute)->first();
                if ($field?->required && empty($value)) {
                    $fail(trans('validation.required', ['attribute' => str($attribute)->lower()]));
                }
            }],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'meta.display_name' => __('display name'),
        ];
    }
}
