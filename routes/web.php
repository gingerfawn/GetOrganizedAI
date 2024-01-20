<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\APIController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\FoldersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MailController;


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
Route::any('/media-gallery', [MediaController::class, 'view']);

// Route::post('/songAPI', [APIController::class, 'show']);
// Route::get('/songAPI', function(){
//     return view('index');
// });

Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', [LoginController::class, 'getLogin']);

Route::post('/sign-up', [SignUpController::class, 'signUp']);
Route::get('/sign-up', function(){
    return view('signup');
});

// Route::any('/edit-note', [NotesController::class, 'editNote']);
// Route::any('/edit-note', [APIController::class, 'show']);


Route::post('/add-new-folder', [FoldersController::class, 'addNew']);
Route::post('/add-new-profile', [ProfileController::class, 'addNew']);

Route::post('/delete-note', [NotesController::class, 'deleteNote']);
Route::get('/delete-chat', [ChatsController::class, 'deleteChat']);

Route::post('/edit-delete-profiles-folders', [ProfileController::class, 'editDeleteProfilesFolders']);

Route::get('/privacy-policy', function(){
    return view('/privacy-policy');
});

Route::get('/terms-of-service', function(){
    return view('/terms-of-service');
});

Route::get('/forgot-password', function(){
    return view('/forgot-password');
});
Route::post('/reset-password-temp', [MailController::class, 'resetPassword']);
Route::post('/reset-password', [LoginController::class, 'resetPassword']);

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/reset-db', [AdminController::class, 'resetDatabase']);
