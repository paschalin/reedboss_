<?php

namespace App\Models\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait GroupPermission
{
    public function scopeAllowedCategory($query, $user = null)
    {
        $query->whereDoesntHave('category', function (Builder $query) {
            $userRole = auth()->user()?->roles()->first(['id', 'name']);
            $query->where('view_group', '>=', '1');
            if ($userRole) {
                if ($userRole->name == 'super') {
                    $query->whereNull('view_group')->orWhere('view_group', 0);
                } else {
                    $query->where('view_group', '!=', $userRole->id);
                }
            }
        });
    }

    public function scopeForMembers($query, $user = null)
    {
        $query->whereNull('group')->orWhere('group', -1)->orWhere('group', 0);
        if ($user || auth()->id()) {
            $query->orWhere('user_id', $user ? $user->id : auth()->id());
        }
    }

    public function scopeForPublic($query, $user = null)
    {
        $query->whereNull('group')->orWhere('group', -1);
        if ($user || auth()->id()) {
            $query->orWhere('user_id', $user ? $user->id : auth()->id());
        }
    }

    public function scopeForRole($query, $role_id, $user = null)
    {
        $query->whereNull('group')->orWhere('group', -1)->orWhere('group', 0)->orWhere('group', $role_id);
        if ($user || auth()->id()) {
            $query->orWhere($this->getTable() . '.user_id', $user ? $user->id : auth()->id());
        }
    }

    public function scopeForUser($query, $user = null)
    {
        $user = $user ?: auth()->user();
        if ($user) {
            if ($user && $role_id = $user->roles?->first()?->id) {
                return $query->forRole($role_id, $user);
            }

            return $query->forMembers($user);
        }

        return $query->forPublic($user);
    }
}
