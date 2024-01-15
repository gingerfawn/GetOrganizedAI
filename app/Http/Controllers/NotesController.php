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

    public function editNote(Request $request){
        //PAGE SETUP
        $user = Auth::user();
        if($user == null){
            return view('login');
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

        //ADDITIONAL FUNCTIONALITY
        $note_id = $request->query('note_id');
        $note = Notes::where('id', $note_id)->first();

        $history = Chats::where('note_id', $note_id)->orderBy('created_at', 'desc')->get();

        return view('index')
            ->with('username', $user->name)
            ->with('profiles', $profiles)
            ->with('folders', $folders)
            ->with('draft_folders', $draft_folders)
            ->with('media_folder', $media_folder)
            ->with('notes', $notes)
            ->with('history', $history)
            ->with('current_note', $note)
            ->with('current_profile', $current_profile);
    }
}
