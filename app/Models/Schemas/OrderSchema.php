<?php

namespace App\Models\Schemas;

/**
 * @OA\Schema(
 *     schema="Order",
 *     required={"id", "total_amount"},
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="Unique identifier for the order",
 *         example="850e8400-e29b-41d4-a716-446655440000"
 *     ),
 *     @OA\Property(
 *         property="total_amount",
 *         type="number",
 *         format="decimal",
 *         description="Total amount of the order",
 *         example=299.97
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the order was created",
 *         example="2025-05-07T14:30:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the order was last updated",
 *         example="2025-05-07T14:30:00Z"
 *     ),
 *     @OA\Property(
 *         property="order_items",
 *         type="array",
 *         description="List of items in the order",
 *         @OA\Items(ref="#/components/schemas/OrderItem")
 *     )
 * )
 */
class OrderSchema {
    // This is a documentation class for Swagger and doesn't contain actual implementation
}
