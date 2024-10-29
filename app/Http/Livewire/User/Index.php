<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Models\Badge;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;

class Index extends Component
{
    use Actions;
    use WithPagination;

    public $active;

    public $banned;

    public $user_badges = [];

    protected $queryString = ['active', 'banned'];

    public function assignBadges($user_id)
    {
        if (empty($this->user_badges)) {
            $this->notification()->error(
                $title = __('Error!'),
                $description = __('Please select at least one badge.')
            );

            return false;
        }
        if (auth()->user()->can('assign-badges')) {
            $user = User::findOrFail($user_id);
            $user->badges()->attach($this->user_badges);
            $this->notification()->success(
                $title = __('Success!'),
                $description = __(':record has been updated.', ['record' => __('User')])
            );
        }
    }

    public function mount()
    {
        if (auth()->user()->cant('read-users')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }
    }

    public function removeRecord($id)
    {
        if (auth()->user()->cant('delete-users')) {
            return redirect()->to(url()->previous())->with('error', __('You do not have permissions to perform this action.'));
        }
        $user = User::findOrFail($id);
        if ($user->threads()->count() || $user->replies()->count()) {
            $this->notification()->error(
                $title = __('Failed!'),
                $description = __('Failed to delete :record. It has threads or replies.', ['record' => __('Role')])
            );

            return false;
        }
        if ($user->delete()) {
            $this->notification()->success(
                $title = __('Success!'),
                $description = __(':record has been deleted.', ['record' => __('User')])
            );
        } else {
            $this->notification()->error(
                $title = __('Failed!'),
                $description = __('Failed to delete :record.', ['record' => __('User')])
            );
        }
    }

    public function render()
    {
        $users = User::query()->with('roles:id,name');
        if ($this->active == 'yes') {
            $users->active();
        } elseif ($this->active == 'no') {
            $users->inactive();
        }
        if ($this->banned == 'yes') {
            $users->banned();
        } elseif ($this->banned == 'no') {
            $users->notBanned();
        }

        return view('livewire.user.index', [
            'users' => $users->latest()->paginate(), 'badges' => Badge::latest()->get(),
        ])->layoutData(['title' => __('Users')]);
    }
}
