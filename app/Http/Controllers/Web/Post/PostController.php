<?php

namespace App\Http\Controllers\Web\Post;

use App\Http\Controllers\Controller;
use DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Enums\PostCategory;
use App\Services\Post\PostService;
use App\Services\Twitter\TwitterService;
use App\Presenters\Web\Post\PostAndPaginateCommentPresenter;
use App\Presenters\Web\Post\PostLatestPresenter;

final class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
        private readonly TwitterService $twitterService,
        private readonly PostAndPaginateCommentPresenter $postAndPaginateCommentPresenter,
        private readonly PostLatestPresenter $postLatestPresenter,
    ) {
    }

    public function index(Request $request): View
    {
        // 選択しているゲームでフィルタ
        if (Auth::check()) {
            $gameId = Auth::user()->selected_game_id;
        } else {
            $gameId = session('selected_game_id');
        }

        $postFilters['post_category_id'] = $request->query('post_category_id');
        if ($request->query('sub_category_id')) {
            $postFilters['sub_category_id'] = $request->query('sub_category_id');
        }
        if (!empty($request->query('search'))) {
            $postFilters['search'] = $request->query('search');
        }
        $postFilters['game_id'] = $gameId;
        $page = $request->get('page', 1);
        $posts = $this->postService->paginatePosts($postFilters, 20, $page);

        $post_category_id = $request->query('post_category_id');

        return view('post.index', compact('posts', 'post_category_id'));
    }

    public function create(Request $request): View | RedirectResponse
    {
        //チーム募集掲示板の処理
        if (PostCategory::CATEGORY_TEAM_WANTED == $request->post_category_id) {
            $team_id = $request->query('team_id');
        } else {
            $team_id = null;
        }

        $post_category_id = $request->query('post_category_id');
        return view('post.create', compact('post_category_id', 'team_id'));
    }

    public function store(Request $request): RedirectResponse
    {
        // 選択しているゲームでフィルタ
        if (Auth::check()) {
            $gameId = Auth::user()->selected_game_id;
            // ユーザーIDをアドミンでは選べるようにする
            if (empty($request->user_id)) {
                $request->merge(['user_id' => Auth::guard()->user()->id]);
            }
        } else {
            $gameId = session('selected_game_id');
            $request->merge(['user_id' => null]);
        }
        $request->merge(['is_personal' => 0]);
        $request->merge(['team_id' => $request->team_id]);
        $postAttrs = $request->all();
        $postAttrs['game_id'] = $gameId;
        foreach ($postAttrs as $key => $value) {
            if (is_numeric($value)) {
                $postAttrs[$key] = (int) $value;
            }
        }

        DB::transaction(function () use ($postAttrs) {
            $post = $this->postService->createPost($postAttrs);
            $this->twitterService->tweetByStorePost($post);
        });

        return redirect('/post?post_category_id=' . $request->input('post_category_id'))->with('flash_message', '新規投稿を行いました');
    }

    public function show(Request $request, int $postId): View
    {
        try {
            $page = $request->get('page', 1);
            $post = $this->postAndPaginateCommentPresenter->getResponse(
                $this->postService->findPostAndPaginatePostComments($postId, 50, $page)
            );
            $postLatests = $this->postLatestPresenter->getResponse(
                $this->postService->findAllPosts([])
            );
            return view('post.show', compact('post', 'postLatests'));
        } catch (Exception $e) {
            if ($e->getCode() !== 403) {
                report($e);
            }
            \Log::error([
                "ポケカ掲示板の表示機能バグ：PostController.php@show",
                'IP Address' => $request->ip(),
                'Headers' => $request->header('User-Agent'),
                $postId,
                $request->all()
            ]);
            abort($e->getCode());
        }
    }
}
