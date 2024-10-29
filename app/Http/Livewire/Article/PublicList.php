<?php

namespace App\Http\Livewire\Article;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ArticleCategory;

class PublicList extends Component
{
    use WithPagination;

    public $article_category;

    public function mount(?ArticleCategory $article_category)
    {
        if (! (site_config('articles') ?? null)) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }

        $this->article_category = $article_category;
    }

    public function render()
    {
        $articles = Article::query()->active()->forUser();
        if ($this->article_category->id) {
            $articles->whereRelation('articleCategories', 'id', $this->article_category->id);
        }

        return view('livewire.article.list', ['articles' => $articles->latest()->paginate()])->layout('layouts.public', ['title' => __('All Articles')]);
    }
}
