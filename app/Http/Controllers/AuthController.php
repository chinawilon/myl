<?php

namespace App\Http\Controllers;

use App\Events\LoginFailedEvent;
use App\Exceptions\ApiException;
use App\Jobs\LoginSuccessJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * 登陆
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email',
            'password'=> 'required|string|min:6',
        ]);
        /**@var $user User*/
        $user = User::where('email', $credentials['email'])->first();
        if (! $user?->checkPassword($credentials['password'])) {
            event(new LoginFailedEvent($credentials, $request->ip()));
            throw new ApiException(ApiException::ERROR_USER_NOT_FOUND);
        }
        $user->saveLoginSuccess($request->ip());
        $this->dispatch(
            (new LoginSuccessJob($user->id, $request->ip()))
                ->onQueue('login-success')
        );
        return response()->json($user);
    }
}
