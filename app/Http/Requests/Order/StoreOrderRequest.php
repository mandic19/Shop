<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreOrderItemRequest",
 *     required={"product_id", "quantity"},
 *     @OA\Property(
 *         property="product_id",
 *         type="string",
 *         format="uuid",
 *         description="Unique identifier of the product",
 *         example="550e8400-e29b-41d4-a716-446655440000"
 *     ),
 *     @OA\Property(
 *         property="variant_id",
 *         type="string",
 *         format="uuid",
 *         nullable=true,
 *         description="Unique identifier of the product variant",
 *         example="650e8400-e29b-41d4-a716-446655440000"
 *     ),
 *     @OA\Property(
 *         property="quantity",
 *         type="integer",
 *         minimum=1,
 *         description="Quantity of the product to be ordered",
 *         example=2
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="StoreOrderRequest",
 *     required={"items"},
 *     @OA\Property(
 *         property="items",
 *         type="array",
 *         description="List of order items",
 *         @OA\Items(ref="#/components/schemas/StoreOrderItemRequest")
 *     )
 * )
 */
class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:variants,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'At least one order item is required.',
            'items.*.product_id.required' => 'Each item must have a product.',
            'items.*.product_id.exists' => 'The selected product does not exist.',
            'items.*.variant_id.exists' => 'The selected variant does not exist.',
            'items.*.quantity.required' => 'Quantity is required for each item.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'items.*.unit_price.min' => 'Unit price must be a positive number.',
        ];
    }
}
