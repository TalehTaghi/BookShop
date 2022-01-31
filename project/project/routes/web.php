<?php

use App\Http\Controllers\Products\Categories;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\AuthController\LoginController;
use App\Http\Controllers\Profile\General as ProfileGeneral;
use App\Http\Controllers\Users\General as UsersGeneral;
use App\Http\Controllers\Settings\General as SettingsGeneral;
use App\Http\Controllers\Settings\Contacts as SettingsContacts;
use App\Http\Controllers\Settings\Social as SettingsSocial;
use App\Http\Controllers\Settings\Sliders as SettingsSlider;
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
    Route::get('/', [GeneralController::class, "index"])->name("index");
    Route::get('/logout', [LoginController::class, 'logout'])->name("logout");

    // profile
    Route::get("/my-profile", [ProfileGeneral::class, "index"])->name("indexProfile");
    Route::post('/my-profile', [ProfileGeneral::class, "myProfileEdit"])->name("myProfileEdit");

    Route::get("/users/list", [UsersGeneral::class, "usersGet"])->name("usersGet");
    Route::post("/users/list", [UsersGeneral::class, "userEdit"])->name("userEdit");
    Route::post("/user/view", [UsersGeneral::class, "getUser"]);
    Route::post("/users/list/add", [UsersGeneral::class, "userAdd"])->name("userAdd");

    /// Settings
    /// General
    Route::get("/settings/general", [SettingsGeneral::class, "generalIndex"])->name("generalIndex");
    Route::post("/settings/general", [SettingsGeneral::class, "generalPost"])->name("generalPost");
    Route::post("/settings/general/logo", [SettingsGeneral::class, "logoChange"])->name("logoChange");
    ///Contacts
    Route::get("/settings/contacts", [SettingsContacts::class, "contactsIndex"])->name("contactsIndex");
    Route::post("/settings/contacts", [SettingsContacts::class, "contactsPost"])->name("contactsPost");
    ///Social
    Route::get("/settings/social", [SettingsSocial::class, "socialIndex"])->name("socialIndex");
    Route::post("/settings/social", [SettingsSocial::class, "socialPost"])->name("socialPost");
    ///Sliders
    Route::get("/settings/slider", [SettingsSlider::class, "sliderIndex"])->name("sliderIndex");
    Route::post("/settings/slider", [SettingsSlider::class, "sliderPost"])->name("sliderPost");
    Route::post("/settings/slider/view", [SettingsSlider::class, "getSlider"]);
    Route::post("/settings/slider/edit", [SettingsSlider::class, "sliderEdit"])->name("sliderEdit");
    Route::get("/settings/slider/delete/{id}", [SettingsSlider::class, "sliderDelete"])->name("sliderDelete");

    /// Customers
    Route::get("/customers/list", [CustomersGeneral::class, "customersList"])->name("customersList");
    Route::post("/customer/view", [CustomersGeneral::class, "customerView"])->name("customerView");
    Route::post("/customer/edit", [CustomersGeneral::class, "customerEdit"])->name("customerEdit");

    /// Products
    Route::get("/products/category-list", [Categories::class, "categoriesListIndex"])->name("categoriesListIndex");
    Route::get("/products/category-add", [Categories::class, "categoriesAddIndex"])->name("categoriesAddIndex");
    Route::post("/products/category-add", [Categories::class, "categoriesAddPost"])->name("categoriesAddPost");
    Route::post("/products/category-view", [Categories::class, "categoriesView"]);
    Route::post("/products/category-edit", [Categories::class, "categoryEdit"])->name("categoryEdit");
});
