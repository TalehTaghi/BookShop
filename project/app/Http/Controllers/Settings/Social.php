<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class Social extends Controller
{
    public function socialIndex() {
        $data = Settings::all();
        View::share("data", $data);

        return view('settings.social');
    }

    public function socialPost(Request $request) {
        $request->validate([
            'facebook' => 'required|max:255',
            'instagram' => 'required|max:255',
        ]);

        $data = Settings::find(1);
        $data->facebook = $request->facebook;
        $data->instagram = $request->instagram;

        return redirect()->back()->with($data->save() ? "success" : "error", true);
    }
}
