<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class Show extends Component
{
    use WithPagination;

    public User $user;

    public function mount(?User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.show', [
            'activities' => Activity::with(['causer', 'subject.thread'])->where('causer_id', $this->user->id)->latest()->paginate(),
        ])->layout('layouts.public');
    }
}
