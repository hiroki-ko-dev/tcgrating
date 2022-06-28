<?php

namespace App\Services;
use App\Repositories\ItemRepository;

use App\Repositories\ItemStockRepository;
use Illuminate\Http\Request;

class ItemService
{
    protected $itemRepository;
    protected $itemStockRepository;

    public function __construct(ItemRepository $itemRepository,
                                ItemStockRepository $itemStockRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->itemStockRepository = $itemStockRepository;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function makeItem($request)
    {
        $item = $this->itemRepository->create($request);
        $request->merge(['item_id' => $item->id]);
        $itemStock = $this->makeItemStock($request);

        return $item;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function makeItemStock($request)
    {
        $itemStock = null;
        if($request->quantity > 0){
            $itemStock = $this->itemStockRepository->create($request);
        }

        return $itemStock;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getItem($id)
    {
        return $this->itemRepository->find($id);
    }

    /**
     * @param $request
     * @param $paginate
     * @return mixed
     */
    public function getItemsByPaginate($request, $paginate)
    {
        return $this->itemRepository->findAllByPaginate($request, $paginate);
    }

}
