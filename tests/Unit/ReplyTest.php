<?php

namespace Tests\Unit;

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reply = create(Reply::class);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $this->assertInstanceOf('App\Models\User', $this->reply->user);
    }

    /** @test */
    public function it_belongs_to_a_thread()
    {
        $this->assertInstanceOf('App\Models\Reply', $this->reply->thread);
    }
}
