<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateProductRequest",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Product title",
 *         example="Updated Office Chair"
 *     ),
 *     @OA\Property(
 *         property="handle",
 *         type="string",
 *         description="URL-friendly slug for the product",
 *         example="updated-office-chair"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="decimal",
 *         description="Product price",
 *         example=249.99
 *     ),
 *     @OA\Property(
 *         property="image_id",
 *         type="string",
 *         format="uuid",
 *         nullable=true,
 *         description="ID of the product's primary image",
 *         example="550e8400-e29b-41d4-a716-446655440001"
 *     )
 * )
 */
class UpdateProductRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'handle' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('products')->ignore($this->route('product'))
            ],
            'price' => 'sometimes|numeric|min:0',
            'image_id' => 'nullable|uuid|exists:images,id',
        ];
    }

    public function messages(): array
    {
        return [
            'handle.unique' => 'This product handle is already in use',
            'price.min' => 'Price cannot be negative',
            'image_id.exists' => 'The selected image does not exist',
        ];
    }
}
