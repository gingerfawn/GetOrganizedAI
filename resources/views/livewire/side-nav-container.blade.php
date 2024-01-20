<div>
    <div x-data="{ open: window.innerWidth > 768 }">
        <button type="button" @click="open = !open">Toggle Menu</button>
            <div wire:init="initialize" x-show="open" x-cloak>
                <div class="sideNavContainer">
                    @livewire('switch-profiles', ['profiles' => $profiles, 'current_profile' => $current_profile])
                    @livewire('side-nav', ['profiles' => $profiles, 
                                            'current_profile' => $current_profile, 
                                            'folders' => $folders,
                                            'notes' => $notes,
                                            'draft_folder' => $draft_folder])
                    @include('components.side-nav-add-new')
                </div>
            </div>
        </div>
</div>
