<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Controllers\NotesController;
use App\Models\Notes;
use App\Models\Chats;



class ChatsController extends Controller
{   
    public function deleteChat( Request $request ){

        $delete_chat = $request->chat_id;
        //get note_id from chat
        $note_id = Chats::where('id', $delete_chat)->first();
        $note_id = $note_id->note_id;

        //get all chats by note_id
        $all_chats = Chats::where('note_id', $note_id)->get();
        $all_chats_array = $all_chats->toArray();
        for($i = 0; $i < count($all_chats); $i++ ){
            if($all_chats[$i]->id == $delete_chat){
                $chat_1 = $all_chats[$i]->id;
                $chat_2 = $all_chats[$i+1]->id;
                Chats::whereIn('id', [$chat_1, $chat_2])->delete();
            }
        }
        return redirect('/?note='.$note_id);
    }
}
