<?php

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\Admin\AdminController;
use function PHPUnit\Framework\callback;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// WEB ROUTE
Route::controller(WebController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/categories', 'categories')->name('categories');
    Route::post('/getCategorydata', 'getCategorydata');
    Route::post('/getSliderdata', 'getSliderdata');
    Route::post('/getAllPersondata', 'getAllPersondata');
    Route::post('/getRecentlyAddPersondata', 'getRecentlyAddPersondata');
    Route::post('/getTrendingPersondata', 'getTrendingPersondata');
    Route::post('/getTopViewPersondata', 'getTopViewPersondata');
    Route::post('/getCategoryByAnyPersondata', 'getCategoryByAnyPersondata');
    Route::get('/CategoryByPersonData/{id}', 'CategoryByPersonData');
    Route::get('/person_details/{id}', 'person_details');
    Route::get('/contacts', 'contacts')->name('contacts');
    Route::get('/login', 'login')->name('login');
    Route::post('/sendcomment', 'sendcomment');
    Route::post('/getComment', 'getComment');
    // Route::post('/sendMessage', 'sendMessage');
    // Route::get('/blog', 'blog')->name('blog');
    Route::post('/searchPerson', 'searchPerson');

    Route::get('/login/google', 'loginGoogle');
    Route::get('/login/google/callback', 'callback');
});

// ADMIN ROUTE
Route::controller(AuthController::class)->group(function () {
    Route::get('/admin', 'login');
    Route::get('/admin/login', 'login')->name('login');
    Route::post('/admin/login', 'login_data');
    Route::get('/change_password_form', 'change_password_form')->name('change_password_form');
    Route::post('change_password', 'change_password');
    Route::get('/logout', 'logout');
});

// Auth::routes();
Route::middleware([Authenticate::class])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        // Home
        Route::get('/admin/dashboard', 'dashboard')->name('dashboard');

        // Slider
        Route::get('/admin/slider_list', 'slider_list')->name('slider_list');
        Route::post('/admin/add_edit_slider', 'add_edit_slider');
        Route::post('/admin/GetSliderData', 'GetSliderData');
        Route::post('/admin/deleteSlider', 'deleteSlider');

        // Category
        Route::get('/admin/category_list', 'category_list')->name('category_list');
        Route::post('/admin/add_edit_category', 'add_edit_category');
        Route::post('/admin/GetCategoryData', 'GetCategoryData');
        Route::post('/admin/deleteCategory', 'deleteCategory');
        Route::post('/admin/get_category', 'get_category');

        // Person
        Route::get('/admin/person_list', 'person_list')->name('person_list');
        Route::post('/admin/add_edit_person', 'add_edit_person');
        Route::post('/admin/GetPersonData', 'GetPersonData');
        Route::post('/admin/deletePerson', 'deletePerson');
        Route::get('/admin/person_profile_view/{id}', 'person_profile_view')->name('person_profile_view');
        Route::post('/admin/get_person', 'get_person');

        // Person Images
        Route::get('/admin/images_list', 'images_list')->name('images_list');
        Route::post('/admin/add_edit_images', 'add_edit_images');
        Route::post('/admin/GetImagesData', 'GetImagesData');
        Route::post('/admin/deleteImages', 'deleteImages');
    });
});
