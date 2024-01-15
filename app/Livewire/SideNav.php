<?php
namespace App\Livewire;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\Notes;
use Illuminate\Http\Request;


class SideNav extends Component
{

    public $profiles;
    public $selected_profile;
    public $current_profile;
    public $folders;
    public $notes;
    public $note_id;
    public $draft_folders;

    public function moveNote($note, $folder, $queryString){

        if($note != null && $folder != null){
            $note = Notes::find($note);
            $note->folder_id = $folder;
            $note->save();

            //switch chats?

            $get_notes = [];
            foreach($this->folders as $folder){
                $get_notes[] = $folder->id;
            }
            foreach($this->draft_folders as $folder){
                $get_notes[] = $folder->id;
            }

            $this->notes = Notes::whereIn('folder_id', $get_notes)->get();
            $this->redirect('/?'.$queryString);

        } 

        $this->render();
    }

    public function render()
    {
        return view('livewire.side-nav')->with('folders', $this->folders)->with('notes', $this->notes);
    }
}
