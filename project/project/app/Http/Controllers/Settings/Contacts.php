<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class Contacts extends Controller
{
    public function contactsIndex() {
        $data = Settings::all();
        View::share("data", $data);

        return view('settings.contacts');
    }

    public function contactsPost(Request $request) {
        $request->validate([
            'email' => 'required|max:100',
            'phone1' => 'required|max:50',
            'phone2' => 'required|max:50',
            'address' => 'required|max:500'
        ]);

        $data = Settings::find(1);
        $data->email = $request->email;
        $data->phone1 = $request->phone1;
        $data->phone2 = $request->phone2;
        $data->address = $request->address;

        return redirect()->back()->with($data->save() ? "success" : "error", true);
    }
}
