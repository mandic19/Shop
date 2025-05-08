<?php

namespace App\Http\Requests\Variant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="UpdateVariantRequest",
 *     @OA\Property(
 *         property="handle",
 *         type="string",
 *         description="URL-friendly slug for the variant",
 *         example="ergonomic-chair-blue"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="decimal",
 *         description="Variant price",
 *         example=229.99
 *     )
 * )
 */
class UpdateVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'handle' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('variants')->ignore($this->route('id'))
            ],
            'price' => 'sometimes|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'handle.unique' => 'This variant handle is already in use',
            'price.min' => 'Price cannot be negative',
        ];
    }
}
