<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Food;


class FoodController extends Controller
{

    public function daftarMenu(){
        $menuItems = \App\Models\Food::all(); 
        return view('pages.menu', compact('menuItems'));
    }

    public function topRating(){
        $menuItems = Food::orderBy('rating','desc')->take(3)->get();
        return view('welcome', compact('menuItems'));
    }

}

