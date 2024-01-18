<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Folders;
use App\Models\Notes;
use App\Models\Chats;

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
            $folder->name = 'Media Folder';
            $folder->type = 'media';
            $folder->save();
        }
    
       return back();
    }

    function editDeleteProfilesFolders(Request $request){
        $editProfileArray = [];
        $deleteProfileArray = [];
        $editFolderArray = [];
        $deleteFolderArray = [];
        foreach($request->all() as $key => $params){
            if($params != null && $key != '_token'){
                if(str_contains($key, 'delete-profile-')){
                    $key = str_replace('delete-profile-', '', $key);
                    $deleteProfileArray[] = $key;
                }
                if(str_contains($key, 'delete-folder-')){
                    $key = str_replace('delete-folder-', '', $key);
                    $deleteFolderArray[] = $key;
                }
                if(str_contains($key, 'edit-profile-') && trim($params) != ''){
                    $key = str_replace('edit-profile-', '', $key);
                    $editProfileArray[$key] = ucwords($params);
                }
                if(str_contains($key, 'edit-folder-') && trim($params) != ''){
                    $key = str_replace('edit-folder-', '', $key);
                    $editFolderArray[$key] = ucwords($params);
                }

            }
        }

        foreach($editFolderArray as $key => $editFolder){
            $folder = Folders::find($key);
            $folder->name = trim($editFolder);
            $folder->save();
        }

        foreach($editProfileArray as $key => $editProfile){
            $profile = Profile::find($key);
            $profile->name = trim($editProfile);
            $profile->save();
        }

        foreach($deleteFolderArray as $deleteFolder){
            $folder = Folders::find($deleteFolder);
            $notes = Notes::where('folder_id', $folder->id)->get();

            $notesArray = [];
            foreach($notes as $note){
                $notesArray[] = $note->id;
            }

            Chats::whereIn('note_id', $notesArray)->delete();
            Notes::whereIn('id', $notesArray)->delete();
            Folders::where('id', $folder->id)->delete();
        }

        foreach($deleteProfileArray as $deleteProfile){
            $profile = Profile::find($deleteProfile);

            $folders = Folders::where('profile_id', $deleteProfile)->get();
            $foldersArray = [];
            foreach($folders as $folder){
                $foldersArray[] = $folder->id;
            }

            $notes = Notes::whereIn('folder_id', $foldersArray)->get();
            $notesArray = [];
            foreach($notes as $note){
                $notesArray[] = $note->id;
            }

            Chats::whereIn('note_id', $notesArray)->delete();
            Notes::whereIn('folder_id', $foldersArray)->delete();
            Folders::where('profile_id', $deleteProfile)->delete();
            Profile::where('id', $deleteProfile)->delete();
        }
        
        return redirect('/');
    }
}
