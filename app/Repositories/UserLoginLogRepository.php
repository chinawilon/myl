<?php

namespace App\Repositories;

use App\Models\UserLoginLog;

class UserLoginLogRepository extends Repository
{

    public function model(): string
    {
        return UserLoginLog::class;
    }
}
