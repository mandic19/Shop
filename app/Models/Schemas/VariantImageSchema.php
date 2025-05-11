<?php

namespace App\Models\Schemas;

/**
 * @OA\Schema(
 *     schema="VariantImage",
 *     type="object",
 *     title="Variant Image",
 *     description="A model representing an image associated with a variant",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="The unique identifier of the variant image",
 *         example="123e4567-e89b-12d3-a456-426614174000"
 *     ),
 *     @OA\Property(
 *         property="variant_id",
 *         type="string",
 *         format="uuid",
 *         description="The identifier of the associated variant",
 *         example="123e4567-e89b-12d3-a456-426614174001"
 *     ),
 *     @OA\Property(
 *         property="image_id",
 *         type="string",
 *         format="uuid",
 *         description="The identifier of the associated image",
 *         example="123e4567-e89b-12d3-a456-426614174002"
 *     ),
 *     @OA\Property(
 *         property="position",
 *         type="integer",
 *         description="The display order position of the image",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the record was created",
 *         example="2025-05-01T12:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The date and time when the record was last updated",
 *         example="2025-05-01T12:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="image",
 *         description="The associated image model",
 *         ref="#/components/schemas/Image"
 *     ),
 *     @OA\Property(
 *         property="variant",
 *         description="The associated variant model",
 *         ref="#/components/schemas/Variant"
 *     )
 * )
 */
class VariantImageSchema
{
    // This is a documentation class for Swagger and doesn't contain actual implementation
}
