<?php

namespace App\Service;

use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

class TokenService
{
    public UuidInterface $token;

    public function __construct(
        public int $deviceId,
        public int $packageId,
        public int $pfGameId
    ) {
        $this->token = Str::uuid();
    }

    public function getPackageId(): int
    {
        return $this->packageId;
    }
}
