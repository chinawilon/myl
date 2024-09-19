<?php

namespace App\Jobs;

use App\Repositories\UserLoginLogRepository;
use Prettus\Validator\Exceptions\ValidatorException;

class LoginSuccessJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected int $userId, protected string $ip)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws ValidatorException
     */
    public function handle(UserLoginLogRepository $userLoginLogRepository)
    {
        $userLoginLogRepository->create([
            'user_id'=> $this->userId,
            'ip'=> $this->ip,
        ]);
    }
}
