<?php
namespace App\Livewire;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use App\Models\Profile;

class SideNav extends Component
{

    public $profiles;
    public $selected_profile;
    public $current_profile;

    public function updateSelectedProfile($selected_profile)
    {
        
        $this->selected_profile = $selected_profile;
        $profile_ids = [];
        foreach($this->profiles as $profile){
            $profile_ids[] = $profile->id;
        }

        Profile::whereIn('id', $profile_ids)->update(['default' => 'false']);
        Profile::where('id', $selected_profile)->update(['default' => 'true']);

        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.side-nav');
    }
}
