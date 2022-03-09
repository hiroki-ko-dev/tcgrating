<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ProxyController extends Controller
{

    public function pdf(Request $request)
    {
        $viewImages = [];
        foreach($request->proxy_number as $i => $number){
            if($number > 0){
                for($j=1; $j<=$number; $j++){
                    $viewImages[] = $request->proxy_url[$i];
                }
            }
        }

        $pdf = PDF::loadView('proxy.pdf',compact('viewImages'));

        return $pdf->stream('プロキシ画像.pdf');
    }
}
