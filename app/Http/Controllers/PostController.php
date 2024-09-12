<?php

namespace App\Http\Controllers;

use App\Criteria\RoleCriteria;
use App\Repositories\PostRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class PostController extends Controller
{
    /**
     * 文章列表
     *
     * @param Request $request
     * @param PostRepository $postRepository
     * @return JsonResponse
     * @throws RepositoryException
     */
    public function index(Request $request, PostRepository $postRepository): JsonResponse
    {
        return response()->json(
            $postRepository
                ->pushCriteria(new RequestCriteria($request))
                ->pushCriteria(new RoleCriteria($request->user()))
                ->get()
        );
    }

    /**
     * 查看谋篇文章
     *
     * @param $id
     * @param PostRepository $postRepository
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show($id, PostRepository $postRepository): JsonResponse
    {
        $post = $postRepository->find($id);
        $this->authorize('view', $post);
        return response()->json($post);
    }

    /**
     * 当前用户最新文章
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function latest(Request $request): JsonResponse
    {
        return response()->json(
            $request->user()->latestPost()->get()
        );
    }
}
