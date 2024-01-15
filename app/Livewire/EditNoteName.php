<?php

namespace App\Livewire;

use Livewire\Component;

class EditNoteName extends Component
{
    public $current_note_id;
    public $current_note_name;

    public function render()
    {
        $this->current_note_id;
        $this->current_note_name;
        return view('livewire.edit-note-name');
    }
}
