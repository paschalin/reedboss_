<?php

namespace App\Http\Livewire\KnowledgeBase;

use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use App\Models\KnowledgeBase;

class Index extends Component
{
    use Actions;
    use WithPagination;

    public function mount()
    {
        if (auth()->user()->cant('read-knowledgebase')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }
    }

    public function removeRecord($id)
    {
        if (auth()->user()->cant('delete-knowledgebase')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }
        $kb = KnowledgeBase::findOrFail($id);
        $kb->KBCategories()->detach();
        if ($kb->delete()) {
            $this->notification()->success(
                $title = __('Success!'),
                $description = __(':record has been deleted.', ['record' => __('Knowledge Base')])
            );
        } else {
            $this->notification()->error(
                $title = __('Failed!'),
                $description = __('Failed to delete :record.', ['record' => __('Knowledge Base')])
            );
        }
    }

    public function render()
    {
        return view('livewire.knowledgebase.index', ['knowledge_base' => KnowledgeBase::latest()->paginate()]);
    }
}
