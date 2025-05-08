<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreImageRequest",
 *     required={"url"},
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         format="uri",
 *         description="URL of the image",
 *         example="https://example.com/images/chair.jpg"
 *     )
 * )
 */
class StoreImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => 'required|string|url|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'url.required' => 'The image URL is required',
            'url.url' => 'The image URL must be a valid URL',
            'url.max' => 'The image URL may not be greater than 2048 characters',
        ];
    }
}
