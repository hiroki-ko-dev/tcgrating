<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        foreach (config('assets.site.games') as $key => $game) {
            if ($request->query('selected_game_id') == $key) {
                session()->forget('selected_game_id');
                session(['selected_game_id' => $key]);
            }
        }

        // URLに何もなかったらポケモンカードにしておく
        if (empty(session('selected_game_id'))) {
            session(['selected_game_id' => config('assets.site.game_ids.pokemon_card')]);
        }

        return $next($request);
    }
}
