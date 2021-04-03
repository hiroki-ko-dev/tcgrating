<?php

namespace App\Services;
use App\Repositories\UserRepository;

use Illuminate\Http\Request;

class UserService
{
    protected $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function findUser($id)
    {
        return $this->user_repository->find($id);
    }

}
