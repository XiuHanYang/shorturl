<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NamespaceController;
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

Route::resource('urls', UrlController::class)->only([
    'store', 'destroy', 'show'
]);

Route::resource('members', MemberController::class)->only([
    'store', 'destroy', 'show'
]);

Route::resource('namespaces', NamespaceController::class)->only([
    'store', 'destroy', 'show'
]);

Route::post('urls', [UrlController::class, 'store'])
    ->middleware([CheckUrlRegex::class, CheckNameOnly::class]);

Route::get('/{memberName}/{namespaceName}/{randomParam}', [UrlController::class, 'redirect']);
