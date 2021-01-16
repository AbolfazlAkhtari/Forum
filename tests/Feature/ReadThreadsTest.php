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
        $threadInChannel = Thread::factory()->create(['channel_id' => $channel->id, 'title' => '1111111111']);
        $threadNotInChanel = Thread::factory()->create(['title' => '22222222222']);

        $this->get(route('threads.channel', $channel))
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChanel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username() {
        $this->signIn($user = User::factory()->create(['name' => 'JohnDoe']));
        $threadByJohn = Thread::factory()->create(['user_id' => $user]);
        $threadNotByJohn = Thread::factory()->create();

        $this->get(route('threads.index').'?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn);
    }
}
