<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->user()->id]);
        $activity = Activity::first();

        $this->assertDatabaseHas('activities', [
            'type' => 'thread_created',
            'user_id' => auth()->user()->id,
            'subject_id' => $thread->id,
            'subject_type' => 'App\Models\Thread'
        ]);

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = create(Reply::class);

        $this->assertEquals(2, Activity::count());
    }
}
