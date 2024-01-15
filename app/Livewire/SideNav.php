<?php
namespace App\Livewire;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\Notes;


class SideNav extends Component
{

    public $profiles;
    public $selected_profile;
    public $current_profile;
    public $folders;
    public $notes;
    public $note_id;
    public $draft_folders;

    public function moveNote($note, $folder){

        $note = Notes::find($note);
        $note->folder_id = $folder;
        $note->save();
    }

    public function render()
    {
        return view('livewire.side-nav')->with('folders', $this->folders)->with('notes', $this->notes);
    }
}
