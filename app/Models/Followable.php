<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use App\Events\Followed;
use App\Events\Unfollowed;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use function config;

/**
 * @property int|string $followable_id;
 * @property int|string $followable_type;
 * @property int|string $user_id;
 * @method HasMany of(Model $model)
 * @method HasMany followedBy(Model $model)
 * @method HasMany withType(string $type)
 */
class Followable extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => Followed::class,
        'deleted' => Unfollowed::class,
    ];

    protected $dates = ['accepted_at'];

    public function __construct(array $attributes = [])
    {
        $this->table = config('follow.followables_table', 'followables');

        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        self::saving(function ($follower) {
            $userForeignKey = config('follow.user_foreign_key', 'user_id');
            $follower->setAttribute($userForeignKey, $follower->{$userForeignKey} ?: auth()->id());

            if (config('follow.uuids')) {
                $follower->setAttribute($follower->getKeyName(), $follower->{$follower->getKeyName()} ?: (string) Str::orderedUuid());
            }
        });
    }

    public function followable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), config('follow.user_foreign_key', 'user_id'));
    }

    public function follower(): BelongsTo
    {
        return $this->user();
    }
}