<?php

namespace MohamadSaleh\Reviewable\Tests\Units;

use MohamadSaleh\Reviewable\DTO\ReviewData;
use MohamadSaleh\Reviewable\Tests\Models\Post;
use MohamadSaleh\Reviewable\Tests\Models\User;
use MohamadSaleh\Reviewable\Tests\TestCase;

/**
 * @internal
 */
class ReviewableTest extends TestCase
{
    /**
     * @test
     */
    function it_can_check_post_has_review_from_user()
    {
        $user = User::query()->create(['name' => 'user']);
        $post = Post::query()->create(['user_id' => $user->id, 'content' => 'some text']);

        $user->addReview($post, ReviewData::fromArray(['rating' => 5, 'body' => 'a good post']));
        $result = $post->hasBeenReviewedBy($user);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    function it_can_get_avg_review_for_post()
    {
        $user1 = User::query()->create(['name' => 'user1']);
        $user2 = User::query()->create(['name' => 'user2']);
        $post = Post::query()->create(['user_id' => $user1->id, 'content' => 'some text']);

        $user1->addReview($post, ReviewData::fromArray(['rating' => 5, 'body' => 'a good post']));
        $user2->addReview($post, ReviewData::fromArray(['rating' => 1, 'body' => 'a good post']));
        $result = $post->avgRating();

        $this->assertEquals(3, $result);
    }
}