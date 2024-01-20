<?php

namespace App\Livewire;

use Livewire\Component;

class SideNavContainer extends Component
{

    public $profiles;
    public $selected_profile;
    public $current_profile;
    public $folders;
    public $notes;
    public $note_id;
    public $draft_folder;
    public $collapsed;
    public $screenSize;

    public function initialize(){
            $this->collapsed = false;
    }

    public function mount()
    {
        $this->dispatch('getWindowWidth');
    }


    public function toggle(){

        $this->collapsed = !$this->collapsed;
    }

    public function render()
    {
        return view('livewire.side-nav-container')->with('profiles', $this->profiles);
    }
}
