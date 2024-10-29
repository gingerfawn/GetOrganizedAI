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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Routing\Middleware\Unsubscribed;


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

Route::any('/', [APIController::class, 'show'])->name('index');
Route::any('/media-gallery', [MediaController::class, 'view']);

// Route::post('/songAPI', [APIController::class, 'show']);
// Route::get('/songAPI', function(){
//     return view('index');
// });

Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', [LoginController::class, 'getLogin']);


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
    return view('terms-and-conditions');
});

Route::get('/forgot-password', function(){
    return view('forgot-password');
});
Route::post('/reset-password-temp', [MailController::class, 'resetPassword']);
Route::post('/reset-password', [LoginController::class, 'resetPassword']);

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/mobile', function(){
    return view('mobile-delete-later');
});

Route::get('/reset-db', [AdminController::class, 'resetDatabase']);

Route::post('/payments/pay', [PaymentController::class, 'pay'])->name('pay');
Route::get('/payments/approval', [PaymentController::class, 'approval'])->name('approval');
Route::get('/payments/cancelled', [PaymentController::class, 'cancelled'])->name('cancelled');

Route::prefix('subscribe')
    ->name('subscribe.')
    ->group(function(){
        Route::get('/', [SubscriptionController::class, 'show'])
            ->name('show');
        Route::post('/', [SubscriptionController::class, 'store'])
            ->name('store');
        Route::get('/approval', [SubscriptionController::class, 'approval'])
            ->name('approval');
        Route::get('/cancelled', [SubscriptionController::class, 'cancelled'])
            ->name('cancelled');
    });

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
