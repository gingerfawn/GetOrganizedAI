<div>
    <div x-data="{ open: window.innerWidth > 768 }">
        <div class="side-nav-control">
            <button type="button" @click="open = !open">
                <span>{{ svg('heroicon-o-chevron-double-left') }}</span>
            </button>
            <span x-show="open" x-cloak>
                @livewire('switch-profiles', ['profiles' => $profiles, 'current_profile' => $current_profile])
            </span>
        </div>

            <div wire:init="initialize" x-show="open" x-cloak>
                <div class="sideNavContainer">
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
