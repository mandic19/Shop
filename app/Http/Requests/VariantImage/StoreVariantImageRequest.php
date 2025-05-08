<?php
namespace App\Http\Requests\VariantImage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(
 *     schema="CreateVariantImageRequest",
 *     type="object",
 *     title="Create Variant Image Request",
 *     required={"variant_id", "image_id"},
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
 *         description="Image position order (optional, auto-calculated if not provided)"
 *     )
 * )
 */
class StoreVariantImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'variant_id' => [
                'required',
                'uuid',
                'exists:variants,id',
                function ($attribute, $value, $fail) {
                    // Check the number of existing images for this variant
                    $existingImagesCount = DB::table('variant_images')
                        ->where('variant_id', $value)
                        ->count();

                    if ($existingImagesCount >= 20) {
                        $fail('A variant can have a maximum of 20 images.');
                    }
                },
            ],
            'image_id' => 'required|uuid|exists:images,id',
            'position' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'variant_id.required' => 'The variant ID is required.',
            'variant_id.uuid' => 'The variant ID must be a valid UUID.',
            'variant_id.exists' => 'The specified variant does not exist.',
            'variant_id.max_images' => 'A variant can have a maximum of 20 images.',
            'image_id.required' => 'The image ID is required.',
            'image_id.uuid' => 'The image ID must be a valid UUID.',
            'image_id.exists' => 'The specified image does not exist.',
            'position.integer' => 'The position must be an integer.',
            'position.min' => 'The position must be at least 0.',
        ];
    }
}
