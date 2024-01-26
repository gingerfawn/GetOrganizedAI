<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Profile;
use App\Models\Folders;
use App\Models\Notes;
use App\Models\Chats;
use App\Models\Subscription;

class AdminController extends Controller
{
    public function resetDatabase(){
        Subscription::truncate();
        // User::truncate();
        Profile::truncate();
        Folders::truncate();
        Notes::truncate();
        Chats::truncate();
        return back();
    }
}