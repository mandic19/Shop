<?php

namespace App\Models\Schemas;

/**
 * @OA\Schema(
 *     schema="Image",
 *     required={"id", "url"},
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="Unique identifier for the image",
 *         example="550e8400-e29b-41d4-a716-446655440001"
 *     ),
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         description="URL of the image",
 *         example="https://example.com/images/chair.jpg"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="When the image was created",
 *         example="2025-05-07T14:30:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="When the image was last updated",
 *         example="2025-05-07T14:30:00Z"
 *     )
 * )
 */
class ImageSchema
{
    // This is a documentation class for Swagger and doesn't contain actual implementation
}
