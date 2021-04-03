<?php

namespace App\Services;
use App\Repositories\DuelRepository;
use Illuminate\Http\Request;

class DuelService
{
    protected $duel_repository;

    public function __construct(DuelRepository $duel_repository)
    {
        $this->duel_repository = $duel_repository;
    }

    public function findAllDuelWithUserByDuelCategoryIdAndPagination($duel_category_id,$pagenation)
    {
        return $this->duel_repository->findAllDuelWithUserByDuelCategoryIdAndPagination($duel_category_id,$pagenation);

    }


}
