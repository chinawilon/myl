<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function before(User $user, $ability): ?bool
    {
        if ( $user->isAdmin() ) {
            return true;
        }
        return null;
    }

    public function edit(User $user, Post $post): bool
    {
        return $user->id == $post->user_id;
    }

    public function view(User $user, Post $post): bool
    {
        return $user->id == $post->user_id;
    }
}
