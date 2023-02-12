<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body',
        'image',
    ];

    protected $appends = [
        'created_at_human',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(static function (Post $post) {
            $string = htmlspecialchars_decode($post->body);

            preg_match_all('/(\B|\b)(?<hashtag>#[a-zA-Z]+\b)/', $string, $match);
            foreach (data_get($match, 'hashtag', []) as $value) {
                Hashtag::create([
                    'post_id' => $post->id,
                    'slug' => substr($value, 1),
                ]);
            }
//            preg_match_all('/(\B|\b)(?<user>@[a-zA-Z]+\b)/', $string, $match);
//            foreach (data_get($match, 'user', []) as $value) {
//                if ($user = User::query()->where('username', substr($value, 1))->first()) {
//                    // possible notification
//                }
//            }
        });
    }

    public function getCreatedAtHumanAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getLikedByCurrentUserAttribute(): bool
    {
        return $this->likes
            ->pluck('user_id')
            ->contains(auth()->id());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function hashtags(): HasMany
    {
        return $this->hasMany(Hashtag::class);
    }

    public function getBodyHtmlAttribute(): string
    {
        $string = htmlspecialchars_decode($this->body);

        preg_match_all('/(\B|\b)(?<hashtag>#\S+\b)/', $string, $match);
        foreach (data_get($match, 'hashtag', []) as $value) {
            $string = str_replace($value, '<Link href="' . route('hashtag', substr($value, 1)) . '"><span class="text-green-600 cursor-pointer">' . $value . '</span></Link>', $string);
        }
//        preg_match_all('/(\B|\b)(?<user>@\S+\b)/', $string, $match);
//        foreach (data_get($match, 'user', []) as $value) {
//            if ($user = User::query()->where('username', substr($value, 1))->first()) {
//                $string = str_replace($value, '<Link href="' . route('profile-page', $user) . '"><span class="text-li-red cursor-pointer">' . $value . '</span></a>', $string);
//            }
//        }

        return nl2br($string);
    }

    public function scopeSortByQueryParam(Builder $query, Request $request): Builder
    {
        // IF request has s parameter
        return $query->when($request->has('s'), static function ($query) use ($request) {
            // THEN order by s parameter
            return $query->orderByDesc($request->get('s'));
        }, static function ($query) {
            // ELSe order by created_at
            return $query->orderByDesc('created_at');
        });
    }
}
