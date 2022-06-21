<?php

namespace App\Services;
use App\Repositories\ItemRepository;

use Illuminate\Http\Request;

class ItemService
{
    protected $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param $item_id
     * @param $paginate
     * @return mixed
     */
    public function getItemsByPaginate($item_id, $paginate)
    {
        return $this->itemRepository->findAllByPaginate($item_id, $paginate);
    }

}
