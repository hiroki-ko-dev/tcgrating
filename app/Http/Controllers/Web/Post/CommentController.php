<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Post;

use App\Http\Controllers\Controller;
use App\Services\Post\PostService;
use App\Services\Post\PostCommentService;
use App\Services\EventService;
use App\Services\DuelService;
use App\Services\User\UserService;
use App\Services\TwitterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Mail;
use Exception;
use App\Mail\PostCommentEventMail;
use App\Mail\PostCommentDuelMail;
use App\Presenters\Web\Post\Comment\CreatePresenter;

final class CommentController extends Controller
{
    public function __construct(
        protected PostService $postService,
        protected PostCommentService $postCommentService,
        protected EventService $eventService,
        protected DuelService $duelService,
        protected UserService $userService,
        protected TwitterService $twitterService,
        protected CreatePresenter $createPresenter,
    ) {
    }

    public function create(Request $request)
    {
        try {
            $postId = $request->post_id ? (int)$request->post_id : null;
            $commentId = $request->comment_id ? (int)$request->comment_id : null;
            $data = $this->createPresenter->getResponse(
                $this->postCommentService->getReferralPostOrComment($postId, $commentId)
            );
            $referralPost = $data->post;
            $referralComment = $data->comment;
            $replyComments = $data->replyComments;

            return view('post.comment.create', compact('referralPost', 'referralComment', 'replyComments'));
        } catch (Exception $e) {
            if ($e->getCode() !== 403) {
                report($e);
            }
            \Log::error("ポケカ掲示板の返信表示機能バグ：CommentController.php@create");
            \Log::error($request->all());
            abort($e->getCode());
        }
    }

    public function store(Request $request)
    {
        $commentAttrs = $request->all();
        foreach ($commentAttrs as $key => $value) {
            if (is_numeric($value)) {
                $commentAttrs[$key] = (int) $value;
            }
        }
        $postComment = DB::transaction(function () use ($commentAttrs) {
            $postComment = $this->postCommentService->makeReplyComment($commentAttrs);
            $post = $postComment->post;
            //書き込みがイベント掲示板ならコメントがついたことをコメント者以外にメール通知
            if ($post->post_category_id == \App\Models\PostCategory::CATEGORY_EVENT) {
                $event = $this->eventService->findEventWithUserAndDuel($post->event_id);
                //コメントをした本人以外に通知を送る
                $eventUsers = $event->eventUsers->whereNotIn('user_id', [Auth::id()]);
                $emails = [];
                $usersForTweet  = [];
                foreach ($eventUsers as $eventUser) {
                    if (!is_null($eventUser->user->email)) {
                        $emails[] = $eventUser->user->email;
                    }
                    if (!is_null($event->user->twitter_id)) {
                        $usersForTweet[] = $eventUser->user;
                    }
                }

                // 対戦作成者にtwitterアカウントがあれば通知
                if (!is_null($usersForTweet)) {
                    $this->twitterService->tweetByEventPostNotice($event, $usersForTweet);
                }

                if (!empty($emails)) {
                    Mail::send(new PostCommentEventMail($emails, $post, $postComment));
                }
            //書き込みが決闘掲示板ならコメントがついたことをコメント者以外にメール通知
            } elseif ($post->post_category_id == \App\Models\PostCategory::CATEGORY_DUEL) {
                $duel = $this->duelService->getDuel($post->duel_id);
                //コメントをした本人以外に通知を送る
                $duelUsers = $duel->duelUsers->whereNotIn('user_id', [Auth::id()]);
                $emails = [];
                $usersForTweet  = [];
                foreach ($duelUsers as $duelUser) {
                    if (!is_null($duelUser->user->email)) {
                        $emails[] = $duelUser->user->email;
                    }
                    if (!is_null($duelUser->user->twitter_id)) {
                        $usersForTweet[] = $duelUser->user;
                    }
                }

                // 対戦作成者にtwitterアカウントがあれば通知
                if (!is_null($usersForTweet)) {
                    $this->twitterService->tweetByDuelPostNotice($duel, $usersForTweet);
                }

                if (!empty($emails)) {
                    Mail::send(new PostCommentDuelMail($emails, $post, $postComment));
                }
            }
            return $postComment;
        });

        return redirect('/post/' . $postComment->post->id)->with('flash_message', 'コメントを行いました');
    }
}
