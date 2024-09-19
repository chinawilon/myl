<?php

namespace App\Http\Controllers;

use App\Criteria\RoleCriteria;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
                ->with('user:id,name,email')
                ->get()
        );
    }

    /**
     * 编辑谋篇文章
     *
     * @param $id
     * @param Request $request
     * @param PostRepository $postRepository
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function edit($id, Request $request, PostRepository $postRepository): JsonResponse
    {
        $payload = $this->validate($request, [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);
        /**@var $post Post */
        $post = $postRepository->find($id);
        $this->authorize('edit', $post);
        $post->update($payload);
        return response()->json($post);
    }


    /**
     * 创建谋篇文章
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $payload = $this->validate($request, [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);
        return response()->json(
            $request->user()->posts()->create($payload)
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
