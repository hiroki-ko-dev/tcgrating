<?php

namespace App\Services;
use App\Repositories\DuelRepository;
use App\Repositories\DuelUserRepository;
use App\Repositories\DuelUserResultRepository;
use App\Repositories\EventDuelRepository;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class DuelService
{
    protected $duel_repository;
    protected $duel_user_repository;
    protected $duel_user_result_repository;
    protected $event_duel_repository;
    protected $event_repository;
    protected $user_repository;

    public function __construct(DuelRepository $duel_repository,
                                DuelUserRepository $duel_user_repository,
                                DuelUserResultRepository $duel_user_result_repository,
                                EventDuelRepository $event_duel_repository,
                                EventRepository $event_repository,
                                UserRepository $user_repository)
    {
        $this->duel_repository              = $duel_repository;
        $this->duel_user_repository         = $duel_user_repository;
        $this->duel_user_result_repository  = $duel_user_result_repository;
        $this->event_duel_repository        = $event_duel_repository;
        $this->event_repository             = $event_repository;
        $this->user_repository              = $user_repository;
    }

    /**
     * シングル決闘の際のduel系作成
     * @param $request
     * @return mixed
     */
    public function createSingle($request)
    {
        $duel = $this->duel_repository->create($request);
        $request->merge(['duel_id' => $duel->id]);
        $this->duel_user_repository->create($request);
        $this->event_duel_repository->create($request);
        return $request;
    }

    public function createUser($request)
    {
        $this->duel_user_repository->create($request);
        return $request;
    }

    /**
     * シングルデュエル結果を格納
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function createSingleResult($request)
    {
        //すでに結果報告が終わっていないかチェック
        $duelUserResult = $this->duel_user_result_repository->findAllByDuelUserId($request->duel->duelUser->where('user_id',$request->user_id)->first()->id);

        //相手より2回以上報告が多くならない制御
        if($duelUserResult->isNotEmpty()){
            $myDuelUserResult    = $request->duel->duelUser->where('user_id',$request->user_id)->first()->duelUserResult;
            $otherDuelUserResult = $request->duel->duelUser->whereNotIn('user_id',[$request->user_id])->first()->duelUserResult;

            //すでに試合が終了した後の報告をエラーとする
            if($myDuelUserResult->count() == $otherDuelUserResult->count() && $request->duel->status <> \App\Models\Duel::READY){
                throw new \Exception("終了した試合です");
            }

            //相手の報告がない場合、今回報告をすると+2の差がつくのでエラー
            if($otherDuelUserResult->isEmpty()){
                throw new \Exception("相手の報告より2回以上多い報告はできません");
            }
            //自分がまだ報告していない場合は報告してOK
            if($myDuelUserResult->isNotEmpty()) {
                //すでに1回以上報告差がある場合に同じくエラー
                if ($myDuelUserResult->max('games_number') > $otherDuelUserResult->max('games_number')) {
                    throw new \Exception("相手の報告より2回以上多い報告はできません");
                }
                //MAX試合数分の報告を完了している場合のエラー
                if ($myDuelUserResult->max('games_number') === $request->duel->number_of_games) {
                    throw new \Exception("すでにあなたの報告は完了しています");
                }
            }
        }

        $duelUserResultObj = new \stdClass();
        $duelUserResultObj->duel_user_id = $request->duel->duelUser->where('user_id',$request->user_id)->first()->id ;
        $duelUserResultObj->duel_user_id = $request->duel->duelUser->where('user_id',$request->user_id)->first()->id ;
        if($duelUserResult->isEmpty()){
            $duelUserResultObj->games_number = 1;
        }else{
            $duelUserResultObj->games_number = $duelUserResult->count() + 1 ;
        }

        if($request->has('win')){
            $duelUserResultObj->result  = \App\Models\DuelUserResult::WIN ;
            $duelUserResultObj->ranking = 1 ;
            $duelUserResultObj->rating  = 1000 ;
        }elseif($request->has('lose')){
            $duelUserResultObj->result  = \App\Models\DuelUserResult::LOSE ;
            $duelUserResultObj->ranking = 2 ;
            $duelUserResultObj->rating  = -1000 ;
        }elseif($request->has('draw')){
            $duelUserResultObj->result  = \App\Models\DuelUserResult::DRAW ;
            $duelUserResultObj->ranking = 0 ;
            $duelUserResultObj->rating  = 0 ;
        }elseif($request->has('invalid')){
            $duelUserResultObj->result  = \App\Models\DuelUserResult::INVALID ;
            $duelUserResultObj->ranking = 0 ;
            $duelUserResultObj->rating  = 0 ;
        }else{
            return false;
        }

        $this->duel_user_result_repository->create($duelUserResultObj);

        return $request;
    }

    /**
     * シングル決闘の完了確認とステータス処理とレート処理
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function updateSingleDuelByFinish($request)
    {
        //すでに結果報告が終わっていないかチェック
        $myDuelUserResult    = $request->duel->duelUser->where('user_id',$request->user_id)->first()->duelUserResult;
        $otherDuelUserResult = $request->duel->duelUser->whereNotIn('user_id',[$request->user_id])->first()->duelUserResult;

        //無効試合が選択された場合の処理
        for($i = 1; $i < $request->duel->number_of_games + 1; $i++) {

            //決闘回数がまだ満たされていない、または相手の報告がまだの場合、決闘ページに戻す
            if(!isset($myDuelUserResult->where('games_number', $i)->first()->result) ||
                !isset($otherDuelUserResult->where('games_number', $i)->first()->result)
                ){
                    return $request ;
                }
            $my_result    = $myDuelUserResult->where('games_number', $i)->first()->result;
            $other_result = $otherDuelUserResult->where('games_number', $i)->first()->result;

            //無効試合かを判定
            //どちらかが無効試合が選択していたら無効
            if($my_result == \App\Models\DuelUserResult::INVALID || $other_result == \App\Models\DuelUserResult::INVALID){
                $request->merge(['message' => '無効試合が選択されたので試合が無効になりました']);

                $duel = $this->duel_repository->updateStatus($request->duel->id, \App\Models\Duel::INVALID) ;
                $this->event_repository->updateStatus($request->duel->eventDuel->event->id, \App\Models\Event::INVALID) ;

                return $request ;
            }elseif(
            //お互いドロー選択でないのに同じ選択をしていたら無効
                (!($my_result == \App\Models\DuelUserResult::DRAW && $other_result == \App\Models\DuelUserResult::DRAW) &&
                    $my_result == $other_result) ||
            //自分がドローで相手がドローでない
                ($my_result == \App\Models\DuelUserResult::DRAW && $other_result <> \App\Models\DuelUserResult::DRAW) ||
            //相手がドローで自分がドローでない
                ($my_result <> \App\Models\DuelUserResult::DRAW && $other_result == \App\Models\DuelUserResult::DRAW)
            ){
                $request->merge(['message' => 'お互いの勝敗報告が矛盾したので試合が無効になりました']);
                $duel = $this->duel_repository->updateStatus($request->duel->id, \App\Models\Duel::INVALID) ;
                $this->event_repository->updateStatus($request->duel->eventDuel->event->id, \App\Models\Event::INVALID) ;

                return $request ;
            }
        }

        //お互いが最終戦報告が終わったらレートを更新
        if($myDuelUserResult->where('games_number', $request->duel->number_of_games)->first()->isNotEmpty() &&
            $otherDuelUserResult->where('games_number', $request->duel->number_of_games)->first()->isNotEmpty()
        ) {
            //試合終了に伴うステータスの更新
            $duel = $this->duel_repository->updateStatus($request->duel->id, \App\Models\Duel::FINISH) ;
            $this->event_repository->updateStatus($request->duel->eventDuel->event->id, \App\Models\Event::FINISH) ;

            $this->user_repository->updateRate($request->user_id, $myDuelUserResult->sum('rating'));
            $this->user_repository->updateRate($request->duel->duelUser->whereNotIn('user_id',[$request->user_id])->first()->user_id, $myDuelUserResult->sum('rating'));
            $request->merge(['message' => '試合が終了しました']);
        }

        return $request;
    }

    /**
     * シングル決闘の際のduelを取得
     * @param $duel_id
     * @return mixed
     */
    public function findDuelWithUserAndEvent($duel_id)
    {
        return $this->duel_repository->findWithUserAndEvent($duel_id);
    }

}
