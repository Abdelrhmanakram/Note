<?php

// use auth;
use App\Http\Controllers\ApiNoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(ApiAuthController::class)->group(function(){
    Route::post("register","register");
    Route::post("login","login");
    Route::post("logout","logout")->middleware('api_auth');

});


Route::controller(ApiNoteController::class)->group(function(){
Route::middleware('api_auth')->group(function(){


    Route::get("notes","allNotes");       // Show All Notes

    Route::get("notes/{id}","showOne");     // Show One Note By ID

    Route::post("notes","store");         // Create New Note

    Route::put("notes/{id}","update");    // Update  Note

    Route::delete("notes/{id}","delete");    // Delete  Note

});
});
