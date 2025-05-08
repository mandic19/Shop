<?php

namespace App\Http\Requests\Variant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(
 *     schema="StoreVariantRequest",
 *     required={"handle", "price", "product_id"},
 *     @OA\Property(
 *         property="handle",
 *         type="string",
 *         description="URL-friendly slug for the variant",
 *         example="ergonomic-chair-red"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="decimal",
 *         description="Variant price",
 *         example=219.99
 *     ),
 *     @OA\Property(
 *         property="product_id",
 *         type="string",
 *         format="uuid",
 *         description="Product identifier"
 *     )
 * )
 */
class StoreVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'handle' => 'required|string|max:255|unique:variants',
            'price' => 'required|numeric|min:0',
            'product_id' => [
                'required',
                'uuid',
                'exists:products,id',
                function ($attribute, $value, $fail) {
                    // Check the number of existing variants for this product
                    $existingVariantsCount = DB::table('variants')
                        ->where('product_id', $value)
                        ->count();

                    if ($existingVariantsCount >= 2000) {
                        $fail('A product can have a maximum of 2000 variants.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'handle.required' => 'A handle is required for the variant',
            'handle.unique' => 'This variant handle is already in use',
            'handle.max' => 'The handle cannot exceed 255 characters',
            'price.required' => 'A price is required for the variant',
            'price.min' => 'Price cannot be negative',
            'product_id.required' => 'A product ID is required',
            'product_id.uuid' => 'The product ID must be a valid UUID',
            'product_id.exists' => 'The specified product does not exist',
            'product_id.max_variants' => 'A product can have a maximum of 2000 variants',
        ];
    }
}
