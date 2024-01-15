<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folders;


class FoldersController extends Controller
{
    public function addNew(Request $request){

        if(trim($request->folder_name) != ''){
            $folder = new Folders();
            $folder->profile_id = $request->profile_id;
            $folder->name = ucwords($request->folder_name);
            $folder->type = 'user';
            $folder->save();
        }

        return back();
    }
}
