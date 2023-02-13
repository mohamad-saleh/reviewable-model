<?php

namespace MohamadSaleh\Reviewable\Tests\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MohamadSaleh\Reviewable\Traits\Reviewer;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasUuids, Reviewer, HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'name'
    ];
}
