<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->withoutExceptionHandling();
        $this->user = create(User::class);
    }

    /** @test */
    public function a_user_has_a_profile()
    {
        $this->get('/profile/'.$this->user->name)
            ->assertSee($this->user->name);
    }

    /** @test */
    public function profiles_display_all_threads_created_by_the_associated_user()
    {
        $this->signIn($this->user);
        $thread = create(Thread::class, ['user_id' => $this->user->id]);

        $this->get('/profile/'.$this->user->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}