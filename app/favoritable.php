<?php


namespace App;


use App\Models\Favorite;
use App\Models\Reply;

trait favoritable
{
    protected static function bootfavoritable()
    {
        if (auth()->guest()) return;

        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }
    // when you create a static function named (boot + trait name) in a trait,
    // it's works just like the boot method for every model that is using this trai

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->user()->id)->count();
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->user()->id];

        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function unFavorite()
    {
        $attributes = ['user_id' => auth()->user()->id];

        return $this->favorites()->where($attributes)->delete();
    }
}
