<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Sliders as SliderModel;
use Illuminate\Support\Str;

class Sliders extends Controller
{
    public function SliderIndex()
    {
        $all_data = SliderModel::all();
        View::share("sliders", $all_data);
        return view('settings.sliders');
    }

    public function SliderPost(Request $request)
    {
        $request->validate([
            'add_name' => 'required|min:5|max:255',
            'add_url' => 'required|url|max:255',
            'image' => 'required|image|mimes:png,jpeg,gif|max:1024',
        ]);

        $directory = 'assets/media/sliders/';
        $image = $request->file('image');
        $image_name = Str::slug($request->add_name) . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();

        $image->move($directory, $image_name);
        $image_name = $directory . $image_name;

        $data = SliderModel::create([
            "name" => $request->add_name,
            "url" => $request->add_url,
            "img" => $image_name,
        ]);

        return redirect()->back()->with($data ? "success" : "error", true);
    }


    public function SliderDelete($id)
    {
        $check = SliderModel::find($id);
        if ($check) {
            if (file_exists($check->img)) {
                unlink($check->img);
            }
            return redirect()->back()->with($check->delete() ? "success" : "error", true);;
        }
        return redirect()->back()->with("error", true);
    }
}
