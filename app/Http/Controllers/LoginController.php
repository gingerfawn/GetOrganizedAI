<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Profile;
use App\Models\Folders;
use App\Models\Notes;

class LoginController extends Controller
{
    public function login(Request $request){
       if(Auth::attempt($request->only('email', 'password'))){
        return redirect('/');
       } else {
        return view('login');
       }
    }

    public function loggedIn(){
        $user = Auth::user();
        if($user == null){
            return view('login');
        }
        $profiles = Profile::where('user_id', $user->id)->get();
        $current_profile = Profile::where('user_id', $user->id)->where('default', 'true')->first();

        //get the folders associated with the first profile
        $draft_folder = Folders::where('profile_id', $current_profile->id)->where('type', 'draft')->first();
        $media_folder = Folders::where('profile_id', $current_profile->id)->where('type', 'media')->first();
        $folders = Folders::where('profile_id', $current_profile->id)->where('type', 'user')->get();

        $folder_ids = [];
        foreach($folders as $folder){
            $folder_ids[] = $folder->id;
        }
        $folder_ids[] = $draft_folder->id;

        $notes = Notes::whereIn('folder_id', $folder_ids)->where('folder_id', $draft_folder->id)->get();

        return view('index')
            ->with('username', $user->name)
            ->with('profiles', $profiles)
            ->with('folders', $folders)
            ->with('draft_folder', $draft_folder)
            ->with('media_folder', $media_folder)
            ->with('notes', $notes)
            ->with('current_profile', $current_profile);
    }

}