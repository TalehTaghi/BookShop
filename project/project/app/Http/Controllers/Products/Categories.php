<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Models\Categories as CategoryModel;

class Categories extends Controller
{
    public function categoriesListIndex() {
        $all_data = CategoryModel::all();
        View::share("all_data", $all_data);

        return view('products.categories');
    }

    public function categoriesAddIndex() {
        $main_categories = CategoryModel::where("main_category", 0)->get();
        View::share("main_categories", $main_categories);

        return view('products.category-add');
    }

    public function categoriesAddPost(Request $request) {
        $request->validate([
           'name' => 'required|max:150|min:5',
        ]);

        $data = CategoryModel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'main_category' => $request->main_category != "" || $request->main_category != null ? $request->main_category : 0,
        ]);

        return redirect()->back()->with($data ? "success" : "error" , true);
    }

    public function categoriesView(Request $request) {
        $category = CategoryModel::find($request->id);

        if ($category) {
            return $category;
        }

        return 0;
    }

    public function categoryEdit(Request $request) {
        $request->validate([
            'edit_name_category' => 'required|min:5|max:150',
        ]);

        $category = CategoryModel::find($request->edit_id_category);
        if($category) {
            if ($request->edit_main_category == $category->id) {
                return redirect()->back()->with('error_same_category', true);
            }

            if ($request->edit_main_category != "0") {
                $selected_main_category = CategoryModel::find($request->edit_main_category);
                if ($selected_main_category) {
                    if ($selected_main_category->main_category == $request->edit_id_category) {
                        $selected_main_category->main_category = "0";
                        $selected_main_category->save();
                    }
                } else {
                    return redirect()->back()->with('error', true);
                }
            }
            else {
                $selected_main_category = null;
            }

            $category->main_category = $request->edit_main_category;

            if ($request->edit_status_category === "1") {
                if ($selected_main_category && $selected_main_category->status === "0") {
                    return redirect()->back()->with('error_deaktiv', true);
                }
            }

            if ($request->edit_status_category === "0") {
                $child_categories = CategoryModel::where("main_category", $request->edit_id_category)->get();
                if ($child_categories) {
                    foreach ($child_categories as $child) {
                        $child->status = "0";
                        $child->save();
                    }
                } else {
                    return redirect()->back()->with('error', true);
                }
            }

            $category->status = $request->edit_status_category;

            $category->name = $request->edit_name_category;

            return redirect()->back()->with($category->save() ? "success" : 'error', true);
        }else{
            return redirect()->back()->with('error', true);
        }
    }
}
