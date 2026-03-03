<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProsesController extends Controller
{
    public function selengkapnya() {
        return view('pages.pelajari_selengkapnya');
    }
    public function bahan() {
        return view('pages.proses.bahan');
    }
    public function benih() {
        return view('pages.proses.benih');
    }
    public function higienis() {
        return view('pages.proses.higienis');
    }
    public function pengiriman() {
        return view('pages.proses.pengiriman');
    }
}
