<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderService
{
    public function createOrder(array $orderData): Order
    {
        return DB::transaction(function () use ($orderData) {
            $totalAmount = 0;
            $now = Carbon::now();

            $orderItems = [];

            foreach ($orderData['items'] as $itemData) {
                $product = Product::query()->findOrFail($itemData['product_id']);
                $variant = null;


                if (!empty($itemData['variant_id'])) {
                    $variant = Variant::query()->findOrFail($itemData['variant_id']);
                }

                $unitPrice = $variant?->price ?? $product->price;
                $quantity = $itemData['quantity'];
                $totalItemPrice = $unitPrice * $quantity;

                $orderItems[] = [
                    'id' => (string)Str::uuid7(),
                    'product_id' => $product->id,
                    'variant_id' => $variant?->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalItemPrice,
                    'created_at' => $now,
                    'updated_at' => $now
                ];

                // Accumulate total order amount
                $totalAmount += $totalItemPrice;
            }

            // Create order
            $order = Order::query()->create([
                'total_amount' => $totalAmount
            ]);

            // Modify order items to include order_id before insertion
            $orderItemsWithOrderId = array_map(function ($item) use ($order) {
                $item['order_id'] = $order->id;
                return $item;
            }, $orderItems);

            // Bulk insert order items with exception handling
            $insertSuccess = OrderItem::query()->insert($orderItemsWithOrderId);

            if (!$insertSuccess) {
                throw new \RuntimeException('Failed to create order items');
            }

            // Reload order items to get the inserted items
            $order->load('orderItems');

            return $order;
        });
    }
}
