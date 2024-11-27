<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Lang;

class ApiException extends Exception
{
    public const ERROR_USER_NOT_FOUND = 100001;
    public const ERROR_TOKEN_NOT_FOUND = 110001;

    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        $message = Lang::get('exception.'. $code);
        parent::__construct($message, $code, $previous);
    }
}
