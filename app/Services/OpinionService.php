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

    /**
     * @param $request
     * @return mixed
     */
    public function getOpinion($request)
    {
        return $this->opinionRepository->find($request);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getOpinions($request)
    {
        return $this->opinionRepository->findAll($request);
    }

    /**
     * @param $request
     * @param $paginate
     * @return mixed
     */
    public function getOpinionsOfPagination($request, $paginate)
    {
        return $this->opinionRepository->findAllOfPagination($request, $paginate);
    }

}
