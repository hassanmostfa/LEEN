<?php

namespace App\Http\Controllers\MVC\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Category;
class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::all();

            // Get count of subCategories for each category
            foreach ($categories as $category) {
                $category->subCategoriesCount = $category->subCategories->count();
            }
            
            return view('admin.categories.allCategories', compact('categories'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     try {
            
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.categories')->withErrors($validator)->withInput();
        }

        try
        {
            $category = new Category();
            $category->name = $request->name;
            $category->image = $request->file('image')->store('categories_images');
            $category->save();
    
            return redirect()->route('admin.categories')->with('success', 'تم اضافة التصنيف بنجاح');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

    }


    public function edit($id)
    {
        try {
            $category = Category::find($id);
            return view('admin.categories.editCategory', compact('category'));
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
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('admin.categories')->withErrors($validator)->withInput();
        }
    
        try {
            // Find the category by ID
            $category = Category::find($id);
            
            // Update the name
            $category->name = $request->name;
    
            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($category->image) {
                    $oldImagePath = storage_path('app/' . $category->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Delete old image from storage
                    }
                }
    
                // Store the new image
                $newImagePath = $request->file('image')->store('categories_images');
                $category->image = $newImagePath;
            }
    
            // Save the category with updated data
            $category->save();
    
            return redirect()->route('admin.categories')->with('success', 'تم تعديل التصنيف بنجاح');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
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
            $category = Category::find($id);
            $category->delete();
    
            return redirect()->route('admin.categories')->with('success', 'تم حذف التصنيف بنجاح');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
