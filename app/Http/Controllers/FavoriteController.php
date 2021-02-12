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
    public function toggle(Reply $reply)
    {
        if (! $reply->favorites()->where('user_id', auth()->user()->id)->exists()) {
            $reply->favorite();
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
            $reply->unFavorite();
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
