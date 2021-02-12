<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->reply = create(Reply::class);
    }


    /** @test */
    public function guests_can_not_favorite_anything()
    {
        $this->post(route('replyFavorites.store', $this->reply->id))
            ->assertRedirect(route('login'));;
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn(create(User::class));
        $this->post(route('replyFavorites.store', $this->reply->id));
        $this->assertCount(1, $this->reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_favorite_a_reply_only_once()
    {
        $this->signIn();
        $this->post(route('replyFavorites.store', $this->reply->id));
        $this->assertEquals(1, Favorite::count());
        $this->post(route('replyFavorites.store', $this->reply->id));
        $this->assertEquals(0, Favorite::count());
    }
}
