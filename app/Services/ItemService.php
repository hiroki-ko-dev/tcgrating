<?php

namespace App\Services;
use App\Repositories\ItemRepository;

use App\Repositories\ItemStockRepository;
use App\Repositories\CartRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TransactionItemRepository;
use Illuminate\Http\Request;

use Auth;

class ItemService
{
    protected $itemRepository;
    protected $itemStockRepository;
    protected $cartRepository;
    protected $transactionRepository;
    protected $transactionItemRepository;

    public function __construct(ItemRepository $itemRepository,
                                ItemStockRepository $itemStockRepository,
                                CartRepository $cartRepository,
                                TransactionRepository $transactionRepository,
                                TransactionItemRepository $transactionItemRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->itemStockRepository = $itemStockRepository;
        $this->cartRepository = $cartRepository;
        $this->transactionRepository = $transactionRepository;
        $this->transactionItemRepository = $transactionItemRepository;
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
     * @param $request
     * @return mixed
     */
    public function makeCart($request)
    {
        if(Auth::Check()){
            $request->merge(['user_id' => Auth::id()]);
            $cart = $this->cartRepository->create($request);
        }else{
            $carts = session('carts');
            $count = count($carts);
            $carts[$count]['item_id'] = $request->item_id;
            $carts[$count]['amount'] = $request->amount;
            session()->put('carts', $carts);
            $cart = $carts[$count];
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveCart($request)
    {
        if(Auth::Check()){
            $cart = $this->cartRepository->update($request);
        }else{
            $carts = session('carts');
            $count = count($carts);
            $carts[$count]['item_id'] = $request->item_id;
            $carts[$count]['amount'] = $request->amount;
            session()->put('carts', $carts);
            $cart = $carts[$count];
        }
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveTransactionByCarts($request)
    {
        $carts = $this->getCarts($request);
        // transaction作成のためのクエリ作成
        $request = new Request();
        $request->user_id = Auth::id();
        $request->send_status = \App\Models\Transaction::SEND_STATUS_BEFORE_SENDING;
        $request->postage = 500;

        $request->price = $this->getCartTotalPrice($carts);
        $transaction = $this->transactionRepository->create($request);

        foreach($carts as $cart){
            $transactionItemRequest = new Request();
            $transactionItemRequest->item_id  = $cart->item_id;
            $transactionItemRequest->quantity = $cart->quantity;
            $transactionItemRequest->price = $cart->item->price;
            $this->transactionItemRepository->create($transactionItemRequest);
            $this->cartRepository->delete($cart->id);
        }
        return $transaction;
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

    /**
     * @param $request
     * @return mixed
     */
    public function getCarts($request)
    {
        return $this->cartRepository->findAll($request);
    }

    /**
     * @param $carts
     * @return float|int
     */
    public function getCartTotalPrice($carts)
    {
        $totalPrice = 0;
        foreach($carts as $cart){
            $totalPrice += $cart->item->price * $cart->quantity;
        }
        return $totalPrice;
    }

    /**
     * @param $cart_id
     * @return mixed
     */
    public function destroyCart($cart_id)
    {
        $this->cartRepository->delete($cart_id);
    }



}
