<?php

namespace App\Models\Schemas;

/**
 * @OA\Schema(
 *     schema="OrderItem",
 *     required={"id", "order_id", "product_id", "quantity", "unit_price", "total_price"},
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="Unique identifier for the order item",
 *         example="750e8400-e29b-41d4-a716-446655440000"
 *     ),
 *     @OA\Property(
 *         property="order_id",
 *         type="string",
 *         format="uuid",
 *         description="Identifier of the parent order",
 *         example="850e8400-e29b-41d4-a716-446655440000"
 *     ),
 *     @OA\Property(
 *         property="product_id",
 *         type="string",
 *         format="uuid",
 *         description="Identifier of the ordered product",
 *         example="550e8400-e29b-41d4-a716-446655440000"
 *     ),
 *     @OA\Property(
 *         property="variant_id",
 *         type="string",
 *         format="uuid",
 *         nullable=true,
 *         description="Identifier of the product variant (if applicable)",
 *         example="650e8400-e29b-41d4-a716-446655440000"
 *     ),
 *     @OA\Property(
 *         property="quantity",
 *         type="integer",
 *         description="Quantity of the product ordered",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="unit_price",
 *         type="number",
 *         format="decimal",
 *         description="Price per unit of the product",
 *         example=99.99
 *     ),
 *     @OA\Property(
 *         property="total_price",
 *         type="number",
 *         format="decimal",
 *         description="Total price for this order item (quantity * unit_price)",
 *         example=199.98
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the order item was created",
 *         example="2025-05-07T14:30:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the order item was last updated",
 *         example="2025-05-07T14:30:00Z"
 *     ),
 *     @OA\Property(
 *         property="product",
 *         description="The product details",
 *         ref="#/components/schemas/Product"
 *     ),
 *     @OA\Property(
 *         property="variant",
 *         description="The product variant details (if applicable)",
 *         nullable=true,
 *         ref="#/components/schemas/Variant"
 *     )
 * )
 */
class OrderItemSchema {
    // This is a documentation class for Swagger and doesn't contain actual implementation
}
