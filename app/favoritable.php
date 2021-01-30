<?php


namespace App;


use App\Models\Favorite;
use App\Models\Reply;

trait favoritable
{

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
}
