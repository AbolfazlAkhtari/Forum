<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $this->assertInstanceOf('App\Models\User', $this->thread->user);
    }

    /** @test */
    public function it_belongs_to_a_channel()
    {
        $this->assertInstanceOf('App\Models\Channel', $this->thread->channel);
    }

    /** @test */
    public function it_has_many_replies()
    {
        $replies = create(Reply::class, ['thread_id' => $this->thread->id]);
        $this->assertTrue($this->thread->replies->contains($replies));
    }

    /** @test */
    public function it_can_make_a_reply()
    {
        $reply = $this->thread->replies()->create([
            'body' => 'foobar',
            'user_id' => '1'
        ]);
        $this->assertEquals('foobar', $reply->body);
    }
}
