<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function delivery() {
        return view('pages.services.delivery');
    }

    public function catering() {
        return view('pages.services.catering');
    }

    public function mealPlan() {
        return view('pages.services.meal-plan');
    }

    public function giftCard() {
        return view('pages.services.gift-card');
    }
}