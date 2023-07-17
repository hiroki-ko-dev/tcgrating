<?php

namespace Tests\Feature\Http\Controllers\Api\Rank;

use App\Http\Controllers\Api\Rank\RankController;
use App\Services\User\UserService;
use App\Presenters\Api\Rank\RankPresenter;
use App\Dto\Http\ResponseDto;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;
use Mockery;

class RankControllerTest extends TestCase
{
    public function test_index(): void
    {
        $userServiceMock = Mockery::mock(UserService::class);
        $rankPresenterMock = Mockery::mock(RankPresenter::class);

        $gameUserAttrs['game_id'] = config('assets.site.game_ids.pokemon_card');
        $paginator = new LengthAwarePaginator([], 0, 200);

        $userServiceMock->shouldReceive('paginateGameUser')
            ->once()
            ->with($gameUserAttrs, 200)
            ->andReturn($paginator);

        $expectedData = ['some data...'];  // ここに期待されるデータ構造をセットする
        $rankPresenterMock->shouldReceive('ranks')
            ->once()
            ->with($paginator)
            ->andReturn($expectedData);

        $controller = new RankController($userServiceMock, $rankPresenterMock);

        $response = $controller->index();

        $expectedResponse = new ResponseDto(data: $expectedData, code: 200, message: '');
        $this->assertEquals($response->getData(), $expectedResponse);
    }
}
