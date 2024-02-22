<?php
namespace App\Livewire;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\Notes;
use Illuminate\Http\Request;
use Livewire\Attributes\On; 


class SideNav extends Component
{

    public $profiles;
    public $selected_profile;
    public $current_profile;
    public $folders;
    public $notes;
    public $note_id;
    public $draft_folder;

    public function getNote($note_id){
        $this->dispatch('edit_note', $note_id);
    }

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
                $get_notes[] = $this->draft_folder->id;

            $this->notes = Notes::whereIn('folder_id', $get_notes)->get();
        } 

        $this->render();

    }

    #[On('refresh_sidenav')]
    public function refreshSideNav(){
        $this->render();
    }

    public function render()
    {   $folder_id_array = [];
        foreach($this->folders as $folder){
            $folder_id_array[] = $folder->id;
        };
        $folder_id_array[] = $this->draft_folder->id;
        $this->notes = Notes::whereIn('folder_id', $folder_id_array)->get();
        return view('livewire.side-nav')->with('folders', $this->folders)->with('notes', $this->notes);
    }
}
