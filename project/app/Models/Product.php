<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $guarded = [];

    public function CategoryGet($id) {
        $data = Categories::find($id);

        if ($data) {
            return $data->name;
        }
        return null;
    }
}
