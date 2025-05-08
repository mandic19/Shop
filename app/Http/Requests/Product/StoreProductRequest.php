<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreProductRequest",
 *     required={"title", "handle", "price"},
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
 *     )
 * )
 */
class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'handle' => 'required|string|max:255|unique:products',
            'price' => 'required|numeric|min:0',
            'image_id' => 'nullable|uuid|exists:images,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The product title is required',
            'handle.unique' => 'This product handle is already in use',
            'price.min' => 'Price cannot be negative',
            'image_id.exists' => 'The selected image does not exist',
        ];
    }
}
