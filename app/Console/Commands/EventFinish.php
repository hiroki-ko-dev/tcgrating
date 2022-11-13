<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EventService;
use App\Services\DuelService;

use Illuminate\Http\Request;
use Carbon\Carbon;

class EventFinish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:eventFinish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ステータスが終了になっていないレート戦を終了';

    protected $eventService;
    protected $duelService;

    /**
     * Undocumented function
     *
     * @param EventService $eventService
     * @param DuelService $duelService
     */
    public function __construct(EventService $eventService,
                                DuelService $duelService)
    {
        parent::__construct();
        $this->eventService = $eventService;
        $this->duelService = $duelService;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function handle()
    {
        try{
            $request = new Request();
            $request->statuses = [\App\Models\Event::STATUS_RECRUIT,\App\Models\Event::STATUS_READY];
            $request->event_category_id = \App\Models\EventCategory::CATEGORY_SINGLE;
            $today = Carbon::today()->subDay(3);
            $request->end_date = $today;
            $events = $this->eventService->getEvents($request);

            foreach($events as $event){
                if($event->status == \App\Models\Event::STATUS_RECRUIT){
                    $eventNextStatus = \App\Models\Event::STATUS_CANCEL;
                    $duelNextStatus = \App\Models\Duel::STATUS_CANCEL;
                }elseif($event->status == \App\Models\Event::STATUS_READY){
                    $eventNextStatus = \App\Models\Event::STATUS_FINISH;
                    $duelNextStatus = \App\Models\Duel::STATUS_FINISH;
                }else{
                    throw new \Exception("想定外のステータス");
                }
                $this->eventService->updateEventStatus($event->id, $eventNextStatus);
                $this->duelService->updateDuelStatus($event->eventDuels[0]->duel_id, $duelNextStatus);
            }

            return true;
        } catch (\Exception $e) {
            report($e);
            return $e->getMessage();
        }
    }
}
