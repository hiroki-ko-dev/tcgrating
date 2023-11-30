<?php

namespace App\Http\Controllers\Web\Post;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use App\Services\TwitterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    protected $postService;
    protected $twitterService;

    public function __construct(
        PostService $postService,
        TwitterService $twitterService
    ) {
        $this->postService = $postService;
        $this->twitterService = $twitterService;
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

    public function create(Request $request): View
    {
        //アカウント認証しているユーザーのみ新規作成可能
        if (!Auth::check()) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        //チーム募集掲示板の処理
        if (\App\Models\PostCategory::CATEGORY_TEAM_WANTED == $request->post_category_id) {
            $team_id = $request->query('team_id');
        } else {
            $team_id = null;
        }

        $post_category_id = $request->query('post_category_id');
        return view('post.create', compact('post_category_id', 'team_id'));
    }

    public function store(Request $request): RedirectResponse
    {
        //アカウント認証しているユーザーのみ新規作成可能
        $this->middleware('auth');

        //追加
        // 選択しているゲームでフィルタ
        $request->merge(['game_id' => Auth::user()->selected_game_id]);

        // ユーザーIDをアドミンでは選べるようにする
        if (empty($request->user_id)) {
            $request->merge(['user_id' => Auth::guard()->user()->id]);
        }

        $request->merge(['is_personal' => 0]);
        //チーム募集掲示板の処理
        $request->merge(['team_id' => $request->team_id]);

        DB::transaction(function () use ($request) {
            $post = $this->postService->createPost($request->all());
            $this->twitterService->tweetByStorePost($post);
        });

        return redirect('/post?post_category_id=' . $request->input('post_category_id'))->with('flash_message', '新規投稿を行いました');
    }

    public function show($post_id): View
    {
        $post     = $this->postService->findPostWithUser($post_id);
        $comments = $this->postService->findAllPostCommentWithUserByPostIdAndPagination($post_id, 100);

        return view('post.show', compact('post', 'comments'));
    }
}
