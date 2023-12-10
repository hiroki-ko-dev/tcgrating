<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Models\Blog;
use App\Services\BlogService;
use App\Services\Post\PostService;
use App\Services\TwitterService;
use App\Presenters\Web\Post\PostLatestPresenter;

final class BlogController extends Controller
{
    public function __construct(
        private readonly BlogService $blogService,
        private readonly PostService $postService,
        private readonly TwitterService $twitterService,
        private readonly PostLatestPresenter $postLatestPresenter,
    ) {
    }

    public function index(Request $request): View
    {
        // 選択しているゲームでフィルタ
        if (Auth::check()) {
            $request->merge(['game_id' => Auth::user()->selected_game_id]);
        } else {
            $request->merge(['game_id' => session('selected_game_id')]);
        }

        // 管理者でなければ公開動画しか見せない
        if (!(Auth::check() && Auth::id() == 1)) {
            $request->merge(['is_released' => 1]);
        }

        $blogs =  $this->blogService->getBlogByPaginate($request, 20);

        return view('blog.index', compact('blogs'));
    }

    public function create(): View | RedirectResponse
    {
        // 選択しているゲームでフィルタ
        if (!Auth::check() || Auth::id() <> 1) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        return view('blog.create')->with(['blog' => new Blog()]);
    }

    public function store(Request $request): View | RedirectResponse
    {
        // 選択しているゲームでフィルタ
        if (!Auth::check() || Auth::id() <> 1) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        try {
            $request->merge(['user_id' => Auth::id()]);
            $request->merge(['game_id' => Auth::user()->selected_game_id]);

            $blog = DB::transaction(function () use ($request) {
                $blog = $this->blogService->makeBlog($request);
                if (!empty($request->is_tweeted)) {
                    if (empty($request->is_affiliate)) {
                        // 通常記事の場合
                        $this->twitterService->tweetByBlog($blog);
                    } else {
                        // アフェリエイトだった場合
                        $this->twitterService->tweetByAffiliate($blog);
                    }
                }
                return $blog;
            });
            return redirect('/blog/' . $blog->id)->with('flash_message', '記事を保存しました');
        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

    public function show(int $blogId): View
    {
        $blog = $this->blogService->getBlog($blogId);
        $preview = $this->blogService->getPreviewBlog($blogId - 1);
        $next = $this->blogService->getNextBlog($blogId + 1);

        $postLatests = $this->postLatestPresenter->getResponse(
            $this->postService->findAllPosts([])
        );

        return view('blog.show', compact('blog', 'preview', 'next', 'postLatests'));
    }

    public function edit(int $blogId): View | RedirectResponse
    {
        // 選択しているゲームでフィルタ
        if (!Auth::check() || Auth::id() <> 1) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        $blog = $this->blogService->getBlog($blogId);

        return view('blog.edit', compact('blog'));
    }

    public function update(Request $request, $blogId): View | RedirectResponse
    {
        // 選択しているゲームでフィルタ
        if (!Auth::check() || Auth::id() <> 1) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        $request->merge(['id' => $blogId]);
        DB::transaction(function () use ($request) {
            $blog = $this->blogService->saveBlog($request);
            if (!empty($request->is_tweeted)) {
                if (empty($request->is_affiliate)) {
                    // 通常記事の場合
                    $this->twitterService->tweetByBlog($blog);
                } else {
                    // アフェリエイトだった場合
                    $this->twitterService->tweetByAffiliate($blog);
                }
            }
        });
        return redirect('/blog/' . $blogId)->with('flash_message', '保存しました');
    }

    public function destroy(int $blogId): RedirectResponse
    {
        // 選択しているゲームでフィルタ
        if (!Auth::check() || Auth::id() <> 1) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        $this->blogService->deleteBlog($blogId);

        return redirect('/blog')->with('flash_message', '記事を削除しました');
    }
}
