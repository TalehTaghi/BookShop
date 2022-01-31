<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product as ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Product extends Controller
{
    public function ProductsListIndex(){
        $all_data = ProductsModel::all();
        $main_category = Categories::where("main_category","0")->get();
        View::share("categories",$main_category);
        View::share("all_data",$all_data);
        return view('products.products');
    }

    public function ProductAddIndex(){
        $main_category = Categories::where("main_category","0")->get();
        View::share("categories",$main_category);
        return view('products.product-add');
    }

    public function ProductAddPost(Request $request){
        $request->validate([
            'category' => 'required',
            'name' => 'required|min:5|max:250',
            'author' => 'required|min:3|max:100',
            'about' => 'required',
            'image' => 'required|image|mimes:png,jpeg,gif|max:1024',
            'price' => 'required|min:0|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $directory = 'assets/media/products/';
        $image = $request->file('image');
        $image_name = Str::slug($request->name) . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();

        $image->move($directory, $image_name);
        $image_name = $directory . $image_name;

        $data = ProductsModel::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'author' => $request->author,
            'description' => $request->about,
            'img' => $image_name,
            'price' => $request->price,
            'read_count' => 0
        ]);

        return redirect()->back()->with($data ? "success" :"error",true);
    }

    public function ProductEdit(Request $request) {
        $request->validate([
            'edit_name' => 'required|max:250',
            'edit_author' => 'required|min:4|max:100',
            'edit_price' => 'required',
            'edit_img' => 'image|mimes:jpg,jpeg,png|max:1024'
        ]);

        $product = ProductsModel::find($request->edit_id);
        if ($product){
            if ($request->hasFile('edit_img')) {
                $image = $request->file('edit_img');
                $image_name = Str::slug($request->edit_name) .'-' .rand(1000,9999).'.' . $image->getClientOriginalExtension();
                $directory = 'assets/media/products/';
                if (file_exists($product->img)) {
                    unlink($product->img);
                }

                $image->move($directory, $image_name);
                $image_name = $directory.$image_name;
                $product->img = $image_name;
            }

            $product->name = $request->edit_name;
            $product->author = $request->edit_author;
            $product->category_id = $request->edit_category;
            if ($request->edit_about) {
                $product->description = $request->edit_about;
            }
            $product->price = $request->edit_price;
            $product->status = $request->edit_status;

            return redirect()->back()->with($product->save() ? "success" : "error", true);
        }
        else {
            return redirect()->back()->with("error", true);
        }
    }

    public function ProductDelete($id) {
        $check = ProductsModel::find($id);
        if ($check) {
            if (file_exists($check->img)) {
                unlink($check->img);
            }
            return redirect()->back()->with($check->delete() ? "success" : "error", true);;
        }
        return redirect()->back()->with("error", true);
    }

    public function ProductGet(Request $request) {
        $data = ProductsModel::find($request->id);
        if ($data) {
            return $data;
        }
        return null;
    }
}
