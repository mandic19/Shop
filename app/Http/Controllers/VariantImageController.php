<?php

namespace App\Http\Controllers;

use App\Http\Requests\VariantImage\UpdateVariantImageRequest;
use App\Http\Requests\VariantImage\StoreVariantImageRequest;
use App\Models\VariantImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     *     path="/variant-images",
     *     summary="List variant images",
     *     tags={"Variant Images"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=20)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="variant_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Filter images by variant ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/VariantImage")),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="has_more_pages", type="boolean", example=true),
     *                 @OA\Property(property="per_page", type="integer", example=20)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Attempts",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 1);
        $page = $request->input('page', 25);

        $query = VariantImage::query()->with('image')->orderBy('position');

        if ($request->has('variant_id')) {
            $query->where('variant_id', $request->input('variant_id'));
        }

        $variantImages = $query->simplePaginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $variantImages->items(),
            'meta' => [
                'current_page' => $variantImages->currentPage(),
                'has_more_pages' => $variantImages->hasMorePages(),
                'per_page' => $variantImages->perPage(),
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/variant-images/{id}",
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
     *         description="Successful response",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Variant image not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Variant image not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Attempts",
     *         @OA\JsonContent()
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
     *     path="/variant-images",
     *     summary="Create a new variant image",
     *     tags={"Variant Images"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreVariantImageRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Variant image created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VariantImage")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Variant not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Variant not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Attempts",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function store(StoreVariantImageRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $variantId = $validatedData['variant_id'];

        // Determine the next position
        $maxPosition = VariantImage::where('variant_id', $variantId)->max('position') ?? 0;
        $validatedData['position'] = $maxPosition + 1;

        $variantImage = VariantImage::create($validatedData);

        return response()->json($variantImage, Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/variant-images/{id}",
     *     summary="Update a variant image",
     *     tags={"Variant Images"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateVariantImageRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Variant image updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/VariantImage")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Variant image not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Variant image not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Attempts",
     *         @OA\JsonContent()
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
     *     path="/variant-images/{id}",
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
     *         description="Variant image deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Variant image deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Variant image not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Variant image not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Too Many Attempts",
     *         @OA\JsonContent()
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
