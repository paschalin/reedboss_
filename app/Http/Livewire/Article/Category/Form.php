<?php

namespace App\Http\Livewire\Article\Category;

use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use App\Models\ArticleCategory;

class Form extends Component
{
    use Actions;
    use WithFileUploads;

    public ArticleCategory $article_category;

    public $image;

    public function mount(?ArticleCategory $article_category)
    {
        $this->article_category = $article_category;
        if (! $this->article_category->id) {
            if (auth()->user()->cant('create-articles')) {
                return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
            }
            $this->article_category->active = true;
        } elseif (auth()->user()->cant('update-articles')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }
    }

    public function render()
    {
        return view('livewire.article.category.form', [
            'mainCategories' => ArticleCategory::get(['id', 'name']),
        ])->layoutData([
            'title' => $this->article_category->id ? __('Edit Article Category') : __('New Article Category'),
        ]);
    }

    public function save()
    {
        $this->validate();
        if ($this->image) {
            $this->article_category->image = $this->image->store('images');
        }
        $this->article_category->save();
        $this->emit('saved');
        cache()->forget('articleCategoriesMenu');
        $this->notification()->success(
            $title = __('Saved!'),
            $description = __('Article Category has been successfully saved.')
        );

        return redirect()->route('articles.categories');
    }

    protected function rules()
    {
        return [
            'article_category.name'                => 'required|min:3|max:60',
            'article_category.title'               => 'required|min:5|max:60',
            'article_category.slug'                => 'nullable|alpha_dash|max:60|unique:categories,slug,' . $this->article_category->id,
            'article_category.description'         => 'required|string|max:160',
            'article_category.article_category_id' => 'nullable',
            'article_category.order_no'            => 'nullable|integer',
            'article_category.active'              => 'nullable|boolean',
            'article_category.private'             => 'nullable|boolean',
            'image'                                => 'nullable|image|max:1024',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'article_category.name'                => __('name'),
            'article_category.title'               => __('title'),
            'article_category.slug'                => __('slug'),
            'article_category.description'         => __('description'),
            'article_category.article_category_id' => __('category_id'),
            'article_category.order_no'            => __('order no'),
            'article_category.active'              => __('active'),
            'article_category.private'             => __('private'),
        ];
    }
}
