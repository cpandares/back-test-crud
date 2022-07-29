<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('api/students', [ StudentController::class, 'store' ]);
Route::post('api/students/{id}', [ StudentController::class, 'update' ]);
Route::get('api/students', [ StudentController::class, 'index' ]);
Route::get('api/students/{id}', [ StudentController::class, 'show' ]);
Route::delete('api/students/{id}', [ StudentController::class, 'delete' ]);
