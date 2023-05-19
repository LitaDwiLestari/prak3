<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;
use App\Models\Product;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/listproduct', function (Request $request) {
    $products = Product::all();
    return response()->json($products);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/listproduct', [ProductController::class, 'index']);
});
Route::get('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = $request->user();

        Sanctum::actingAs($user);

        return response()->json(['token' => $user->createToken('authToken')->plainTextToken]);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
});
