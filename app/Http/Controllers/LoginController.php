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
            return view('coming-soon');
        }
        $profiles = Profile::where('user_id', $user->id)->get();
        $current_profile = Profile::where('user_id', $user->id)->where('default', 'true')->first();

        $profile_ids = [];
        foreach($profiles as $profile){
            $profile_ids[] = $profile->id;
        }

        //Folder setup
        $folders = Folders::whereIn('profile_id', $profile_ids)->where('type', 'user')->get();
        $draft_folders = Folders::whereIn('profile_id', $profile_ids)->where('type', 'draft')->get();
        $media_folder = Folders::whereIn('profile_id', $profile_ids)->where('type', 'media')->get();  

        $folder_ids = [];
        foreach($folders as $folder){
            $folder_ids[] = $folder->id;
        }

        foreach($draft_folders as $folder){
            $folder_ids[] = $folder->id;
        }

        $notes = Notes::whereIn('folder_id', $folder_ids)->get();

        return view('index')
            ->with('username', $user->name)
            ->with('profiles', $profiles)
            ->with('folders', $folders)
            ->with('media_folder', $media_folder)
            ->with('notes', $notes)
            ->with('current_profile', $current_profile)
            ->with('draft_folders', $draft_folders);
    }

}