<?php

namespace App\Http\Controllers\Blog;
use App\Http\Controllers\Controller;
use App\Services\BlogService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Blog;

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
        $data = ["message" => 'test', "username" => 'HOOK',"content" => 'test'];
        $curl = curl_init('https://discord.com/api/webhooks/928304082303729675/QTibeNnkLzZMrJgYqf6MDeaEmX9BAoZQc22a_wLN85UexqcoqDhNEl2SoA4qtcgbyAJb');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type' => ' application/json']);
        $res = curl_exec($curl);

        dd($res);


        // 選択しているゲームでフィルタ
        if(Auth::check()) {
            $request->merge(['game_id' => Auth::user()->selected_game_id]);
        }else{
            $request->merge(['game_id' => session('selected_game_id')]);
        }

        // 管理者でなければ公開動画しか見せない
        if(!(Auth::check() && Auth::id() == 1)){
            $request->merge(['is_released' => 1]);
        }


        $blogs =  $this->blogService->getBlogByPaginate($request,20);

        return view('blog.index',compact('blogs'));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(!Auth::check() || Auth::id() <> 1) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        return view('blog.create')->with(['blog' => new Blog()]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        // 選択しているゲームでフィルタ
        if(!Auth::check() || Auth::id() <> 1) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        try {
            $request->merge(['user_id'=> Auth::id()]);
            $request->merge(['game_id'=> Auth::user()->selected_game_id]);

            $blog = DB::transaction(function () use($request) {
                $blog = $this->blogService->makeBlog($request);
                return $blog;
            });

            return redirect('/blog/'.$blog->id)->with('flash_message', '記事を保存しました');

        } catch (\Exception $e) {
            report($e);
            return back()->with('flash_message', $e->getMessage());
        }
    }

    /**
     * @param $blog_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($blog_id)
    {
        $blog = $this->blogService->getBlog($blog_id);

        return view('blog.show',compact('blog'));

    }

    /**
     * @param $blog_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($blog_id)
    {
        // 選択しているゲームでフィルタ
        if(!Auth::check() || Auth::id() <> 1) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        $blog = $this->blogService->getBlog($blog_id);

        return view('blog.edit',compact('blog'));
    }

    /**
     * @param Request $request
     * @param $blog_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $blog_id)
    {
        // 選択しているゲームでフィルタ
        if(!Auth::check() || Auth::id() <> 1) {
            return back()->with('flash_message', '新規投稿を行うにはログインしてください');
        }

        $request->merge(['id' => $blog_id]);
        DB::transaction(function () use($request){
            $this->blogService->saveBlog($request);
        });

        return redirect('/blog/' . $blog_id)->with('flash_message', '保存しました');
    }

}
