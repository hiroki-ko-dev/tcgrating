<?php

namespace App\Services;
use App\Repositories\OpinionRepository;

use Illuminate\Http\Request;

class OpinionService
{
    protected $opinionRepository;

    public function __construct(OpinionRepository $opinionRepository)
    {
        $this->opinionRepository = $opinionRepository;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function makeOpinion($request)
    {
        return $this->opinionRepository->create($request);

    }

}
