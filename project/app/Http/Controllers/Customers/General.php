<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class General extends Controller
{
    public function CustomersList()
    {
        $all_data = Customers::all();
        View::share("customers", $all_data);
        return view('customers.list');
    }

    public static function UserGet($id)
    {
        $data = User::find($id);
        return $data ?? null;
    }

    public function CustomersView(Request $request)
    {
        $data = Customers::find($request->id);
        if ($data) {
            $user = User::find($data->user_id);
            if ($user) {
                return response()->json([
                    'customer' => $data,
                    'user' => $user,
                    'status' => true,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                ]);
            }

        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }
}
