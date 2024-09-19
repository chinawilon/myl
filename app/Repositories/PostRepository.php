<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends Repository
{
    protected $fieldSearchable = [
        'title' => 'like',
        'content' => 'like',
    ];

    public function model(): string
    {
        return Post::class;
    }
}
