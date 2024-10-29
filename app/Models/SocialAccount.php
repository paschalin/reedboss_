<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = ['provider', 'provider_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
