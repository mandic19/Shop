<?php

namespace App\Models\Schemas;

/**
 * @OA\Schema(
 *     schema="Product",
 *     required={"id", "title", "handle", "price"},
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="Unique identifier for the product",
 *         example="550e8400-e29b-41d4-a716-446655440000"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Product title",
 *         example="Ergonomic Office Chair"
 *     ),
 *     @OA\Property(
 *         property="handle",
 *         type="string",
 *         description="URL-friendly slug for the product",
 *         example="ergonomic-office-chair"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="decimal",
 *         description="Product price",
 *         example=199.99
 *     ),
 *     @OA\Property(
 *         property="image_id",
 *         type="string",
 *         format="uuid",
 *         nullable=true,
 *         description="ID of the product's primary image",
 *         example="550e8400-e29b-41d4-a716-446655440001"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="When the product was created",
 *         example="2025-05-07T14:30:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="When the product was last updated",
 *         example="2025-05-07T14:30:00Z"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         description="The product's primary image",
 *         nullable=true,
 *         ref="#/components/schemas/Image"
 *     ),
 *     @OA\Property(
 *         property="variants",
 *         description="Product variants",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Variant")
 *     )
 * )
 */
class ProductSchema
{
    // This is a documentation class for Swagger and doesn't contain actual implementation
}
