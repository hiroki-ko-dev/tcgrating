<?php

namespace App\Services;
use App\Repositories\DuelRepository;
use App\Repositories\DuelUserRepository;
use App\Repositories\DuelUserResultRepository;
use App\Repositories\EventDuelRepository;
use App\Repositories\EventRepository;
use App\Repositories\EventUserRepository;
use App\Repositories\GameUserRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class DuelService
{
    protected $duelRepository;
    protected $duelUserRepository;
    protected $duelUserResultRepository;
    protected $eventDuelRepository;
    protected $eventRepository;
    protected $eventUserRepository;
    protected $userRepository;
    protected $gameUserRepository;

    public function __construct(DuelRepository $duelRepository,
                                DuelUserRepository $duelUserRepository,
                                DuelUserResultRepository $duelUserResultRepository,
                                EventDuelRepository $eventDuelRepository,
                                EventRepository $eventRepository,
                                EventUserRepository $eventUserRepository,
                                UserRepository $userRepository,
                                GameUserRepository $gameUserRepository)
    {
        $this->duelRepository            = $duelRepository;
        $this->duelUserRepository        = $duelUserRepository;
        $this->duelUserResultRepository  = $duelUserResultRepository;
        $this->eventDuelRepository       = $eventDuelRepository;
        $this->eventRepository           = $eventRepository;
        $this->eventUserRepository       = $eventUserRepository;
        $this->userRepository            = $userRepository;
        $this->gameUserRepository        = $gameUserRepository;
    }

    /**
     * シングル決闘の際のduel系作成
     * @param $request
     * @return mixed
     */
    public function createDuel($request)
    {
        $duel = $this->duelRepository->create($request);
        $request->merge(['duel_id' => $duel->id]);
        $this->eventDuelRepository->create($request);
        return $request;
    }

    /**
     * シングル決闘の際のduel系作成
     * @param $request
     * @return mixed
     */
    public function createSingle($request)
    {
        $duelRequest = new \stdClass();
        $duels = $this->getDuels($request);

        $duel = $this->duelRepository->create($request);
        $request->merge(['duel_id' => $duel->id]);
        $this->duelUserRepository->create($request);
        $this->eventDuelRepository->create($request);
        return $request;
    }

    /**
     * インスタント決闘の際のduel系作成
     * @param $request
     * @return mixed
     */
    public function createInstant($request)
    {
        // ルームIDを決める処理
        $duelRequest = new \stdClass();
        $duelRequest->statuses = [\App\Models\Duel::STATUS_READY,\App\Models\Duel::STATUS_RECRUIT];
        $duelRequest->event_category_id = [\App\Models\EventCategory::CATEGORY_SINGLE];
        if(isset($request->rate_type)){
            $duelRequest->rate_type = $request->rate_type;
        }
        $duels = $this->getDuels($duelRequest);
        // 部屋予約中のの対戦があるならそこを避ける
        if($duels->isNotEmpty()){
            $room_ids = $duels->pluck('room_id')->toArray();
            // room_idがセットされない場合があるので、暫定の例外処理
            if(empty($room_ids)){
                $request->merge(['room_id' => 1]); 
            }
            for($i=1;$i<count($room_ids)+1;$i++){
                if(in_array($i,$room_ids)){
                    continue;
                }else{
                    $request->merge(['room_id' => $i]);
                    break;
                }
            }
        // なければ部屋1
        }else{
            $request->merge(['room_id' => 1]);
        }

        $duel = $this->duelRepository->create($request);
        $request->merge(['duel_id' => $duel->id]);
        $this->duelUserRepository->create($request);
        $this->eventDuelRepository->create($request);
        return $request;
    }

    public function createUser($request)
    {
        $this->duelUserRepository->create($request);
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
        $duelUserResult = $this->duelUserResultRepository->findAllByDuelUserId($request->duel->duelUsers->where('user_id',$request->user_id)->first()->id);

        //相手より2回以上報告が多くならない制御
        if($duelUserResult->isNotEmpty()){
            //自分のデュエル結果
            $myDuelUserResult    = $request->duel->duelUsers->where('user_id',$request->user_id)->first()->duelUserResults;

            //相手の報告がない場合、今回報告をすると+2の差がつくのでエラー
            if(!isset($request->duel->duelUsers->whereNotIn('user_id',[$request->user_id])->first()->duelUserResults)){
                throw new \Exception("相手の報告より2回以上多い報告はできません");
            }
            //相手のデュエル結果
            $otherDuelUserResult = $request->duel->duelUsers->whereNotIn('user_id',[$request->user_id])->first()->duelUserResults;

            //すでに試合が終了した後の報告をエラーとする
            if($myDuelUserResult->count() == $otherDuelUserResult->count() && $request->duel->status <> \App\Models\Duel::STATUS_READY){
                throw new \Exception("終了した試合です");
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
        $duelUserResultObj->duel_user_id = $request->duel->duelUsers->where('user_id',$request->user_id)->first()->id ;
        $duelUserResultObj->duel_user_id = $request->duel->duelUsers->where('user_id',$request->user_id)->first()->id ;
        if($duelUserResult->isEmpty()){
            $duelUserResultObj->games_number = 1;
        }else{
            $duelUserResultObj->games_number = $duelUserResult->count() + 1 ;
        }

        if($request->has('win')){
            $duelUserResultObj->result  = \App\Models\DuelUserResult::RESULT_WIN ;
            $duelUserResultObj->ranking = 1 ;
            $duelUserResultObj->rating  = 1000 ;
        }elseif($request->has('lose')){
            $duelUserResultObj->result  = \App\Models\DuelUserResult::RESULT_LOSE ;
            $duelUserResultObj->ranking = 2 ;
            $duelUserResultObj->rating  = -1000 ;
        }elseif($request->has('draw')){
            $duelUserResultObj->result  = \App\Models\DuelUserResult::RESULT_DRAW ;
            $duelUserResultObj->ranking = 0 ;
            $duelUserResultObj->rating  = 0 ;
        }elseif($request->has('invalid')){
            $duelUserResultObj->result  = \App\Models\DuelUserResult::RESULT_INVALID ;
            $duelUserResultObj->ranking = 0 ;
            $duelUserResultObj->rating  = 0 ;
        }else{
            return false;
        }

        $this->duelUserResultRepository->create($duelUserResultObj);

        return $request;
    }

    /**
     * 即席デュエル結果を格納
     * @param $request
     * @return bool
     * @throws \Exception
     */
    public function createInstantResult($request)
    {
        $duelUserResult = $this->duelUserResultRepository->findAllByDuelUserId($request->duel->duelUsers->where('user_id',$request->user_id)->first()->id);
        if(empty($duelUserResult)){
            $number_of_games = 1;
        }else{
            $number_of_games = $duelUserResult->max('games_number') + 1;
        }

        $myDuelUserResult = new \stdClass();
        $myDuelUserResult->duel_user_id = $request->duel->duelUsers->where('user_id',$request->user_id)->first()->id ;
        $myDuelUserResult->games_number = $number_of_games;

        $otherDuelUserResult = new \stdClass();
        $otherDuelUserResult->duel_user_id = $request->duel->duelUsers->whereNotIn('user_id',[$request->user_id])->first()->id ;
        $otherDuelUserResult->games_number = $number_of_games;

        // 試合数を更新
        $duelRequest = new \stdClass();
        $duelRequest->id = $request->duel->id;
        $duelRequest->number_of_games = $number_of_games;
        $this->updateDuel($duelRequest);

        if($request->has('win')){
            $myDuelUserResult->result  = \App\Models\DuelUserResult::RESULT_WIN ;
            $myDuelUserResult->ranking = 1 ;
            $myDuelUserResult->rating  = 1000 ;

            $gameUser = $this->gameUserRepository->findByGameIdAndUserId($request->duel->game_id, $request->duel->duelUsers->whereNotIn('user_id',[$request->user_id])->first()->user_id);

            $otherDuelUserResult->result  = \App\Models\DuelUserResult::RESULT_LOSE ;
            $otherDuelUserResult->ranking = 2 ;
            $otherDuelUserResult->rating = 0;

            // シングルならマイナスにならない救済処置
//            if($request->duel->eventDuel->event->event_category_id == \App\Models\EventCategory::CATEGORY_SINGLE) {
//                // ユーザーのレートが元々0ならマイナスにはしない
//                if ($gameUser->rate <= 0) {
//                    $otherDuelUserResult->rating = 0;
//                } else {
//                    $otherDuelUserResult->rating = -1000;
//                }
//            }else{
//                $otherDuelUserResult->rating = -1000;
//            }

        }elseif($request->has('draw')) {
            $myDuelUserResult->result = \App\Models\DuelUserResult::RESULT_DRAW;
            $myDuelUserResult->ranking = 0;
            $myDuelUserResult->rating = 0;

            $otherDuelUserResult->result  = \App\Models\DuelUserResult::RESULT_DRAW ;
            $otherDuelUserResult->ranking = 0 ;
            $otherDuelUserResult->rating  = 0 ;
        }else{
            return false;
        }

        // DuelUserResultの更新
        $this->duelUserResultRepository->create($myDuelUserResult);
        $this->duelUserResultRepository->create($otherDuelUserResult);


        // ユーザーレートの更新
        if($request->duel->duel_category_id == \App\Models\DuelCategory::CATEGORY_SINGLE) {
            $game_id = $request->duel->eventDuel->event->game_id;
            $this->updateUserRate($game_id, $request->user_id, $myDuelUserResult->rating);
            $this->updateUserRate($game_id, $request->duel->duelUsers->whereNotIn('user_id', [$request->user_id])->first()->user_id, $otherDuelUserResult->rating);
        }

        return $request;
    }

    /**
     * @param $request
     * @return bool
     */
    public function makeSwissDuels($request)
    {
        $event = $this->eventRepository->find($request->event_id);
        // 主催者含む
        // $eventUsers = $event->eventUsers->whereIn('status',[\App\Models\EventUser::STATUS_APPROVAL,\App\Models\EventUser::STATUS_MASTER])->shuffle();
        // 主催者抜き
        $eventUsers = $event->eventUsers->whereIn('status',[\App\Models\EventUser::STATUS_APPROVAL,\App\Models\EventUser::STATUS_MASTER])->shuffle();

        foreach($eventUsers as $eventUser){
            $eventUser->append('now_event_rate');
            $eventUser->now_event_rate = $eventUser->event_rate;
        }

        $eventUsers = $eventUsers->sortByDesc('now_event_rate')->values();

        $duels = null;
        // 対戦チャンネル指定用
        $room_id = 1;
        // ユーザー取り出しに利用する変数
        $i = 0;
        while($i + 1 <= count($eventUsers)) {

            $duelRequest = new \stdClass();
            $duelRequest->game_id          = $event->game_id;
            $duelRequest->duel_category_id = \App\Models\DuelCategory::CATEGORY_SINGLE;
            $duelRequest->user_id          = $event->user_id;
            $duelRequest->status           = \App\Models\Duel::STATUS_READY;
            $duelRequest->match_number     = $event->now_match_number;
            $duelRequest->number_of_games  = 1;
            $duelRequest->max_member       = 2;
            $duelRequest->room_id          = $room_id;
            $duelRequest->tool_id          = \App\Models\Duel::TOOL_TCG_DISCORD;
            $duelRequest->tool_code        = config('assets.duel.discordPokemonCardServerUrl');

            //不戦勝の処理
            if($i + 1 == count($eventUsers)) {
                $duelRequest->status           = \App\Models\Duel::STATUS_FINISH;
            }

            // duelテーブルの作成
            $duel = $this->duelRepository->create($duelRequest);
            $duelRequest->duel_id = $duel->id;

            // eventDuelテーブルの作成
            $duelRequest->event_id = $event->id;
            $this->eventDuelRepository->create($duelRequest);

            // 対戦一人目の作成
            $duelRequest->user_id = $eventUsers[$i]->user_id;
            $duelRequest->status = \App\Models\DuelUser::STATUS_APPROVAL;
            $duelUser = $this->duelUserRepository->create($duelRequest);

            //不戦勝の処理
            if($i + 1 == count($eventUsers)) {
                $duelUserResult = new \stdClass();
                $duelUserResult->duel_user_id = $duelUser->id ;
                $duelUserResult->games_number = $request->now_match_number;
                $duelUserResult->result  = \App\Models\DuelUserResult::RESULT_WIN ;
                $duelUserResult->ranking = 1 ;
                $duelUserResult->rating  = 1000 ;
                $this->duelUserResultRepository->create($duelUserResult);

            // 対戦二人目の作成
            }else{
                $duelRequest->user_id = $eventUsers[$i+1]->user_id;
                $this->duelUserRepository->create($duelRequest);

                $duels[] = $duel;
                $room_id = $room_id + 1;
            }

            $i = $i + 2;
        }

        return $duels;
    }

    /**
     * シングル決闘の際のduel系作成
     * @param $request
     * @return mixed
     */
    public function updateDuel($request)
    {
        $duel = $this->duelRepository->update($request);
        return $duel;
    }

    /**
     * シングル決闘の際のduelステータス系操作
     * @param $duel_id
     * @param $next_status
     * @return \App\Models\Duel
     */
    public function updateDuelStatus($duel_id, $next_status)
    {
        $duel = $this->duelRepository->updateStatus($duel_id, $next_status);
        return $duel;
    }

    /**
     * シングル決闘の完了確認とステータス処理とレート処理
     * @param $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function updateSingleDuelByFinish($request)
    {
        //すでに結果報告が終わっていないかチェック
        $myDuelUserResult    = $request->duel->duelUsers->where('user_id',$request->user_id)->first()->duelUserResults;
        //相手の初期報告がまだなら次の試合へ
        if(!isset($request->duel->duelUsers->whereNotIn('user_id',[$request->user_id])->first()->duelUserResults)){
            return $request ;
        }
        $otherDuelUserResult = $request->duel->duelUsers->whereNotIn('user_id',[$request->user_id])->first()->duelUserResults;

        //無効試合が選択された場合の処理
        for($i = 1; $i < $request->duel->number_of_games + 1; $i++) {

            //決闘回数がまだ満たされていない、または相手の報告がまだの場合、決闘ページに戻す
            if(!isset($myDuelUserResult->where('games_number', $i)->first()->result) ||
                !isset($otherDuelUserResult->where('games_number', $i)->first()->result)
                ){
                    if(!($myDuelUserResult->where('games_number', $request->duel->number_of_games)->isEmpty())){
                        $request->merge(['message' => '試合が終了しました。対戦相手の報告をお待ちください']);
                    }
                    return $request ;
                }
            $my_result    = $myDuelUserResult->where('games_number', $i)->first()->result;
            $other_result = $otherDuelUserResult->where('games_number', $i)->first()->result;

            //無効試合かを判定
            //どちらかが無効試合が選択していたら無効
            if($my_result == \App\Models\DuelUserResult::RESULT_INVALID || $other_result == \App\Models\DuelUserResult::RESULT_INVALID){
                $request->merge(['message' => '無効試合が選択されたので試合が無効になりました']);

                $duel = $this->duelRepository->updateStatus($request->duel->id, \App\Models\Duel::STATUS_INVALID) ;
                $this->eventRepository->updateStatus($request->duel->eventDuel->event->id, \App\Models\Event::STATUS_INVALID) ;

                return $request ;
            }elseif(
            //お互いドロー選択でないのに同じ選択をしていたら無効
                (!($my_result == \App\Models\DuelUserResult::RESULT_DRAW && $other_result == \App\Models\DuelUserResult::RESULT_DRAW) &&
                    $my_result == $other_result) ||
            //自分がドローで相手がドローでない
                ($my_result == \App\Models\DuelUserResult::RESULT_DRAW && $other_result <> \App\Models\DuelUserResult::RESULT_DRAW) ||
            //相手がドローで自分がドローでない
                ($my_result <> \App\Models\DuelUserResult::RESULT_DRAW && $other_result == \App\Models\DuelUserResult::RESULT_DRAW)
            ){
                $request->merge(['message' => 'お互いの勝敗報告が矛盾したので試合が無効になりました']);
                $duel = $this->duelRepository->updateStatus($request->duel->id, \App\Models\Duel::STATUS_INVALID) ;
                $this->eventRepository->updateStatus($request->duel->eventDuel->event->id, \App\Models\Event::STATUS_INVALID) ;

                return $request ;
            }
        }

        //お互いが最終戦報告が終わったらレートを更新
        if($myDuelUserResult->where('games_number', $request->duel->number_of_games)->isNotEmpty() &&
            $otherDuelUserResult->where('games_number', $request->duel->number_of_games)->isNotEmpty()
        ) {
            // 試合終了に伴うステータスの更新
            $duel = $this->duelRepository->updateStatus($request->duel->id, \App\Models\Duel::STATUS_FINISH) ;
            $this->eventRepository->updateStatus($request->duel->eventDuel->event->id, \App\Models\Event::STATUS_FINISH) ;

            // 試合終了に伴うユーザーレートの更新
            $game_id = $request->duel->eventDuel->event->game_id;
            $this->updateUserRate($game_id, $request->user_id, $myDuelUserResult->sum('rating'));
            $this->updateUserRate($game_id, $request->duel->duelUsers->whereNotIn('user_id',[$request->user_id])->first()->user_id, $otherDuelUserResult->sum('rating'));
            $request->merge(['message' => '試合が終了しました']);
        }

        return $request;
    }

    /**
     * @param $game_id
     * @param $user_id
     * @param $addRate
     * @return mixed
     */
    public function updateUserRate($game_id, $user_id, $addRate)
    {
        $gameUser = $this->gameUserRepository->findByGameIdAndUserId($game_id, $user_id);

        if(is_null($gameUser)){
            $gameUser = new \stdClass();
            $gameUser->game_id      = $game_id;
            $gameUser->user_id      = $user_id;
            $gameUser = $this->gameUserRepository->create($gameUser);
        }

        // レートがプラスまたはユーザーレートが0以上となる場合のみ更新
        if($addRate > 0 || ($gameUser->rate + $addRate) >= 0){
            $this->gameUserRepository->updateRate($gameUser->id, $addRate);
        }

        return $gameUser;
    }



    /**
     * シングル決闘の際のduelを取得
     * @param $duel_id
     * @return mixed
     */
    public function getDuel($duel_id)
    {
        return $this->duelRepository->find($duel_id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getDuels($request)
    {
        return $this->duelRepository->findAll($request);
    }

    /**
     * シングル決闘の際のduelを取得
     * @param $duel_id
     * @return mixed
     */
    public function findDuelWithUserAndEvent($duel_id)
    {
        return $this->duelRepository->findWithUserAndEvent($duel_id);
    }

}
