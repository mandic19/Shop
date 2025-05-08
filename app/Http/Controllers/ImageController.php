<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\Image\StoreImageRequest;
use App\Http\Requests\Image\UpdateImageRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *     name="Images",
 *     description="API Endpoints for managing images"
 * )
 */
class ImageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/images",
     *     summary="Get a paginated list of images",
     *     description="Returns a paginated list of all images",
     *     operationId="listImages",
     *     tags={"Images"},
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
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Image")),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=5),
     *                 @OA\Property(property="per_page", type="integer", example=15),
     *                 @OA\Property(property="total", type="integer", example=75)
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $images = Image::paginate($perPage);

        return response()->json([
            'data' => $images->items(),
            'meta' => [
                'current_page' => $images->currentPage(),
                'last_page' => $images->lastPage(),
                'per_page' => $images->perPage(),
                'total' => $images->total()
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/images",
     *     summary="Create a new image",
     *     description="Creates a new image and returns the created image",
     *     operationId="storeImage",
     *     tags={"Images"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Image data",
     *         @OA\JsonContent(ref="#/components/schemas/StoreImageRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Image created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Image created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Image")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreImageRequest $request)
    {
        $validated = $request->validated();

        $image = Image::create([
            'id' => Str::uuid(),
            'url' => $validated['url']
        ]);

        return response()->json([
            'message' => 'Image created successfully',
            'data' => $image
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/images/{id}",
     *     summary="Get a specific image",
     *     description="Returns a specific image",
     *     operationId="getImage",
     *     tags={"Images"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the image to retrieve",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Image")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Image not found"
     *     )
     * )
     */
    public function show($id)
    {
        $image = Image::findOrFail($id);

        return response()->json([
            'data' => $image
        ]);
    }

    /**
     * @OA\Put(
     *     path="/images/{id}",
     *     summary="Update an image",
     *     description="Updates an image and returns the updated image",
     *     operationId="updateImage",
     *     tags={"Images"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the image to update",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Image data",
     *         @OA\JsonContent(ref="#/components/schemas/UpdateImageRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Image updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Image updated successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Image")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Image not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateImageRequest $request, $id)
    {
        $image = Image::findOrFail($id);
        $validated = $request->validated();

        $image->update($validated);

        return response()->json([
            'message' => 'Image updated successfully',
            'data' => $image
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/images/{id}",
     *     summary="Delete an image",
     *     description="Deletes an image and returns a success message",
     *     operationId="deleteImage",
     *     tags={"Images"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the image to delete",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Image deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Image not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();

        return response()->json([
            'message' => 'Image deleted successfully'
        ], Response::HTTP_NO_CONTENT);
    }
}
