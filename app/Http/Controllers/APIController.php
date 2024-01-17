<?php

namespace App\Http\Controllers;

use GeminiAPI\Laravel\Facades\Gemini;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Carbon\Carbon;
use Auth;

use App\Models\User;
use App\Models\Profile;
use App\Models\Folders;
use App\Models\Notes;
use App\Models\Chats;


class APIController extends Controller
{   //TODO: create default profile option

    public function show(Request $request){

        //View dependencies
        $user = Auth::user();

        if($user == null){
            return view('coming-soon');
        }

        $profiles = Profile::where('user_id', $user->id)->get();
        $current_profile = Profile::where('user_id', $user->id)->where('default', 'true')->first();
        $draft_folder = Folders::where('profile_id', $current_profile->id)->where('type', 'draft')->first();

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

        //Notes setup
        $notes = Notes::whereIn('folder_id', $folder_ids)->get();
        $notes_ids = [];
        foreach($notes as $note){
            $notes_ids[] = $note->id;
        }


        //IF NOTE EXISTS ELSE CREATE NOTE
        if(isset($request->note) && trim($request->note != '')){
            $current_note = Notes::where('id', $request->note)->first();
            if($request->exists('note_name') && trim($request->note_name) != ''){
                $current_note->name = ucwords($request->note_name);
                $current_note->save();
            }
        } else {
            if($request->exists('chat') && trim($request->chat) != ''){
                $current_note = new Notes();
                $current_note->folder_id = $draft_folder->id;
                $current_note->name = Carbon::now()->format('l, M d');
                $current_note->save();
            }
        }

        //Start chat functionality
        if($request->exists('chat') && trim($request->chat) != ''){

        $gemini_response = Gemini::generateText($request->chat);
        $chats = Chats::where('note_id', $current_note->id)->get();

        $history = [];
        for($i=0; $i < count($chats); $i++){
            if($i == 0 || $chats[$i]->is_AI_resp != $chats[$i-1]->is_AI_resp){
                $history[] = ['message' => $chats[$i]->chat, 'role' => $chats[$i]->is_AI_resp];
            };
        };

        $chat= Gemini::startChat($history);

        $gemini_response = $chat->sendMessage($request->chat . 'Please limit response to 300 words. Please do not include any special characters');
        $gemini_response = Str::markdown($gemini_response);
        //CREATE CHAT
        //TODO: fix profile and folders! 
        $current_chat = new Chats();
        $current_chat->chat = $request->chat;
        $current_chat->note_id = $current_note->id;
        $current_chat->order = time();
        $current_chat->user_id = $user->id;
        $current_chat->profile_id = $current_profile->id;
        $current_chat->folder_id = $draft_folder->id;
        $current_chat->is_AI_resp = 'user';
        $current_chat->attachment_type = '';
        $current_chat->filepath = '';
        $current_chat->name = '';
        $current_chat->save();

        $response_chat = new Chats();
        $response_chat->chat = $gemini_response;
        $response_chat->note_id = $current_note->id;
        $response_chat->order = time();
        $response_chat->user_id = $user->id;
        $response_chat->profile_id = $current_profile->id;
        $response_chat->folder_id = $draft_folder->id;
        $response_chat->is_AI_resp = 'model';
        $response_chat->attachment_type = '';
        $response_chat->filepath = '';
        $response_chat->name = '';
        $response_chat->save();
        }

        $notes = Notes::whereIn('folder_id', $folder_ids)->get();
        $history = '';
        if(isset($current_note)){
            $history = Chats::where('note_id', $current_note->id)->orderBy('created_at', 'desc')->get();
        } else {
            $current_note = '';
        }

        return view('index')
            ->with('username', $user->name)
            ->with('profiles', $profiles)
            ->with('folders', $folders)
            ->with('media_folder', $media_folder)
            ->with('draft_folders', $draft_folders)
            ->with('notes', $notes)
            ->with('chat', $request->chat)
            ->with('history', $history)
            ->with('current_note', $current_note)
            ->with('current_profile', $current_profile);
    }
}
