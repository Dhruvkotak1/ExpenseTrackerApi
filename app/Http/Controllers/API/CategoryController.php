<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::where("user_id", $request->user()->id)->get();
        return $this->sendResponse("Categories fetched successfully", $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateCategory = Validator::make($request->all(), [
            'name' => 'required|min:3'
        ]);

        if ($validateCategory->fails()) {
            return $this->sendError("Validation Error", $validateCategory->errors()->all(), 401);
        }

        $nameExists = Category::where("user_id", $request->user()->id)->where('name', $request->name)->exists();
        if ($nameExists) {
            return $this->sendError("Category name already Exists");;
        }

        $category = new Category();
        $category->user_id = $request->user()->id;
        $category->name = $request->name;

        if ($category->save()) {
            return $this->sendResponse("Catefory Created Successfully", $category);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $category = Category::where('user_id', $request->user()->id)->find($id);
        if ($category) {
            return $this->sendResponse("Category Found", $category);
        }
        return $this->sendError("Category not found");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::where('user_id', $request->user()->id)->find($id);
        if ($category) {
            $validateCategory = Validator::make($request->all(), [
                'name' => 'required|min:3'
            ]);
            if ($validateCategory->fails()) {
                return $this->sendError("Validation Error", $validateCategory->errors()->all(), 401);
            }

            $nameExists = Category::where("user_id", $request->user()->id)->where('name', $request->name)->exists();
            if ($nameExists) {
                return $this->sendError("Category name already Exists");;
            }
            $category->name = $request->name;
            if ($category->save()) {
                return $this->sendResponse("Category Update Successfully", $category);
            }
        }
        return $this->sendError("Update unsuccessfull. Category not found");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $category = Category::where('user_id', $request->user()->id)->find($id);
        if ($category) {
            Category::where('id', $id)->delete();
            return $this->sendResponse("Category deleted Successfully");
        }
        return $this->sendError("Category not found");
    }
}
