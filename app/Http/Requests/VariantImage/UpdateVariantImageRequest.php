<?php

namespace App\Http\Requests\VariantImage;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateVariantImageRequest",
 *     type="object",
 *     title="Update Variant Image Request",
 *     @OA\Property(
 *         property="variant_id",
 *         type="string",
 *         format="uuid",
 *         description="Variant identifier"
 *     ),
 *     @OA\Property(
 *         property="image_id",
 *         type="string",
 *         format="uuid",
 *         description="Image identifier"
 *     ),
 *     @OA\Property(
 *         property="position",
 *         type="integer",
 *         minimum=0,
 *         description="Image position order"
 *     )
 * )
 */
class UpdateVariantImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        /**
         * TODO: Replace "return true" with proper role-based authorization.
         * Only admin and product_manager roles should create/modify..
         */

        return true;
    }

    public function rules(): array
    {
        return [
            'variant_id' => 'sometimes|required|uuid|exists:variants,id',
            'image_id' => 'sometimes|required|uuid|exists:images,id',
            'position' => 'sometimes|required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'variant_id.required' => 'The variant ID is required.',
            'variant_id.uuid' => 'The variant ID must be a valid UUID.',
            'variant_id.exists' => 'The specified variant does not exist.',
            'image_id.required' => 'The image ID is required.',
            'image_id.uuid' => 'The image ID must be a valid UUID.',
            'image_id.exists' => 'The specified image does not exist.',
            'position.required' => 'The position is required when provided.',
            'position.integer' => 'The position must be an integer.',
            'position.min' => 'The position must be at least 0.',
        ];
    }
}
