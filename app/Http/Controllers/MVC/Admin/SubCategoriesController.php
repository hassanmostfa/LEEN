<?php

namespace App\Http\Controllers\MVC\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Category;
use App\Models\Admin\SubCategory;

class SubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // get all categories
            $categories = Category::all();
            //get all SubCategories
            $subCategories = SubCategory::all()->sortBy('category_id');
            return view('admin.categories.subCategories.subCategories', compact('subCategories' , 'categories'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try
        {
            $subCategory = new SubCategory();
            $subCategory->category_id = $request->category_id;
            $subCategory->name = $request->name;
            $subCategory->image = $request->file('image')->store('subcategories_images');
            $subCategory->save();
            return redirect()->route('admin.subCategories')->with('success', 'SubCategory Added Successfully');
        } catch (\Throwable $th) {
            return redirect()->route('admin.subCategories')->with('error', $th->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $subCategory = SubCategory::find($id);
            $categories = Category::all();
            return view('admin.categories.subCategories.editSubCategories', compact('subCategory' , 'categories'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'exists:categories,id',
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.subCategories')->withErrors($validator)->withInput();
        }

        try {
            // Find the category by ID
            $subCategory = SubCategory::find($id);

            
            // Update the name
            $subCategory->name = $request->name;

            if ($request->category_id) {
            $subCategory->category_id = $request->category_id;
            }


            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($subCategory->image) {
                    $oldImagePath = storage_path('app/' . $subCategory->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Delete old image from storage
                    }
                }
    
                // Store the new image
                $newImagePath = $request->file('image')->store('subcategories_images');
                $subCategory->image = $newImagePath;
            }
    
            // Save the category with updated data
            $subCategory->save();
    
            return redirect()->route('admin.subCategories')->with('success', 'تم تعديل التصنيف بنجاح');
        } catch (\Throwable $th) {
            return redirect()->route('admin.subCategories')->with('error', $th->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $subCategory = SubCategory::find($id);
            $subCategory->delete();
            return redirect()->route('admin.subCategories')->with('success', 'تم حذف التصنيف بنجاح');
        } catch (\Throwable $th) {
            return redirect()->route('admin.subCategories')->with('error', $th->getMessage());
        }
    }
    
    // Get Related SubCategories
    public function getSubcategories($categoryId)
    {
        // Fetch subcategories related to the category ID
        $subcategories = SubCategory::where('category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

}
