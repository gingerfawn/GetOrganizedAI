<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profile;
use App\Models\Folders;
use App\Models\Notes;

class SignUpController extends Controller
{
    public function signUp(Request $request){
        //TODO: clean data, required fields
        //TODO: compare passwords
        //TODO: only create profile - notes if user is created

        $user = User::firstOrCreate(
            ['email' => $request->email],
            ['name' => $request->name, 
            'email' => $request->email, 
            'password' => Hash::make($request->password),
            'account_type' => 'free']
        );

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->name = 'Default Profile';
        $profile->AI_session = '';
        $profile->default = 'true';
        $profile->save();

        $folder = new Folders();
        $folder->profile_id = $profile->id;
        $folder->name = 'Default Folder';
        $folder->type = 'user';
        $folder->save();

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

        return redirect('/login');
    }

}