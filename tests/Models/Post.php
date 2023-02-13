<?php

namespace MohamadSaleh\Reviewable\Tests\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use MohamadSaleh\Reviewable\Traits\Reviewable;

class Post extends Model
{
    use HasUuids, Reviewable;

    protected $table = 'posts';

    protected $fillable = [
        'id',
        'content',
        'user_id'
    ];
}
