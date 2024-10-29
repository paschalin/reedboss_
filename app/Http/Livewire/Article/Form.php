<?php

namespace App\Http\Livewire\Article;

use App\Models\Role;
use App\Models\Article;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\CustomField;
use Livewire\WithFileUploads;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Storage;

class Form extends Component
{
    use Actions;
    use WithFileUploads;

    public Article $article;

    public $custom_fields;

    public $extra_attributes;

    public $image;

    public $settings;

    public function deleteImage()
    {
        try {
            Storage::disk(env('ATTACHMENT_DISK', 'site'))->delete($this->article->image);
        } catch (\Exception $e) {
            logger('Failed to delete article image.', ['error' => $e->getMessage()]);
        }
        $this->article->image = null;
        $this->notification()->success(
            $title = __('Delete!'),
            $description = __('Image has been deleted.')
        );
    }

    public function mount(?Article $article)
    {
        $this->article = $article;
        $this->settings = site_config();
        if (! $this->article->id) {
            if (auth()->user()->cant('create-articles')) {
                return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
            }
            $this->article->active = true;
        } elseif (auth()->user()->cant('update-articles')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }
        $this->custom_fields = CustomField::ofModel('Article')->get();
        $this->extra_attributes = $this->article->extra_attributes->toArray();
        foreach ($this->custom_fields as $custom_field) {
            $this->extra_attributes[$custom_field->name] ??= null;
        }
    }

    public function render()
    {
        return view('livewire.article.form', [
            'roles'              => Role::all(),
            'article_categories' => ArticleCategory::tree(['id', 'name', 'slug', 'article_category_id']),
        ])
            ->layoutData(['title' => ($this->article ?? null) ? __('Edit Article') : __('New Article')]);
    }

    public function save()
    {
        $this->validate();
        $categories = get_id_with_parents($this->article->article_category_id, [], ArticleCategory::class, 'article_category_id');

        if ($this->image) {
            $disk = env('ATTACHMENT_DISK', 'site');
            $this->article->image = Storage::disk($disk)->url(
                $disk == 'site' ?
                $this->image->store('articles/' . auth()->id(), 'site') :
                $this->image->storePublicly('articles/' . auth()->id(), 's3')
            );
        }
        if (auth()->user()->cant('group-permissions')) {
            $this->article->group = null;
        }
        $this->article->extra_attributes->set($this->extra_attributes);
        $this->article->save();
        $this->article->articleCategories()->sync($categories);

        return to_route('articles')->with('message', __('Article has been successfully saved.'));
    }

    protected function rules()
    {
        return [
            'image' => 'nullable|max:' . ($this->settings['upload_size'] ?? '2048') . '|mimes:jpg,jpeg,png,svg',

            'article.title'               => 'required|min:5|max:60',
            'article.slug'                => 'nullable|alpha_dash|max:60|unique:articles,slug,' . $this->article->id,
            'article.article_category_id' => 'nullable|exists:article_categories,id',
            'article.description'         => 'nullable|string|max:160',
            'article.body'                => 'required|min:20',
            'article.order_no'            => 'nullable|integer',
            'article.active'              => 'nullable|boolean',
            'article.noindex'             => 'nullable|boolean',
            'article.nofollow'            => 'nullable|boolean',
            'article.group'               => 'nullable',
            'extra_attributes.*'          => [function ($attribute, $value, $fail) {
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
            'article.title'               => __('title'),
            'article.slug'                => __('slug'),
            'article.description'         => __('description'),
            'article.article_category_id' => __('category'),
            'article.body'                => __('body'),
            'article.order_no'            => __('order no'),
            'article.active'              => __('active'),
            'article.noindex'             => __('noindex'),
            'article.nofollow'            => __('nofollow'),
        ];
    }
}
