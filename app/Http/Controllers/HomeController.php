<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //ini adalah controller untuk halaman utama
    public function index() {
        return view('front.home');
    }
}
