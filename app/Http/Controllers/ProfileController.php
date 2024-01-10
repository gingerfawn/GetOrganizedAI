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
        // if(trim($request->profile_name) != '' && !isnull($request->profile_name)){
        //     Profile::create();
        //     $profile->name = $request->profile_name;

        // }
       return back();
    }
}
