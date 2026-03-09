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
        // Memastikan relasi 'menu' dimuat (Eager Loading)
        $cartItems = keranjang::with('menu')
            ->where('id_user', Auth::id())
            ->get();

        // Mengambil total dari kolom subtotal di database
        $subtotal = $cartItems->sum('subtotal');
        $shipping = 10000;

        return view('pages.cart', compact('cartItems', 'subtotal', 'shipping'));
    }

    /**
     * 2. Tambah Item ke Keranjang
     */
    public function addToCart(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $food = menu::findOrFail($id);
        
        $cartItem = keranjang::where('id_user', Auth::id())
                        ->where('id_menu', $id)
                        ->first();

        if ($cartItem) {
            // Update jumlah dan hitung ulang subtotal berdasarkan harga menu
            $newQty = $cartItem->kuantitas + 1;
            $cartItem->update([
                'kuantitas' => $newQty,
                'subtotal'  => $food->harga * $newQty
            ]);
        } else {
            // Buat data baru (id_user & id_menu sekarang diizinkan karena sudah masuk fillable)
            keranjang::create([
                'id_user'   => Auth::id(),
                'id_menu'   => $id,
                'kuantitas' => 1,
                'subtotal'  => $food->harga
            ]);
        }

        return back()->with('success', $food->nama_menu . ' berhasil ditambah ke keranjang!');
    }

    /**
     * 3. Update Jumlah di Keranjang (Tombol +/-)
     */
    public function update(Request $request, $id)
    {
        $cart = keranjang::with('menu')->where('id_keranjang', $id)
                         ->where('id_user', Auth::id())
                         ->firstOrFail();
        
        // Input 'change' bisa bernilai 1 atau -1 dari form
        $newQuantity = $cart->kuantitas + $request->change;
        
        if ($newQuantity > 0) {
            $cart->update([
                'kuantitas' => $newQuantity,
                'subtotal'  => $cart->menu->harga * $newQuantity
            ]);
        } else {
            $cart->delete();
        }

        return back()->with('success', 'Keranjang diperbarui');
    }

    /**
     * 4. Halaman Checkout
     */
    public function checkout()
    {
        $cartItems = keranjang::with('menu')->where('id_user', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Keranjang belanja kosong.');
        }

        $subtotal = $cartItems->sum('subtotal');
        $shipping = 10000;

        return view('pages.checkout', compact('cartItems', 'subtotal', 'shipping'));
    }

    /**
     * 5. Memproses Pesanan ke Tabel Orders
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

        $subtotal = $cartItems->sum('subtotal');

        // Menggunakan Database Transaction untuk mencegah data "menggantung" jika error
        DB::transaction(function () use ($request, $cartItems, $subtotal) {
            
            // 1. Simpan ke tabel pesanan
            $pesanan = pesanan::create([
                'id_user'           => Auth::id(),
                'subtotal'          => $subtotal,
                'ongkos_kirim'      => 10000,
                'total_harga'       => $subtotal + 10000,
                'alamat_pengiriman' => $request->alamat,
                'no_hp'             => $request->no_hp,
                'status'            => 'pending',
                'metode_pembayaran' => $request->metode_pembayaran
            ]);

            // 2. Simpan setiap item ke tabel detail_pesanan
            foreach ($cartItems as $item) {
                detail_pesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_menu'    => $item->id_menu,
                    'kuantitas'  => $item->kuantitas,
                    'harga'      => $item->menu->harga
                ]);
            }

            // 3. Hapus isi keranjang setelah pesanan sukses dibuat
            keranjang::where('id_user', Auth::id())->delete();
        });

        return redirect()->route('orders')->with('success', 'Pesanan Anda sedang diproses!');
    }
}