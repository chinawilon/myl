<?php

namespace App\Criteria;

use App\Models\User;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class RoleCriteria implements CriteriaInterface
{
    public function __construct(protected User $user, protected string $field = 'user_id')
    {
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if ( $this->user->isAdmin() ) {
            return $model;
        }
        return $model->where($this->field, $this->user->id);
    }
}
