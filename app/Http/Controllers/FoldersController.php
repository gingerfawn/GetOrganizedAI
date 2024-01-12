<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folders;


class FoldersController extends Controller
{
    public function addNew(Request $request){
        $folder = new Folders();
        $folder->profile_id = $request->profile_id;
        $folder->name = $request->folder_name;
        $folder->type = 'user';
        $folder->save();

        return back();
    }
}
