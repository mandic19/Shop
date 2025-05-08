<?php

namespace App\Models\Schemas;

/**
 * @OA\Schema(
 *     schema="Variant",
 *     required={"id", "product_id", "handle", "price"},
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="Unique identifier for the variant",
 *         example="550e8400-e29b-41d4-a716-446655440002"
 *     ),
 *     @OA\Property(
 *         property="product_id",
 *         type="string",
 *         format="uuid",
 *         description="ID of the product this variant belongs to",
 *         example="550e8400-e29b-41d4-a716-446655440000"
 *     ),
 *     @OA\Property(
 *         property="handle",
 *         type="string",
 *         description="URL-friendly slug for the variant",
 *         example="ergonomic-office-chair-red"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="decimal",
 *         description="Variant price",
 *         example=219.99
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="When the variant was created",
 *         example="2025-05-07T14:30:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="When the variant was last updated",
 *         example="2025-05-07T14:30:00Z"
 *     )
 * )
 */
class VariantSchema
{
    // This is a documentation class for Swagger and doesn't contain actual implementation
}
