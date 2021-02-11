<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->post(route('replies.store', [1, 1] , []))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $thread = create(Thread::class);
        $reply = make(Reply::class);
        $user = create(User::class);
        $this->signIn($user);

        $this->post(route('replies.store', $thread), $reply->toArray());

        $this->get(route('threads.show', [$thread->channel, $thread]))
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);
        $user = create(User::class);
        $this->signIn($user);

        $this->post(route('replies.store', $thread), $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function  authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->user()->id]);

        $this->delete(route('replies.destroy', $reply));

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, Activity::where('subject_type', 'App\Models\Reply')->count());
    }

    /** @test */
    public function unauthorized_users_can_not_delete_replies()
    {
        $reply = create(Reply::class);

        $this->delete(route('replies.destroy', $reply))->assertRedirect(route('login'));

        $user = create(User::class);
        $this->signIn($user);
        $this->delete(route('replies.destroy', $reply))->assertStatus(403);
    }
}
