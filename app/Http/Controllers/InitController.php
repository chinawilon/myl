<?php

namespace App\Http\Controllers;

use App\Service\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class InitController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function init(Request $request): JsonResponse
    {
        $payload = $this->validate($request, [
            'device_id' => 'required|string|max:255',
            'pf_game_id' => 'required|integer',
            'package_id' => 'required|integer',
        ]);
        // 写入缓存
        $tokenService = new TokenService($payload['device_id'], $payload['pf_game_id'], $payload['package_id']);
        Cache::put('init:'.$tokenService->token, $tokenService);
        return response()->json(['code' => 1, 'data' => ['token' => $tokenService->token]]);
    }
}
