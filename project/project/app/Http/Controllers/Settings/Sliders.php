<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sliders as SliderModel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Sliders extends Controller
{
    public function sliderIndex() {
        $all_data = SliderModel::all();
        View::share("data", $all_data);

        return view('settings.sliders ');
    }

    public function getSlider(Request $request) {
        $slider = SliderModel::find($request->id);
        if ($slider) {
            return $slider;
        }
        return 0;
    }

    public function sliderEdit(Request $request) {
        $request->validate([
            'edit_name_slider' => 'required|min:5|max:255',
            'edit_url' => 'required|url|max:255',
            'image_edit' => 'image|mimes:png,jpeg,gif|max:1024'
        ]);

        $slider = SliderModel::find($request->edit_id_slider);
        if($slider) {
            if ($slider->name != $request->edit_name_slider) {
                $request->validate([
                    'image_edit' => 'required'
                ]);
            }

            if ($request->file('image_edit')) {
                $directory = 'assets/media/sliders/';
                $image = $request->file('image_edit');
                $image_name = Str::slug($request->edit_name_slider) . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();

                if (file_exists($slider->img)) {
                    unlink($slider->img);
                }

                $image->move($directory, $image_name);
                $image_name = $directory . $image_name;

                $slider->img = $image_name;
            }

            $slider->name = $request->edit_name_slider;
            $slider->url = $request->edit_url;
            $slider->status = $request->edit_status_slider;

            return redirect()->back()->with($slider->save() ? "success" : 'error', true);
        }else{
            return redirect()->back()->with('error', true);
        }
    }

    public function sliderPost(Request $request) {
        $request->validate([
            'add_name' => 'required|min:5|max:255',
            'add_url' => 'required|url|max:255',
            'image' => 'required|image|mimes:png,jpeg,gif|max:1024'
        ]);

        $directory = 'assets/media/sliders/';
        $image = $request->file('image');
        $image_name = Str::slug($request->add_name) . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();

        $image->move($directory, $image_name);
        $image_name = $directory.$image_name;

        $data = SliderModel::create([
            "name" => $request->add_name,
            "url" => $request->add_url,
            "img" => $image_name,
        ]);

        return redirect()->back()->with($data ? "success" : "error", true);
    }

    public function sliderDelete($id) {
        $check = SliderModel::find($id);
        if ($check) {
            if (file_exists($check->img)) {
                unlink($check->img);
            }
            return redirect()->back()->with($check->delete() ? "success" : "error", true);
        }
        return redirect()->back()->with("error", true);
    }
}
