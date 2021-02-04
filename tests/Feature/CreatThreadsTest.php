<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function publishThread($override = [])
    {
        $thread = make(Thread::class, $override);
        $user = create(User::class);
        $this->signIn($user);

        return $this->post(route('threads.store'), $thread->toArray());
    }

    /** @test */
    public function unauthenticated_users_may_not_create_threads()
    {
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));
        $this->post(route('threads.store'), [])
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_make_new_threads()
    {
        $thread = make(Thread::class);
        $user = create(User::class);
        $this->signIn($user);

        $this->post(route('threads.store'), $thread->toArray());

        $this->get(route('threads.show', [$thread->channel, Thread::first()]))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
        // Thread::first == Last Thread (We have only one thread so it doesn't matter)
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        Channel::factory()->count(2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
        //999 is an example of a channel which doesn't exist
    }

    /** @test */
    public function  authorized_users_can_delete_threads()
    {
        $user = create(User::class);
        $this->signIn($user);
        $thread = create(Thread::class, ['user_id' => $user->id]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $this->delete(route('threads.destroy', $thread));

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function unauthorized_users_can_not_delete_threads()
    {
        $thread = create(Thread::class);

        $this->delete(route('threads.destroy', $thread))->assertRedirect(route('login'));

        $user = create(User::class);
        $this->signIn($user);
        $this->delete(route('threads.destroy', $thread))->assertStatus(403);
    }
}
