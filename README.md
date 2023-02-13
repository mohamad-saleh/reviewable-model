## Laravel Reviewable

User Review feature for Laravel Application.

## Installing

```shell
composer require mohamad-saleh/reviewable-model
```

### Configuration & Migrations

```php
php artisan vendor:publish
```

## Usage

### Traits

```php

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use MohamadSaleh\Reviewable\Traits\Reviewer;

class User extends Authenticatable
{
    use Reviewer;
}
```

```php
use Illuminate\Database\Eloquent\Model;
use MohamadSaleh\Reviewable\Traits\Reviewable;

class Post extends Model
{
    use Reviewable;
}
```

### FUNCTIONS

```php
$user = User::find(1);
$post = Post::find(2);

$user->addReview(
     $post, 
     ['title' => 'some text', 'body' => 'some text', 'rating' => 2]
);

$user->updateReview(
     $post, 
     ['body' => 'some text', 'rating' => 5]
);

$user->updateOrCreateReview(
     $post, 
     ['body' => 'some text', 'rating' => 5]
);


$user->removeReview($post);

$user->getReviewItems(Post::class)->get()

$user->hasReviewer($post);
$post->hasBeenReviewedBy($user);
```

#### Get object reviewers:

```php
foreach($post->reviewers as $user) {
    // echo $user->name;
}
```

### Aggregations

```php
// all
$user->reviews()->count();
$post->reviews()->count();

// with type
$user->reviewers()->withType(Post::class)->count();

```

## License

MIT
