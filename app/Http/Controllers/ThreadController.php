<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * ThreadController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel|null $channel
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel = null, ThreadFilters $filters)
    {
        $threads = $this->getThreads($filters, $channel);
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->user()->id,
            'channel_id' => $request->channel_id
        ]);

        return redirect()->route('threads.show', ['channel' => $thread->channel, 'thread' => $thread]);
    }

    /**
     * Display the specified resource.
     *
     * @param Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Thread $thread)
    {
        $replies = $thread->replies()->paginate(20);
        return view('threads.show', compact('thread', 'replies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param ThreadFilters $filters
     * @param Channel|null $channel
     * @return mixed
     */
    protected function getThreads(ThreadFilters $filters, ?Channel $channel)
    {
        $threads = Thread::latest()->filter($filters);
        if ($channel != null) {
            $threads = $threads->where('channel_id', $channel->id);
        }
        $threads = $threads->get();
        return $threads;
    }
}
