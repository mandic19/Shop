<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateImageRequest",
 *     required={"url"},
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         format="uri",
 *         description="URL of the image",
 *         example="https://example.com/images/updated-chair.jpg"
 *     )
 * )
 */
class UpdateImageRequest extends FormRequest
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
