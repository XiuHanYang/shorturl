<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Middleware\CheckNameOnly;
use App\Http\Middleware\CheckUrlRegex;

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

Route::resources(['urls'    =>  UrlController::class]);

Route::post('urls', [UrlController::class, 'store'])
    ->middleware([CheckUrlRegex::class, CheckNameOnly::class]);

Route::get('/{randomParam}', [UrlController::class, 'redirect']);
