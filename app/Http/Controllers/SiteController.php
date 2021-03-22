<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function administrator(){

        return view('site.administrator');
    }
}
