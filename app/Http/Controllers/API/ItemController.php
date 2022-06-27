<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Property;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/item",
     * operationId="getItems",
     * tags={"Item"},
     * summary="Get Items List",
     * description="Get Items List",
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *         @OA\JsonContent(
     *              @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Item"))
     *              ,)
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function index()
    {
        return response(['items' => \App\Http\Resources\ItemResource::collection(Item::with(['properties'])->get())]);
    }

    /**
     * @OA\Post(
     * path="/api/item",
     * operationId="storeItem",
     * tags={"Item"},
     * summary="Store new item",
     * description="Store new item",
     * @OA\RequestBody(
     *    description="Pass property data",
     *    @OA\JsonContent(
     *        allOf={
     *           @OA\Schema(ref="#/components/schemas/Item"),
     *        },
     *    )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *         @OA\JsonContent(
     *              @OA\Property(property="item", type="object", ref="#/components/schemas/Item")
     *              ,)
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = \Validator::make($data, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 400);
        }

        $item = \App\Models\Item::create($data);

        /**
         * add properties
         */
        if (isset($data['properties'])) {
            foreach ($data['properties'] as $property) {
                if (isset($property['name'])) {
                    $item->properties()->save(new \App\Models\Property($property));
                }
            }
        }

        return response(['item' => new \App\Http\Resources\ItemResource($item->load('properties')), 'message' => 'Item created successfully']);
    }

    /**
     * @OA\Get(
     * path="/api/item/{id}",
     * operationId="getItem",
     * tags={"Item"},
     * summary="Show Item",
     * description="Show Item",
     *      @OA\Parameter(
     *          description="Item ID",
     *          in="path",
     *          name="id",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *          @OA\JsonContent(
     *              @OA\Property(property="item", type="object", ref="#/components/schemas/Item")
     *          ,)
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show(Item $item)
    {
        $item->load('properties');

        return response(['item' => new \App\Http\Resources\ItemResource($item)]);
    }

    /**
     * @OA\Post(
     * path="/api/item/{id}",
     * operationId="updateItem",
     * tags={"Item"},
     * summary="Update item item",
     * description="Update item",
     *  @OA\Parameter(
     *          description="Item ID",
     *          in="path",
     *          name="id",
     *          required=true
     *      ),
     * @OA\RequestBody(
     *    description="Pass property data",
     *    @OA\JsonContent(
     *        allOf={
     *           @OA\Schema(ref="#/components/schemas/Item"),
     *        },
     *    )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *         @OA\JsonContent(
     *              @OA\Property(property="item", type="object", ref="#/components/schemas/Item")
     *              ,)
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function update(Request $request, Item $item)
    {
        $data = $request->all();

        $validator = \Validator::make($data, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 400);
        }

        $item->update($data);

        $item->load('properties');

        return response(['item' => new \App\Http\Resources\ItemResource($item), 'message' => 'Item updated successfully']);
    }

    /**
     * @OA\Delete(
     * path="/api/item/{id}",
     * operationId="deleteItem",
     * tags={"Item"},
     * summary="Delete Item",
     * description="Show Item",
     *      @OA\Parameter(
     *          description="Item ID",
     *          in="path",
     *          name="id",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Item deleted successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string"),
     *          )
     *
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response(['message' => 'Item deleted successfully']);
    }

    /**
     * @OA\Post(
     * path="/api/item/{id}/property",
     * operationId="storeProperty",
     * tags={"Property"},
     * summary="Store new property",
     * description="Store new property",
     * @OA\RequestBody(
     *    description="Pass property data",
     *    @OA\JsonContent(
     *        allOf={
     *           @OA\Schema(ref="#/components/schemas/Property"),
     *        },
     *    )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *         @OA\JsonContent(
     *              @OA\Property(property="item", type="object", ref="#/components/schemas/Item")
     *              ,)
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function storeProperty(Request $request, Item $item)
    {
        $data = $request->all();

        $validator = \Validator::make($data, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 400);
        }

        $item->properties()->save(new \App\Models\Property($data));

        $item->load('properties');

        return response(['item' => new \App\Http\Resources\ItemResource($item), 'message' => 'Property stored successfully']);
    }

    /**
     * @OA\Delete(
     * path="/api/item/{item_id}/property/{property_id}",
     * operationId="deleteProperty",
     * tags={"Property"},
     * summary="Delete Property",
     * description="Delete property",
     *      @OA\Parameter(
     *          description="Item ID",
     *          in="path",
     *          name="item_id",
     *          required=true
     *      ),
     *  @OA\Parameter(
     *          description="Property ID",
     *          in="path",
     *          name="property_id",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Item deleted successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string"),
     *          )
     *
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function destroyProperty(Item $item, Property $property)
    {
        $property->delete();

        return response(['message' => 'property deleted successfully']);
    }

    /**
     * @OA\Post(
     * path="/api/item/{item_id}/property/{property_id}",
     * operationId="updateProperty",
     * tags={"Property"},
     * summary="update property",
     * description="Update  property",
     *      @OA\Parameter(
     *          description="Item ID",
     *          in="path",
     *          name="item_id",
     *          required=true
     *      ),
     *  @OA\Parameter(
     *          description="Property ID",
     *          in="path",
     *          name="property_id",
     *          required=true
     *      ),
     * @OA\RequestBody(
     *    description="Pass property data",
     *    @OA\JsonContent(
     *        allOf={
     *           @OA\Schema(ref="#/components/schemas/Property"),
     *        },
     *    )
     * ),
     *      @OA\Response(
     *          response=200,
     *          description="Ok",
     *         @OA\JsonContent(
     *              @OA\Property(property="item", type="object", ref="#/components/schemas/Item")
     *              ,)
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function updateProperty(Request $request, Item $item, Property $property)
    {
        $data = $request->all();

        $validator = \Validator::make($data, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 400);
        }

        $property->update($data);

        return response(['property' => new \App\Http\Resources\PropertyResource($item), 'message' => 'Property updated successfully']);
    }
}
