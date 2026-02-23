<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem; 
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
        $cartItems = Cart::with('food')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->food->price * $item->quantity;
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

        $food = Food::findOrFail($id);
        
        // Cek apakah produk sudah ada di keranjang user
        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('food_id', $id)
                        ->first();

        if ($cartItem) {
            // Jika sudah ada, cukup tambahkan jumlahnya
            $cartItem->update([
                'quantity' => $cartItem->quantity + 1
            ]);
        } else {
            // Jika belum ada, buat baris baru di tabel carts
            Cart::create([
                'user_id' => Auth::id(),
                'food_id' => $id,
                'quantity' => 1
            ]);
        }

        return back()->with('success', $food->name . ' berhasil ditambah ke keranjang!');
    }

    /**
     * 3. Update Jumlah di Keranjang (Tombol +/- di halaman Cart)
     */
    public function update(Request $request, $id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $newQuantity = $cart->quantity + $request->change;
        
        if ($newQuantity > 0) {
            $cart->update(['quantity' => $newQuantity]);
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
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Item berhasil dihapus');
    }

    /**
     * 5. Halaman Checkout
     */
   // App/Http/Controllers/CartController.php

public function checkout()
{
    // Ambil data keranjang user yang sedang login
    $cartItems = Cart::with('food')->where('user_id', Auth::id())->get();
    
    // Jika kosong, kirim kembali ke menu dengan pesan peringatan
    if ($cartItems->isEmpty()) {
        return redirect()->route('menu')->with('error', 'Keranjang belanja Anda masih kosong.');
    }

    $subtotal = $cartItems->sum(function($item) {
        return $item->food->price * $item->quantity;
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
            'address' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required'
        ]);

        $cartItems = Cart::with('food')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Keranjang sudah kosong');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->food->price * $item->quantity;
        });

        // Database Transaction untuk keamanan data
        DB::transaction(function () use ($request, $cartItems, $subtotal) {
            // 1. Buat Data Order Utama
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $subtotal + 10000,
                'deliveryAddress' => $request->address,
                'phone' => $request->phone,
                'status' => 'pending',
                'payment_method' => $request->payment_method
            ]);

            // 2. Simpan Detail Makanan ke OrderItems
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'food_id'  => $item->food_id,
                    'quantity' => $item->quantity,
                    'price'    => $item->food->price
                ]);
            }

            // 3. Kosongkan Keranjang User
            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('orders')->with('success', 'Pesanan berhasil dibuat!');
    }
}