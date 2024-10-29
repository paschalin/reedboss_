<?php

namespace App\Http\Livewire\Forum;

use App\Models\User;
use App\Models\Thread;
use Livewire\Component;
use App\Models\Category;
use WireUi\Traits\Actions;

class ThreadOverview extends Component
{
    use Actions;
    use ThreadActions;

    public Category $category;

    public Thread $thread;

    public User $user;

    protected $settings;

    public function mount($settings, Thread $thread, ?Category $category)
    {
        $this->thread = $thread;
        $this->category = $category;
        $this->settings = $settings;
        // $this->thread = $this->thread->load(['categories', 'user'])->loadCount('replies');
    }

    public function render()
    {
        return view('livewire.forum.thread-overview');
    }
}
