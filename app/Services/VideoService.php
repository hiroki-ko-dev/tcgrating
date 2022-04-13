<?php

namespace App\Services;
use App\Repositories\VideoRepository;

use Illuminate\Http\Request;

class VideoService
{
    protected $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }


    public function getVideosByPaginate($request, $paginate)
    {
        return $this->videoRepository->findAllByPaginate($request, $paginate);
    }


}
