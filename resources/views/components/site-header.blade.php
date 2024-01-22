<div class="site-header">
         <div class="site-header-note">
         @if($current_note != '')@livewire('edit-note-name', ['current_note_id' => $current_note->id, 'current_note_name' => $current_note->name])@endif
         </div>
</div>