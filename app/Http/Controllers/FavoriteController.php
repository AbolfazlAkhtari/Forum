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
            if (\request()->wantsJson()) {
                return response([
                    'code' => 1,
                    'status' => 'Reply Favorited!',
                    'data' => $reply->favorites()->count(),
                    'class' => 'alert-info'
                ]);
            } else {
                return back()->with('info', 'Favorited!');
            }
        } else {
            $reply->favorites()->where('user_id', auth()->user()->id)->first()->delete();
            if (\request()->wantsJson()) {
                return response([
                    'code' => 0,
                    'status' => 'Favorited Removed!',
                    'data' => $reply->favorites()->count(),
                    'class' => 'alert-info'
                ]);
            } else {
                return back()->with('info', 'Favorited Removed!');
            }
        }
    }
}
