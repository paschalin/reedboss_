<?php

namespace App\Http\Livewire\Forum;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Jobs\SendNotifications;

class Flag extends Component
{
    use Actions;

    public $icon;

    public $reason;

    public $record;

    public function mount($record, $icon = false)
    {
        $this->icon = $icon;
        $this->record = $record;
    }

    public function render()
    {
        return view('livewire.forum.flag');
    }

    public function report()
    {
        $user = auth()->user();
        if (! $user) {
            return to_route('login');
        }

        $this->validate();
        $this->record->flag()->create(['reason' => $this->reason]);
        SendNotifications::dispatch($user, $this->record->slug ? $this->record : $this->record->thread, $this->record->slug ? 'flagged' : 'flagged_reply');

        if ($this->record->slug) {
            return to_route('threads')->with('message', __('You have flagged the post.'));
        }

        return to_route('threads.show', $this->record->thread->slug)->with('message', __('You have flagged the post.'));
    }

    protected function rules()
    {
        return ['reason' => 'required|min:10'];
    }
}
