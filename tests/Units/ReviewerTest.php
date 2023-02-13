<?php

namespace MohamadSaleh\Reviewable\Tests\Units;

use MohamadSaleh\Reviewable\DTO\ReviewData;
use MohamadSaleh\Reviewable\Tests\Models\Post;
use MohamadSaleh\Reviewable\Tests\Models\User;
use MohamadSaleh\Reviewable\Tests\TestCase;

/**
 * @internal
 */
class ReviewerTest extends TestCase
{
    /**
     * @test
     */
    function it_can_user_add_review_to_post()
    {
        $user = User::query()->create(['name' => 'user']);
        $post = Post::query()->create(['user_id' => $user->id, 'content' => 'some text']);

        $user->addReview($post, ReviewData::fromArray(['rating' => 5, 'body' => 'a good post']));

        $this->assertDatabaseCount('reviews', 1);
    }

    /**
     * @test
     */
    function it_can_user_update_existing_review_to_post()
    {
        $user = User::query()->create(['name' => 'user']);
        $post = Post::query()->create(['user_id' => $user->id, 'content' => 'some text']);

        $user->addReview($post, ReviewData::fromArray(['rating' => 5, 'body' => 'a good post']));
        $result = $user->updateReview($post, ReviewData::fromArray(['rating' => 1, 'body' => 'a bad post']));

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    function it_can_user_remove_existing_review_to_post()
    {
        $user = User::query()->create(['name' => 'user']);
        $post = Post::query()->create(['user_id' => $user->id, 'content' => 'some text']);

        $review = $user->addReview($post, ReviewData::fromArray(['rating' => 5, 'body' => 'a good post']));
        $result = $user->removeReview($post);
        $this->assertTrue($result);
    }
}