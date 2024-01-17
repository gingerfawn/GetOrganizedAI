<div class="sideNavContainer">
    @livewire('switch-profiles', ['profiles' => $profiles, 'current_profile' => $current_profile])
    @livewire('side-nav', ['profiles' => $profiles, 
                            'current_profile' => $current_profile, 
                            'folders' => $folders,
                            'notes' => $notes,
                            'draft_folders' => $draft_folders])
    @include('components.side-nav-add-new')
</div>

