<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Enumerable;
use Illuminate\Support\LazyCollection;
use App\Traits\FollowerTrait;
use App\Models\Followable;
use function config;

/**
 * @property Collection $followables
 * @property Collection $followers
 */
trait FollowableTrait
{
    public function isFollowedBy(Model $follower): bool
    {
        if (!in_array(FollowerTrait::class, \class_uses($follower))) {
            throw new \InvalidArgumentException('The model must use the Follower trait.');
        }

        if ($this->relationLoaded('followables')) {
            return $this->followables->contains($follower);
        }

        return $this->followables()->accepted()->followedBy($follower)->exists();
    }

    public function scopeOrderByFollowersCount($query, string $direction = 'desc')
    {
        return $query->withCount('followers')->orderBy('followers_count', $direction);
    }

    public function scopeOrderByFollowersCountDesc($query)
    {
        return $this->scopeOrderByFollowersCount($query, 'desc');
    }

    public function scopeOrderByFollowersCountAsc($query)
    {
        return $this->scopeOrderByFollowersCount($query, 'asc');
    }

    public function followables(): HasMany
    {
        /**
         * @var Model $this
         */
        return $this->hasMany(
            config('follow.followables_model', Followable::class),
            'followable_id',
        )->where('followable_type', $this->getMorphClass());
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            config('follow.followables_table', 'followables'),
            'followable_id',
            config('follow.user_foreign_key', 'user_id')
        )->where('followable_type', $this->getMorphClass());
    }
}