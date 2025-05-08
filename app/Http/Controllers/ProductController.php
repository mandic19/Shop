<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints for managing products"
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/products",
     *     summary="Get paginated list of products",
     *     description="Returns a paginated list of all products with their primary image",
     *     operationId="getProductsList",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Product")),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=3),
     *                 @OA\Property(property="per_page", type="integer", example=15),
     *                 @OA\Property(property="total", type="integer", example=45)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $products = Product::query()->paginate($perPage);

        return response()->json([
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total()
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     summary="Create a new product",
     *     description="Creates a new product and returns the created product",
     *     operationId="storeProduct",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product data",
     *         @OA\JsonContent(ref="#/components/schemas/StoreProductRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Product created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Product")
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
     *                 @OA\Property(property="title", type="array", @OA\Items(type="string", example="The title field is required."))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = Product::create([
            'id' => Str::uuid(),
            'title' => $validated['title'],
            'handle' => $validated['handle'],
            'price' => $validated['price'],
            'image_id' => $validated['image_id'] ?? null,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     summary="Get a specific product",
     *     description="Returns a specific product with its image and variants",
     *     operationId="getProduct",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product to retrieve",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function show($id)
    {
        $product = Product::with(['image'])->findOrFail($id);

        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * @OA\Put(
     *     path="/products/{id}",
     *     summary="Update a product",
     *     description="Updates a product and returns the updated product",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product to update",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product data",
     *         @OA\JsonContent(ref="#/components/schemas/UpdateProductRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Product updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Product")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
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
     *                 @OA\Property(property="title", type="array", @OA\Items(type="string"))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validated();

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product->fresh('image')
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     summary="Delete a product",
     *     description="Deletes a product and returns a success message",
     *     operationId="deleteProduct",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the product to delete",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Product deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Product not found"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }
}
