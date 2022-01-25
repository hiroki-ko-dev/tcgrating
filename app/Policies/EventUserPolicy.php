<?php

namespace App\Policies;

use App\Models\User;
use App\Repositories\EventUserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventUserPolicy
{
    use HandlesAuthorization;

    private $eventUserRepository;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(EventUserRepository $eventUserRepository)
    {
        $this->eventUserRepository = $eventUserRepository;
    }


    /**
     * @param User $user
     * @param $event_id
     * @return bool
     */
    public function role(User $user, $event_id)
    {
        if(is_null($user)){
            $role = \App\Models\EventUser::ROLE_USER;
        }else{
            $eventUser = $this->eventUserRepository->findEventUserByUserIdAndEventId($user->id,$event_id);
            if(is_null($eventUser)){
                $role = \App\Models\EventUser::ROLE_USER;
            }else{
                $role = $eventUser->role;
            }
        }

        return $role;
    }

}
