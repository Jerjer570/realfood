<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\menu; 

class FoodController extends Controller
{
    /**
     * Menampilkan daftar menu dengan sistem Pagination (10 data per halaman).
     * Mengakses URL: /menu
     */
    public function daftarMenu()
    {
        // Menggunakan paginate(10) agar data dibagi menjadi beberapa halaman
        // Ini akan mencegah loading berat jika data ada 100+
        $menuItems = menu::paginate(10); 
        
        return view('pages.menu', compact('menuItems'));
    }

    /**
     * Menampilkan 3 menu dengan rating tertinggi di halaman utama.
     * Mengakses URL: /
     */
    public function topRating()
    {
        // Tetap menggunakan get() karena kita hanya mengambil 3 data (tidak butuh pagination)
        $menuItems = menu::orderBy('rating', 'desc')->take(3)->get();
        
        return view('welcome', compact('menuItems'));
    }

    /**
     * Menampilkan detail satu menu berdasarkan ID.
     */
    public function detailMenu($id)
    {
        // Menggunakan findOrFail agar otomatis 404 jika ID tidak ditemukan
        $item = menu::findOrFail($id);
        
        return view('pages.detail', compact('item'));
    }
}