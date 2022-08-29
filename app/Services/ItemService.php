<?php

namespace App\Services;
use App\Repositories\ItemRepository;

use App\Repositories\ItemStockRepository;
use App\Repositories\CartRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TransactionItemRepository;
use App\Repositories\TransactionUserRepository;
use Illuminate\Http\Request;

use Auth;

class ItemService
{
    protected $itemRepository;
    protected $itemStockRepository;
    protected $cartRepository;
    protected $transactionRepository;
    protected $transactionItemRepository;
    protected $transactionUserRepository;

    public function __construct(ItemRepository $itemRepository,
                                ItemStockRepository $itemStockRepository,
                                CartRepository $cartRepository,
                                TransactionRepository $transactionRepository,
                                TransactionItemRepository $transactionItemRepository,
                                TransactionUserRepository $transactionUserRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->itemStockRepository = $itemStockRepository;
        $this->cartRepository = $cartRepository;
        $this->transactionRepository = $transactionRepository;
        $this->transactionItemRepository = $transactionItemRepository;
        $this->transactionUserRepository = $transactionUserRepository;
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
     * @return mixed|string
     * @throws \Exception
     */
    public function makeCart($request)
    {
        $request->merge(['user_id' => Auth::id()]);
        $carts = $this->getCarts($request);
        if(in_array($request->item_id, $carts->pluck('item_id')->toArray())){
            throw new \Exception("この商品はすでにカートに入っています");
        }else{
            $item = $this->getItem($request->item_id);
            if($item->quantity < $request->quantity){
                throw new \Exception("この商品は在庫切れです");
            }
            else{
                $cart = $this->cartRepository->create($request);
            }
        }

        return $cart;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function makeTransactionUser($request)
    {
        $transactionUser = $this->transactionUserRepository->create($request);

        return $transactionUser;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveItem($request)
    {
        $item = $this->itemRepository->update($request);

        return $item;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveItemQuantity($request)
    {
        $quantity = $this->checkItemQuantity($request);

        $itemRequest = new \stdClass();
        $itemRequest->item_id = $request->item_id;
        $itemRequest->quantity = $quantity;
        $item = $this->saveItem($itemRequest);
        return $item;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveCart($request)
    {
        $cart = null;
        if(Auth::Check()){
            $cart = $this->cartRepository->update($request);
        }else{
            $carts = session('carts');
            foreach($carts as $loopCart){
                if($loopCart->item_id == $request->item_id){
                    $loopCart->quantity = $request->quantity;
                    $cart = $loopCart;
                    break;
                }
            }
            session(['carts' => $carts]);
        }
        return $cart;
    }


    /**
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function saveTransactionByCarts($request)
    {
        $carts = $this->getCarts($request);
        // transaction作成のためのクエリ作成
        $transactionRequest = new Request();
        $transactionRequest->send_status = \App\Models\Transaction::SEND_STATUS_BEFORE_SENDING;
        $transactionRequest->postage = 500;
        $transactionRequest->price = $this->getCartTotalPrice($carts);
        $transaction = $this->transactionRepository->create($transactionRequest);

        $request->merge(['transaction_id' => $transaction->id]);
        if(Auth::check()){
            $request->merge(['user_id' => Auth::id()]);
        }else{
            $carts = session('carts');
        }
        foreach($carts as $cart){
            $transactionItemRequest = new Request();
            $transactionItemRequest->transaction_id = $transaction->id;
            $transactionItemRequest->item_id  = $cart->item_id;
            $transactionItemRequest->quantity = $cart->quantity;
            $transactionItemRequest->price = $cart->item->price;
            $transactionItem = $this->transactionItemRepository->create($transactionItemRequest);
            $this->cartRepository->delete($cart->id);

            $itemRequest = new Request();
            $itemRequest->item_id  = $cart->item_id;
            if($transactionItem->item->quantity < $transactionItem->quantity){
                throw new \Exception("商品の在庫切れがあったため取引が完了できませんでした");
            }
            $itemRequest->quantity  = $transactionItem->item->quantity - $transactionItem->quantity;
            $this->saveItem($itemRequest);
        }
        $transactionUser = $this->makeTransactionUser($request);

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
     * @return \App\Models\Cart|mixed
     * @throws \Exception
     */
    public function getCarts($request)
    {
        if(Auth::check()){
            $carts = $this->cartRepository->findAll($request);
        }else{
            $carts = session('carts');
            if(is_null($carts)){
                $carts = collect();
            }
        }

        return $carts;
    }

    /**
     * @param $transaction_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTransaction($transaction_id)
    {
        return $this->transactionRepository->find($transaction_id);
    }

    /**
     * @param $request
     * @param $paginate
     * @return mixed
     */
    public function getTransactionsByPaginate($request, $paginate)
    {
        return $this->transactionRepository->findAllByPaginate($request, 20);
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

    /**
     * @param $request
     * @return int
     */
    public function checkItemQuantity($request)
    {
        $item = $this->getItem($request->item_id);

        if($item->itemStocks){
            $itemStocks = $item->itemStocks->sum('quantity');
        }else{
            $itemStocks = 0;
        }

        if($item->transactionItems){
            $transactionItems = $item->transactionItems->sum('quantity');
        }else{
            $transactionItems = 0;
        }

        return $itemStocks - $transactionItems;
    }

    /**
     * @param $request
     * @return \App\Models\Cart
     * @throws \Exception
     */
    public function sessionMakeCart($request)
    {
        // cartすでにあるか
        $carts = collect(session('carts'));
        $i = 0 ;
        if($carts){
            // 対象のitem_idがすでにあるか検証
            foreach($carts as $i => $cart){
                if($cart->item_id == $request->item_id) {
                    throw new \Exception("その商品は既にカートに入っています");
                }
            }
        }

        // 在庫切れになっていないか
        $item = $this->getItem($request->item_id);
        if($item->quantity < $request->quantity){
            throw new \Exception("この商品は在庫切れです");
        }
        // なければsessionの最後にcartsを追加
        $cart = new \App\Models\Cart();
        $cart->id          = 9001 + $i;
        $cart->item_id = $request->item_id;
        $cart->quantity = $request->quantity;
        $carts[] = $cart;
        session(['carts' => $carts]);

        return $cart;
    }

}
