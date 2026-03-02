<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\menu;


class menuController extends Controller
{

    public function daftarMenu(){
        $menuItems = menu::all(); 
        return view('pages.menu', compact('menuItems'));
    }

    public function topRating(){
        $menuItems = menu::orderBy('rating','desc')->take(3)->get();
        return view('welcome', compact('menuItems'));
    }

}

