<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = create(User::class);
    }

    /** @test */
    public function it_has_many_threads()
    {
        $threads = create(Thread::class, ['user_id' => $this->user->id]);
        $this->assertTrue($this->user->threads->contains($threads));
    }

    /** @test */
    public function it_has_many_activities()
    {
        $activity = Activity::create([
            'user_id' => $this->user->id,
            'subject_type' => 'App\Models\Thread',
            'subject_id' => 1,
            'type' => 'thread_created',
        ]);
        $this->assertTrue($this->user->activities->contains($activity));
    }
}
