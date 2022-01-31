<?php

use App\Http\Controllers\AuthController\LoginController;
use App\Http\Controllers\Products\Product;
use App\Http\Controllers\Settings\Sliders;
use App\Http\Controllers\Products\Categories;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\Profile\General as ProfileGeneral;
use App\Http\Controllers\Users\General as UsersGeneral;
use App\Http\Controllers\Settings\General as SettingsGeneral;
use App\Http\Controllers\Customers\General as CustomersGeneral;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('isLogin')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'login_post'])->name('login_post');
});

Route::middleware('isLogout')->group(function () {
    Route::get("/", [GeneralController::class, "index"])->name("index");
    Route::get('/logout', [LoginController::class, 'logout'])->name("logout");

    // profile
    Route::get("/my-profile", [ProfileGeneral::class, "index"])->name("indexProfile");
    Route::post("/my-profile", [ProfileGeneral::class, "myProfileEdit"])->name("myProfileEdit");

    Route::get("/users/list", [UsersGeneral::class, "usersGet"])->name("usersGet");
    Route::post("/users/list/edit", [UsersGeneral::class, "userEdit"])->name("userEdit");
    Route::post("/user/view", [UsersGeneral::class, "getUser"]);
    Route::post("/users/list/add", [UsersGeneral::class, "userAdd"])->name("userAdd");

    /// Settings
    ///
    Route::get("/settings/general", [SettingsGeneral::class, "generalIndex"])->name("generalIndex");
    Route::post("/settings/general", [SettingsGeneral::class, "generalPost"])->name("generalPost");
    Route::post("/settings/general/logo", [SettingsGeneral::class, "logoChange"])->name("logoChange");

    Route::get("/settings/sliders", [Sliders::class, "SliderIndex"])->name("SliderIndex");
    Route::post("/settings/sliders", [Sliders::class, "SliderPost"])->name("SliderPost");
    Route::get("/settings/sliders/delete/{id}", [Sliders::class, "SliderDelete"])->name("SliderDelete");

    //Products
    Route::get("/products/category-list", [Categories::class, "CategoriesListIndex"])->name("CategoriesListIndex");
    Route::get("/products/category-add", [Categories::class, "CategoriesAddIndex"])->name("CategoriesAddIndex");
    Route::post("/products/category-add", [Categories::class, "CategoriesAddPost"])->name("CategoriesAddPost");
    Route::post("/products/category-view", [Categories::class, "CategoryGet"]);
    Route::post("/products/category-edit", [Categories::class, "CategoryEdit"])->name("editCategory");
    Route::get("/products/category-delete/{id}", [Categories::class, "delete"])->name("deleteCategory");

    Route::get("/products/product-list", [Product::class, "ProductsListIndex"])->name("ProductsListIndex");
    Route::get("/products/product-add", [Product::class, "ProductAddIndex"])->name("ProductAddIndex");
    Route::post("/products/product-add", [Product::class, "ProductAddPost"])->name("ProductAddPost");
    Route::post("/products/product-edit", [Product::class, "ProductEdit"])->name("productEdit");
    Route::post("/products/product-view", [Product::class, "ProductGet"]);
    Route::get("/products/product-delete/{id}", [Product::class, "ProductDelete"]);


    // Customers

    Route::get("/customers/list", [CustomersGeneral::class, "CustomersList"])->name("CustomersList");
    Route::post("/customer/view", [CustomersGeneral::class, "CustomersView"]);
});

