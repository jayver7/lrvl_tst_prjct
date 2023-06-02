<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Create IPCR Form
Route::resource('/employee', App\Http\Controllers\IPCRController::class);
Route::post("/deleteform/{id}", [App\Http\Controllers\IPCRController::class, "DeleteForm"])->name("DeleteForm");

//print
Route::post("/printform/{id}", [App\Http\Controllers\PDFController::class, "printform"])->name("printform");

// Set Schedule Form
Route::resource('/hr', App\Http\Controllers\ScheduleController::class);

Route::resource("/test", App\Http\Controllers\TestController::class);

Auth::routes();
