<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem; // Tambahkan ini agar detail makanan tersimpan di order
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // 1. Menampilkan Halaman Keranjang
    public function index()
    {
        $cartItems = Cart::with('food')
            ->where('user_id', Auth::id())
            ->get();

        // Hitung subtotal
        $subtotal = $cartItems->sum(function($item) {
            return $item->food->price * $item->quantity;
        });

        $shipping = 10000; 

        return view('pages.cart', compact('cartItems', 'subtotal', 'shipping'));
    }

    // 2. Update Jumlah (Quantity) di Keranjang
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

    // 3. Menghapus Item dari Keranjang
    public function destroy($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Item berhasil dihapus');
    }

    // 4. Menampilkan Halaman Checkout
    public function checkout()
    {
        $cartItems = Cart::with('food')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Keranjang kamu kosong');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->food->price * $item->quantity;
        });

        $shipping = 10000;

        return view('pages.checkout', compact('cartItems', 'subtotal', 'shipping'));
    }

    // 5. Memproses Pesanan (Checkout Process)
    public function processOrder(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required' // Sesuaikan name di form HTML kamu
        ]);

        $cartItems = Cart::with('food')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('menu')->with('error', 'Keranjang sudah kosong');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->food->price * $item->quantity;
        });

        // Gunakan Database Transaction agar aman
        DB::transaction(function () use ($request, $cartItems, $subtotal) {
            // 1. Buat Data Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $subtotal + 10000,
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => 'pending',
                'payment_method' => $request->payment_method
            ]);

            // 2. Kosongkan Keranjang
            Cart::where('user_id', Auth::id())->delete();
        });

        return redirect()->route('orders')->with('success', 'Pesanan berhasil dibuat! Silakan tunggu konfirmasi.');
    }
}