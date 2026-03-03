<?php

namespace App\Http\Controllers;

use App\Models\keranjang;
use App\Models\menu;
use App\Models\pesanan;
use App\Models\detail_pesanan; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * 1. Menampilkan Halaman Keranjang
     */
    public function index()
    {
        $cartItems = keranjang::with('menu')
            ->where('id_user', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->menu->harga * $item->kuantitas;
        });

        $shipping = 10000;

        return view('pages.cart', compact('cartItems', 'subtotal', 'shipping'));
    }

    /**
     * 2. Tambah Item ke Keranjang (Aksi Tombol + di Menu)
     */
    public function addToCart(Request $request, $id)
    {
        // Pastikan user sudah login sebelum menambah ke keranjang
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $food = menu::findOrFail($id);
        
        // Cek apakah produk sudah ada di keranjang user
        $cartItem = keranjang::where('id_user', Auth::id())
                        ->where('id_menu', $id)
                        ->first();

        if ($cartItem) {
            // Jika sudah ada, cukup tambahkan jumlahnya
            $cartItem->update([
                'kuantitas' => $cartItem->kuantitas + 1
            ]);
        } else {
            // Jika belum ada, buat baris baru di tabel carts
            keranjang::create([
                'id_user' => Auth::id(),
                'id_menu' => $id,
                'kuantitas' => 1
            ]);
        }

        return back()->with('success', $menu->nama_menu . ' berhasil ditambah ke keranjang!');
    }

    /**
     * 3. Update Jumlah di Keranjang (Tombol +/- di halaman Cart)
     */
    public function update(Request $request, $id)
    {
        $cart = keranjang::where('id_keranjang', $id)->where('id_user', Auth::id())->firstOrFail();
        
        $newQuantity = $keranjang->kuantitas + $request->change;
        
        if ($newQuantity > 0) {
            $cart->update(['kuantitas' => $newQuantity]);
        } else {
            $cart->delete();
        }

        return back()->with('success', 'Keranjang diperbarui');
    }

    /**
     * 4. Menghapus Item dari Keranjang
     */
    public function destroy($id)
    {
        keranjang::where('id_keranjang', $id)->where('id_user', Auth::id())->delete();
        return back()->with('success', 'Item berhasil dihapus');
    }

    /**
     * 5. Halaman Checkout
     */
   // App/Http/Controllers/CartController.php

public function checkout()
{
    $cartItems = keranjang::with('menu')->where('id_user', Auth::id())->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('menu')->with('error', 'Keranjang belanja Anda masih kosong.');
    }

    $subtotal = $cartItems->sum(function($item) {
        return $item->menu->harga * $item->kuantitas;
    });

    $shipping = 10000;

    // Pastikan file ini ADA di resources/views/pages/checkout.blade.php
    return view('pages.checkout', compact('cartItems', 'subtotal', 'shipping'));
}

    /**
     * 6. Memproses Pesanan ke Tabel Orders
     */
    public function processOrder(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'metode_pembayaran' => 'required'
        ]);

        $cartItems = keranjang::with('menu')->where('id_user', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Keranjang sudah kosong');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->menu->harga * $item->kuantitas;
        });

        // Database Transaction untuk keamanan data
        DB::transaction(function () use ($request, $cartItems, $subtotal) {
            // 1. Buat Data pesanan Utama
            $pesanan = pesanan::create([
                'id_user' => Auth::id(),
                'total' => $subtotal + 10000,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'status' => 'pending',
                'metode_pembayaran' => $request->metode_pembayaran
            ]);

            // 2. Simpan Detail Makanan ke OrderItems
            foreach ($cartItems as $item) {
                detail_pesanan::create([
                    'id_order' => $pesanan->id,
                    'id_menu'  => $item->id_menu,
                    'kuantitas' => $item->kuantitas,
                    'harga'    => $item->menu->harga
                ]);
            }

            // 3. Kosongkan Keranjang User
            keranjang::where('id_user', Auth::id())->delete();
        });

        return redirect()->route('orders')->with('success', 'Pesanan berhasil dibuat!');
    }
}