<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
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

/*
Route::get('/hello', function () {
    return response("<h1>Hello World</h1>")
            ->header('Content-Type', 'text/plain');
});

Route::get('/posts/{id}', function ($id) {
    // dd($id); // Dump-Die helper - use for debugging
    // ddd($id); // Dump-Die-Debug
    return response('Post' . $id);
})->where('id', '[0-9]+');

Route::get('/search', function (Request $request) {
    // Given /search?name=Bora&city=PhnomPenh
    return $request->name . ' ' . $request->city;
});
*/

/*
// Common Resource Routes:
-> index - Show all listings
-> show - Show single listing
-> create - show form to create new list
-> store - store new listing
-> edit - show form to edit list
-> update - update listing
-> destroy - delete listing
*/


// All Listings
Route::get('/', [ListingController::class, "index"]);

// Show Create Form
Route::get('/listings/create', [ListingController::class, "create"])->middleware("auth");

// Store Listing Data
Route::post('/listings', [ListingController::class, "store"])->middleware("auth");;

// Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, "edit"])->middleware("auth"); ;

// Update Listing
Route::put('/listings/{listing}', [ListingController::class, "update"])->middleware("auth");;

// Delete listing
Route::delete('/listings/{listing}', [ListingController::class, "destroy"])->middleware("auth");;

// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// Single Listing
Route::get('/listings/{listing}', [ListingController::class, "show"]);


// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create New Users
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout']);

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest'); // setting name for this route

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

?>