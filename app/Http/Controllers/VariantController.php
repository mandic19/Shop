<?php

namespace App\Http\Controllers;

use App\Http\Requests\Variant\StoreVariantRequest;
use App\Http\Requests\Variant\UpdateVariantRequest;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Variants",
 *     description="API Endpoints for managing product variants"
 * )
 */
class VariantController extends Controller
{
    /**
     * @OA\Get(
     *     path="/variants",
     *     summary="Get a paginated list of variants",
     *     description="Returns a paginated list of variants",
     *     operationId="listVariants",
     *     tags={"Variants"},
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
     *         name="product_id",
     *         in="query",
     *         description="Filter variants by product ID",
     *         required=false,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Variant")),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="has_more_pages", type="boolean", example=true),
     *                 @OA\Property(property="per_page", type="integer", example=15)
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
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 25);

        $query = Variant::query();

        if ($request->has('product_id')) {
            $query->where('product_id', $request->input('product_id'));
        }

        $variants = $query->simplePaginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $variants->items(),
            'meta' => [
                'current_page' => $variants->currentPage(),
                'has_more_pages' => $variants->hasMorePages(),
                'per_page' => $variants->perPage(),
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/variants",
     *     summary="Create a new variant",
     *     description="Creates a new variant",
     *     operationId="storeVariant",
     *     tags={"Variants"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Variant data",
     *         @OA\JsonContent(ref="#/components/schemas/StoreVariantRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Variant created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Variant created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Variant")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="handle", type="array", @OA\Items(type="string", example="The handle field is required."))
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
    public function store(StoreVariantRequest $request)
    {
        $validated = $request->validated();

        $variant = Variant::create($validated);

        return response()->json([
            'message' => 'Variant created successfully',
            'data' => $variant
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/variants/{id}",
     *     summary="Get a specific variant",
     *     description="Returns a specific variant with its details",
     *     operationId="getVariant",
     *     tags={"Variants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the variant to retrieve",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Variant")
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
    public function show($id)
    {
        $variant = Variant::with('product')->findOrFail($id);

        return response()->json([
            'data' => $variant
        ]);
    }

    /**
     * @OA\Put(
     *     path="/variants/{id}",
     *     summary="Update a variant",
     *     description="Updates a variant and returns the updated variant",
     *     operationId="updateVariant",
     *     tags={"Variants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the variant to update",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Variant data",
     *         @OA\JsonContent(ref="#/components/schemas/UpdateVariantRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Variant updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Variant updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Variant")
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
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="price", type="array", @OA\Items(type="string", example="The price must be a positive number."))
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
    public function update(UpdateVariantRequest $request, $id)
    {
        $variant = Variant::findOrFail($id);
        $validated = $request->validated();

        $variant->update($validated);

        return response()->json([
            'message' => 'Variant updated successfully',
            'data' => $variant
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/variants/{id}",
     *     summary="Delete a variant",
     *     description="Deletes a variant and returns a success message",
     *     operationId="deleteVariant",
     *     tags={"Variants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the variant to delete",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Variant deleted successfully"
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
    public function destroy($id)
    {
        $variant = Variant::findOrFail($id);
        $variant->delete();

        return response()->json([
            'message' => 'Variant deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }
}
