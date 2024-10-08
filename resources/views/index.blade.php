@include('components.header')
@include('components.navbar')

<div class="container">
    <div class="main-layout">
    @auth
    <div id="sideNav">
        @livewire('side-nav-container', ['profiles' => $profiles, 
        'current_profile' => $current_profile, 
        'folders' => $folders,
        'notes' => $notes,
        'draft_folder' => $draft_folder])
    </div>

    <div id="main">      
        {{-- @include('components.ai-form') --}}
        <div>
        <livewire:chat-module :current_profile="$current_profile" :draft_folder="$draft_folder" />
        </div>
    </div>

    @endauth
</div>
</div>
@include('components.footer')
@include('popups.container')