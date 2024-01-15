<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\FoldersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

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

// Route::get('/', [LoginController::class, 'loggedIn']);

Route::any('/', [APIController::class, 'show']);

// Route::post('/songAPI', [APIController::class, 'show']);
// Route::get('/songAPI', function(){
//     return view('index');
// });

Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', function(){
    return view('login');
});

Route::post('/sign-up', [SignUpController::class, 'signUp']);
Route::get('/sign-up', function(){
    return view('signup');
});

// Route::any('/edit-note', [NotesController::class, 'editNote']);
// Route::any('/edit-note', [APIController::class, 'show']);


Route::post('/add-new-folder', [FoldersController::class, 'addNew']);
Route::post('/add-new-profile', [ProfileController::class, 'addNew']);

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/reset-db', [AdminController::class, 'resetDatabase']);
