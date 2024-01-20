<div class="site-header">
         <h1>Get<br/> Organized<br/> AI </h1>
         <div class="site-header-note">
         @if($current_note != '')@livewire('edit-note-name', ['current_note_id' => $current_note->id, 'current_note_name' => $current_note->name])@endif
         </div>

        {{-- Extra divs for justify content flex alignment --}}
         {{-- <nav>
        <a href="/media-gallery">Media and File Gallery</a>
        <a href="/integrations">Integrations</a>
        <a href="/contact-us">Contact Us</a>
    </nav> --}}
</div>