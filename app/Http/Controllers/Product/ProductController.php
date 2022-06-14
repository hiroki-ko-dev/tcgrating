<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;
use App\Services\ProductService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use DB;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {

        if($request->word){
            $product =  $this->productService->getProducts($request);
        }
        else{
            $product = null;
        }


        return view('product.index',compact('product'));
    }

}
