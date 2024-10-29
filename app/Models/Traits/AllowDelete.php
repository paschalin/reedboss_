<?php

namespace App\Models\Traits;

trait AllowDelete
{
    public function canDelete()
    {
        $user = auth()->user();
        if ($user) {
            $model = get_class();
            $permission = 'delete-' . (str($model)->contains('Thread') ? 'threads' : 'replies');
            if ($user->can($permission)) {
                return true;
            }

            if (static::$settings['allow_delete'] ?? null) {
                return static::$settings['allow_delete'] == -1 || $this->created_at->diffInMinutes(now()) <= static::$settings['allow_delete'];
            }
        }

        return false;
    }

    public function canEdit()
    {
        $user = auth()->user();
        if ($user) {
            $model = get_class();
            $permission = 'update-' . (str($model)->contains('Thread') ? 'threads' : 'replies');
            if ($user->can($permission)) {
                return true;
            }

            if (static::$settings['allow_delete'] ?? null) {
                return static::$settings['allow_delete'] == -1 || $this->created_at->diffInMinutes(now()) <= static::$settings['allow_delete'];
            }
        }

        return false;
    }
}
