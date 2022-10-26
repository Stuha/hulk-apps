<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Enumerable;
use Illuminate\Support\LazyCollection;
use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use App\Traits\FollowableTrait;
use App\Models\Followable;
use Carbon\Carbon;

use function abort_if;
use function class_uses;
use function collect;
use function in_array;
use function is_array;
use function iterator_to_array;

/**
 * @property Collection $followings
 */
trait FollowerTrait
{
    #[ArrayShape(['pending' => "mixed"])]
    public function follow(Model $followable): Model
    {
        if (!in_array(FollowableTrait::class, class_uses($followable))) {
            throw new InvalidArgumentException('The followable model must use the Followable trait.');
        }

        $followable = $this->followings()->updateOrCreate([
            'followable_id' => $followable->getKey(),
            'followable_type' => $followable->getMorphClass(),
            'followed_at' => Carbon::now()
        ]);

        return $followable;
    }

    public function unfollow(Model $followable): void
    {
        if (!in_array(FollowableTrait::class, class_uses($followable))) {
            throw new InvalidArgumentException('The followable model must use the Followable trait.');
        }
        $this->followings()->delete($followable->id);
    }

    public function followings(): HasMany
    {
        /**
         * @var Model $this
         */
        return $this->hasMany(
            config('follow.followables_model', Followable::class),
            config('follow.user_foreign_key', 'user_id'),
            $this->getKeyName()
        );
    }

    public function attachFollowStatus($followables, callable $resolver = null)
    {
        $returnFirst = false;

        switch (true) {
            case $followables instanceof Model:
                $returnFirst = true;
                $followables = collect([$followables]);
                break;
            case $followables instanceof LengthAwarePaginator:
                $followables = $followables->getCollection();
                break;
            case $followables instanceof Paginator:
            case $followables instanceof CursorPaginator:
                $followables = collect($followables->items());
                break;
            case $followables instanceof LazyCollection:
                $followables = collect(iterator_to_array($followables->getIterator()));
                break;
            case is_array($followables):
                $followables = collect($followables);
                break;
        }

        abort_if(!($followables instanceof Enumerable), 422, 'Invalid $followables type.');

        $followed = $this->followings()->get();

        $followables->map(function ($followable) use ($followed, $resolver) {
            $resolver = $resolver ?? fn ($m) => $m;
            $followable = $resolver($followable);

            if ($followable && in_array(FollowableTrait::class, class_uses($followable))) {
                
                $item = $followed->where('followable_id', $followable->getKey())
                                 ->where('followable_type', $followable->getMorphClass())
                                 ->first();

                $followable->setAttribute('followed_at', $item ? $item->created_at : null);
            }
        });

        return $returnFirst ? $followables->first() : $followables;
    }
}