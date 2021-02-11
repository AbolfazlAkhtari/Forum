<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * FavoriteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Reply $reply
     */
    public function store(Reply $reply)
    {
        if (! $reply->favorites()->where('user_id', auth()->user()->id)->exists()) {
            $reply->favorites()->create(['user_id' => auth()->user()->id]);
        }

        return back()->with('success', 'Favorited!');
    }
}
