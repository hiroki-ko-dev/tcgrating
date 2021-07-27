<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Session
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // URLによってゲームを選択
        foreach(config('assets.site.games') as $key => $game){
            if($request->query('game_id') == $key){
                session(['game_id' => $key]);
            }
        }

        // URLに何もなかったらポケモンカードにしておく
        if(empty(session('game_id'))){
            session(['game_id' => 3]);
        }

        return $next($request);
    }
}
