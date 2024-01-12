<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Folders;

class ProfileController extends Controller
{
    public function addNew(Request $request){
        //create draft folder and media folder for each profile
        $user = Auth::user();
        if(trim($request->profile_name) != '' && !is_null($request->profile_name)){
            $profile = new Profile();
            $profile->name = $request->profile_name;
            $profile->user_id = $user->id;
            $profile->AI_session = '';
            $profile->save();

            $folder = new Folders();
            $folder->profile_id = $profile->id;
            $folder->name = 'Draft Folder';
            $folder->type = 'draft';
            $folder->save();
    
            $folder = new Folders();
            $folder->profile_id = $profile->id;
            $folder->name = 'Media Folder';
            $folder->type = 'media';
            $folder->save();
        }
    
       return back();
    }
}
