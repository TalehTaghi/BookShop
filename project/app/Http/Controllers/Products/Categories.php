<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Models\Categories as CategoryModel;

class Categories extends Controller
{
    public function CategoriesListIndex(){
        $all_data = CategoryModel::all();
        View::share("all_data",$all_data);
        return view('products.categories');
    }
    public function CategoriesAddIndex(){
        $main_categories = CategoryModel::where("main_category",0)->get();
        View::share("main_categories",$main_categories);
        return view('products.category-add');
    }
    public function CategoriesAddPost(Request $request){
        $request->validate([
            'name' => 'required|max:150|min:5',
        ]);

        $data = CategoryModel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'main_category' => $request->main_category !="" || $request->main_category !=null ? $request->main_category : 0,
        ]);

        return redirect()->back()->with($data ? "success" :"error",true);
    }

    public function CategoryGet(Request $request) {
        $data = CategoryModel::find($request->id);
        if ($data) {
            return $data;
        }
        return null;
    }

    public function CategoryEdit(Request $request) {
        $request->validate([
            'edit_name' => 'required|max:150',
        ]);

        $category = CategoryModel::find($request->edit_id);
        if ($category) {
            if ($request->edit_main == "-1" && $request->edit_status == "1") {
                return redirect()->back()->with("error_category", true);
            }

            if ($category->MainCategoryData($request->edit_main)) {
                if ($category->MainCategoryData($request->edit_main)->status == "0" && $request->edit_status == "1") {
                    return redirect()->back()->with("error_status", true);
                }
            }

            $category->name = $request->edit_name;
            if ($category->main_category != "0") {
                $category->main_category = $request->edit_main;
            } else {
                $sub_categories = $category->SubCategoryGet($request->edit_id);
                if ($sub_categories) {
                    foreach ($sub_categories as $sub) {
                        $sub->status = "0";
                        $sub->save();
                    }
                }
            }
            $category->status = $request->edit_status;

            return redirect()->back()->with($category->save() ? "success" : "error", true);
        }
        else {
            return redirect()->back()->with("error");
        }
    }

    public function delete($id){
        $check = CategoryModel::find($id);
        if($check){
            $check_main = CategoryModel::where(["id"=>$id,"main_category"=>"0"])->first();
            if($check_main) {
                $sub_categories = CategoryModel::where("main_category", $id)->get();
                foreach ($sub_categories as $sub) {
                    $sub->status = "0";
                    $sub->main_category = -1;
                    $sub->save();
                }
                $check_main->delete();
            }
            $check->delete();

        }

        return redirect()->back();
    }

}
