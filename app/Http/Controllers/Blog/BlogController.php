<?php

namespace App\Http\Controllers\Blog;
use App\Http\Controllers\Controller;
use App\Services\BlogService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(Auth::check()) {
            $request->merge(['game_id' => Auth::user()->selected_game_id]);
        }else{
            $request->merge(['game_id' => session('selected_game_id')]);
        }

        $blogs =  $this->blogService->getBlogByPaginate($request,20);

        return view('blog.index',compact('blogs');
    }


}
