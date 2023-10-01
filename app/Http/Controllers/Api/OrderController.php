<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Midtrans\CreatePaymentUrlService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(Request $request) {
        $order = Order::create([
            'user_id' => $request->user()->id, //info id saat login
            'seller_id' => $request->seller_id, //info id saat login
            'number' => time(),
            'total_price' => $request->total_price,
            'payment_status' => 1,
            'delivery_address' => $request->delivery_address,
        ]);

        //buat menagkam order item yg di kirim
        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);
        }

        //setelah item terbentuk maka akan memanggil service midtrans untuk mendapatkan payment url
        $midtrans = new CreatePaymentUrlService(); //get midtrans
        $paymentUrl = $midtrans->getPaymentUrl($order->load('user', 'orderItems'));
        $order->update([
            'payment_url' => $paymentUrl
        ]);

        return response()->json([
            'data' => $order
        ]);
    }
}
