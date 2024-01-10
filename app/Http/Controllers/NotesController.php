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

        //ADDITIONAL FUNCTIONALITY
        $note_id = $request->query('note_id');
        $note = Notes::where('id', $note_id)->first();

        $chats = Chats::where('note_id', $note_id)->get();

        $history = [];
        for($i=0; $i < count($chats); $i++){
            if($i == 0 || $chats[$i]->is_AI_resp != $chats[$i-1]->is_AI_resp){
                $history[] = ['message' => $chats[$i]->chat, 'role' => $chats[$i]->is_AI_resp];
            };
        };

        return view('index')
            ->with('username', $user->name)
            ->with('profiles', $profiles)
            ->with('folders', $folders)
            ->with('draft_folder', $draft_folder)
            ->with('media_folder', $media_folder)
            ->with('notes', $notes)
            ->with('history', $history)
            ->with('current_note', $note)
            ->with('current_profile', $current_profile);
    }
}
