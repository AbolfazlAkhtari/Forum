<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * ReplyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Thread $thread
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Thread $thread, Request $request)
    {
        $request->validate(['body' => 'required']);

        Reply::create([
            'thread_id' => $thread->id,
            'body' => $request->body,
            'user_id' => auth()->user()->id,
        ]);

        return back()->with('success', 'Reply Published!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $request->validate(['body' => 'required']);

        $reply->update(['body' => $request->body]);

        if ($request->wantsJson()) {
            return response([
                'status' => 'Reply Updated!',
                'data' => $request->body
            ]);
        } else {
            return back()->with('success', 'Reply Edited');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (\request()->wantsJson()) {
            return response([
                'status' => 'Reply Deleted!',
            ]);
        } else {
            return back()->with('info', 'Reply Deleted!');
        }

        return back()->with('info', 'Reply Deleted!');
    }
}
