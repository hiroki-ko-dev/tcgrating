<?php

namespace App\Http\Controllers\Web\Post;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use App\Enums\PostCategory;
use App\Services\Post\PostService;
use App\Services\TwitterService;
use App\Presenters\Web\Post\PostAndPaginateCommentPresenter;

class PostController extends Controller
{
    public function __construct(
        private PostService $postService,
        private TwitterService $twitterService,
        private PostAndPaginateCommentPresenter $postAndPaginateCommentPresenter,
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

        DB::transaction(function () use ($postAttrs) {
            $post = $this->postService->createPost($postAttrs);
            $this->twitterService->tweetByStorePost($post);
        });

        return redirect('/post?post_category_id=' . $request->input('post_category_id'))->with('flash_message', '新規投稿を行いました');
    }

    public function show(Request $request, int $post_id): View
    {
        $page = $request->get('page', 1);
        $post = $this->postAndPaginateCommentPresenter->getResponse(
            $this->postService->findPostAndPaginatePostComments($post_id, 50, $page)
        );

        return view('post.show', compact('post'));
    }
}
