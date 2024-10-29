<?php

namespace App\Http\Livewire\Forum;

use App\Models\Tag;
use App\Models\User;
use App\Models\Thread;
use Livewire\Component;
use App\Models\Category;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use App\Jobs\SendNotifications;

class Home extends Component
{
    use Actions;
    use WithPagination;

    public $by;

    public Category $category;

    public $favorites_of;

    public $require_approval;

    public $require_review;

    public $sorting = 'latest';

    public $tag;

    public $trending;

    protected $listeners = ['reloadThreads' => 'render'];

    protected $queryString = ['by', 'favorites_of', 'require_approval', 'require_review', 'tag', 'trending'];

    public function approve()
    {
        if (auth()->user()->cant('approve-threads')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }
        $user = auth()->user();
        if (! $user) {
            return to_route('login');
        } elseif (! $user->can('approve-threads')) {
            return to_route('threads');
        }

        foreach (Thread::notApproved()->cursor() as $thread) {
            $thread->update(['approved' => 1, 'approved_by' => $user->id]);
            SendNotifications::dispatchAfterResponse($user, $thread->load(['approvedBy', 'user'])->refresh(), 'approved');
        }

        return to_route('threads')->with('message', __('All the threads have been approved.'));
    }

    public function mount(?Category $category)
    {
        $loggedIn = auth()->user();
        if ($category && ! $loggedIn?->roles->where('name', 'super')->first() &&
        $category->view_group &&
        $category->view_group != $loggedIn?->roles->where('id', $category->view_group)->first()?->id) {
            abort('403', __('You do not have permissions to view this category.'));
        }

        $this->category = $category;
        $this->sorting = session('sorting', 'latest');
    }

    public function render()
    {
        if ($this->favorites_of && $user = User::withoutGlobalScope('withCounts')->where('username', $this->favorites_of)->first()) {
            $threads = $user->favorites();
        } elseif ($this->tag) {
            $tag = Tag::where('name', $this->tag)->first();
            $threads = $tag->threads();
        } else {
            $threads = Thread::query();
        }

        if ($this->by && $user = User::where('username', $this->by)->first()) {
            $threads->where('user_id', $user->id);
        }
        $loggedIn = auth()->user();
        if ($loggedIn) {
            if ($this->require_review == 'yes' && $loggedIn->can('review')) {
                $threads->flagged();
            }
            if ($this->require_approval == 'yes' && $loggedIn->can('approve-threads')) {
                $threads->notApproved()->orderBy('approved', 'asc');
            } else {
                $threads->active()->approved();
            }
            $threads->withCount(['favorites as user_favorites' => fn ($q) => $q->where('user_id', $loggedIn->id)]);
        } else {
            $threads->active()->approved();
        }
        if ($this->category->id) {
            $threads->orderBy('sticky_category', 'desc')
                ->whereRelation('categories', 'id', $this->category->id);
        } else {
            $threads->orderBy('sticky', 'desc');
        }

        if ($this->sorting == 'likes') {
            $threads->orderBy('up_votes', 'desc');
        } elseif ($this->sorting == 'replies') {
            $threads->orderBy('replies_count', 'desc');
        } else {
            $threads->latest();
        }

        if ($this->trending && $this->trending == 'yes') {
            $threads->reorder();
            if ($this->category->id) {
                $threads->orderBy('sticky_category', 'desc')
                    ->whereRelation('categories', 'id', $this->category->id);
            } else {
                $threads->orderBy('sticky', 'desc');
            }
            $threads->withCount(['replies as last_week' => fn ($q) => $q->whereBetween('created_at', [now()->subDays(7), now()])])->orderBy('last_week', 'desc');
            $this->sorting = 'trending';
        }

        $this->emit('page-changed');
        session(['sorting' => $this->sorting]);

        return view('livewire.forum.home', [
            'threads' => $threads->forUser()->allowedCategory()->paginate()->withQueryString(),
        ])->layout('layouts.public');
    }
}
