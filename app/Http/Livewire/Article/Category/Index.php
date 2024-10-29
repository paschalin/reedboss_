<?php

namespace App\Http\Livewire\Article\Category;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\ArticleCategory;

class Index extends Component
{
    use Actions;

    public function mount()
    {
        if (auth()->user()->cant('read-articles')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }
    }

    public function removeRecord($id)
    {
        if (auth()->user()->cant('delete-articles')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }
        $article_category = ArticleCategory::findOrFail($id);
        if ($article_category->delete()) {
            $this->notification()->success(
                $title = __('Success!'),
                $description = __(':record has been deleted.', ['record' => __('Article Category')])
            );
        } else {
            $this->notification()->error(
                $title = __('Failed!'),
                $description = __('Failed to delete :record.', ['record' => __('Article Category')])
            );
        }
    }

    public function render()
    {
        return view('livewire.article.category.index', ['article_categories' => ArticleCategory::latest()->paginate()])
            ->layoutData(['title' => __('Article Categories')]);
    }
}
