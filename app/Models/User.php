<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getFollowedByCurrentUserAttribute(): bool
    {
        return $this->followers
            ->pluck('id')
            ->contains(auth()->id());
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /*
     * The users that the current user follows
     */
    public function follows(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'follow_user', 'user_id', 'follow_user_id');
    }

    /*
     * The users that follow the current user
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(__CLASS__, 'follow_user', 'follow_user_id', 'user_id');
    }
}
