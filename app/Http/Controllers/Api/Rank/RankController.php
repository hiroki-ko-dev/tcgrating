<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Rank;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use App\Presenters\Api\Rank\RankPresenter;
use App\Dto\Http\ResponseDto;

class RankController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly RankPresenter $rankPresenter,
    ) {
    }

    public function index()
    {
        try {
            $gameUserFilters['game_id'] = config('assets.site.game_ids.pokemon_card');
            return response()->json(
                new ResponseDto(
                    data: $this->rankPresenter->ranks(
                        $this->userService->paginateGameUser($gameUserFilters, 200),
                    ),
                    code: 200,
                    message: '',
                )
            );
        } catch (\Exception $e) {
            return response()->json(
                new ResponseDto(
                    data: [],
                    code: $e->getCode(),
                    message: $e->getMessage(),
                )
            );
        }
    }
}
