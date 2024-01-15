<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Profile;
use App\Models\Folders;
use App\Models\Notes;
use App\Models\Chats;

class NotesController extends Controller
{
    public function addNew(Request $request){

        return back();
    }
}
