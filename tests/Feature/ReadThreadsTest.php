<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    /** @test */
    public function a_user_can_read_all_threads()
    {
        $this->get(route('threads.index'))
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $this->get(route('threads.show', [$this->thread->channel, $this->thread]))
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);
        $this->get(route('threads.show', [$this->thread->channel, $this->thread]))
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_channel()
    {
        $channel = Channel::factory()->create();
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id, 'title' => '1111111111']);
        $threadNotInChanel = create(Thread::class, ['title' => '22222222222']);

        $this->get(route('threads.channel', $channel))
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChanel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username() {
        $this->signIn($user = create(User::class, ['name' => 'JohnDoe']));
        $threadByJohn = create(Thread::class, ['user_id' => $user]);
        $threadNotByJohn = create(Thread::class);

        $this->get(route('threads.index').'?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create(Thread::class);
        $threadWithThreeReplies = create(Thread::class);
        $threadWithNoReplies = $this->thread;
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);
        create(Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

    /** @test */
    public function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $threadWithReply = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithReply->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response);
    }
}
