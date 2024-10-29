<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Notifications\UserNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNotifications implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public User $user,
        public $thread,
        public $action = 'created',
    ) {
    }

    public function handle()
    {
        $settings = site_config();
        if ($this->action == 'conversation-started' || $this->action == 'conversation-replied') {
            $user = $this->thread->receiver_id != $this->user->id ? $this->thread->receiver : $this->thread->user;
            $user->notify(new UserNotification(['title' => __('You have received a message.'), 'text' => __(':user has send you a new message.', ['user' => $this->user->name]), 'link' => route('conversations', ['conversation' => $this->thread->id])]));

            return true;
        }

        $forum = $settings['name'] ?? config('app.name');
        $link = route('threads.show', $this->thread->slug);
        if ($notifyTo = ($settings['notifications'] ?? null)) {
            if ($this->action == 'replied') {
                $title = __('A thread (:title) is replied.', ['title' => $this->thread->title]);
                $text = __('A thread has been replied at the :forum.', ['forum' => $forum]);
            } elseif ($this->action == 'approved') {
                $title = __('A thread (:title) has been approved.', ['title' => $this->thread->title]);
                $text = __('A thread (:title) has be approved by (:user) at the :forum.', ['title' => $this->thread->title, 'user' => $this->thread->approvedBy->name, 'forum' => $forum]);
            } elseif ($this->action == 'flagged') {
                $title = __('A thread (:title) has been flagged.', ['title' => $this->thread?->title]);
                $text = __('A thread (:title) has be flagged by (:user) at the :forum.', ['title' => $this->thread->title, 'user' => $this->user->name, 'forum' => $forum]);
            } elseif ($this->action == 'flagged_reply') {
                $title = __('A reply of thread (:title) has been flagged.', ['title' => $this->thread?->title]);
                $text = __('A reply of thread (:title) has be flagged by (:user) at the :forum.', ['title' => $this->thread->title, 'user' => $this->user->name, 'forum' => $forum]);
            } else {
                $title = __('A thread (:title) created.', ['title' => $this->thread->title]);
                $text = __('A new thread has be created at the :forum.', ['forum' => $forum]);
            }

            if (! $this->thread->approved) {
                $title = __('A thread (:title) requires approval.', ['title' => $this->thread->title]);
                $text = __('This thread requires approval before it can show up for public.');
            }

            $users = match ($notifyTo) {
                'super'     => User::role('super')->get(),
                'admin'     => User::role(['super', 'admin'])->get(),
                'moderator' => User::role(['super', 'admin', 'moderator'])->get(),
            };

            if ($users) {
                foreach ($users as $user) {
                    // if ($this->user->id != $user->id) {
                    $user->notify(new UserNotification(['title' => $title, 'text' => $text, 'link' => $link]));
                    // }
                }
            }
        }

        if ($this->thread->approved && $this->thread->user->approvedFollowers) {
            if ($this->action == 'replied') {
                $favTitle = __('Member you followed has replied a thread (:title).', ['title' => $this->thread->title]);
                $favText = __('A member you are following has replied a thread at the :forum.', ['forum' => $forum]);
            } else {
                $favTitle = __('Member you followed has create thread (:title).', ['title' => $this->thread->title]);
                $favText = __('A member you are following has create a thread at the :forum.', ['forum' => $forum]);
            }
            foreach ($this->thread->user->approvedFollowers as $user) {
                if ($this->user->id != $user->id) {
                    $user->notify(new UserNotification(['link' => $link, 'title' => $favTitle, 'text' => $favText]));
                }
            }
        }

        if ($this->action == 'approved') {
            $title = __('A thread (:title) has been approved.', ['title' => $this->thread->title]);
            $text = __('A thread has be approved at the :forum.', ['forum' => $forum]);
            $this->thread->user->notify(new UserNotification(['link' => $link, 'title' => $favTitle, 'text' => $favText]));
        }
    }
}
