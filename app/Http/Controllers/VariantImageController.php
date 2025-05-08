<?php

namespace App\Http\Controllers;

use App\Http\Requests\VariantImage\UpdateVariantImageRequest;
use App\Http\Requests\VariantImage\StoreVariantImageRequest;
use App\Models\Variant;
use App\Models\VariantImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Variant Images",
 *     description="API Endpoints for managing product variant images"
 * )
 */
class VariantImageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/variants/{variant_id}/images",
     *     summary="List variant images",
     *     tags={"Variant Images"},
     *     @OA\Parameter(
     *         name="variant_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Variant not found"
     *     )
     * )
     */
    public function index(string $variantId): JsonResponse
    {
        $variant = Variant::findOrFail($variantId);

        $variantImages = VariantImage::where('variant_id', $variantId)
            ->with('image')
            ->orderBy('position')
            ->get();

        return response()->json($variantImages);
    }

    /**
     * @OA\Get(
     *     path="/api/variant-images/{id}",
     *     summary="Get a specific variant image",
     *     tags={"Variant Images"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Variant image not found"
     *     )
     * )
     */
    public function show(string $id): JsonResponse
    {
        $variantImage = VariantImage::with('image')->findOrFail($id);

        return response()->json($variantImage);
    }

    /**
     * @OA\Post(
     *     path="/api/variants/{variant_id}/images",
     *     summary="Create a new variant image",
     *     tags={"Variant Images"},
     *     @OA\Parameter(
     *         name="variant_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Variant image created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreVariantImageRequest $request, string $variantId): JsonResponse
    {
        $variant = Variant::findOrFail($variantId);

        $validatedData = $request->validated();
        $validatedData['variant_id'] = $variantId;

        // Determine the next position
        $maxPosition = VariantImage::where('variant_id', $variantId)->max('position') ?? 0;
        $validatedData['position'] = $maxPosition + 1;

        $variantImage = VariantImage::create($validatedData);

        return response()->json($variantImage, Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/variant-images/{id}",
     *     summary="Update a variant image",
     *     tags={"Variant Images"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Variant image updated successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Variant image not found"
     *     )
     * )
     */
    public function update(UpdateVariantImageRequest $request, string $id): JsonResponse
    {
        $variantImage = VariantImage::findOrFail($id);

        $validatedData = $request->validated();

        $variantImage->update($validatedData);

        return response()->json($variantImage);
    }

    /**
     * @OA\Delete(
     *     path="/api/variant-images/{id}",
     *     summary="Delete a variant image",
     *     tags={"Variant Images"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Variant image deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Variant image not found"
     *     )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        $variantImage = VariantImage::findOrFail($id);
        $variantImage->delete();

        return response()->json([
            'message' => 'Variant image deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }
}
