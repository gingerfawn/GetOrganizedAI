<div>
<div>
    @isset($current_profile)
    @isset($folders)
        @foreach($folders as $folder)
        @if($folder->profile_id == $current_profile->id)
        <div folder_id="{{$folder->id}}"  drag-folder draggable="true" wire:key="folder-{{ $folder->id }}" class="side-nav-folder">
            <div class="folder-name">{{ svg('fas-folder') }}{{$folder->name}}</div>
            @isset($notes)
                @foreach($notes as $note)
                    @if($note->folder_id == $folder->id)
                    <div drag-note draggable="true" wire:key="note-{{ $note->id }}" drag-item="{{ $note->id }}">
                        <a href="/?note={{ $note->id }}">{{$note->name}}</a> 
                    </div>
                    @endif
                @endforeach
            @endisset
        </div>
        @endif
        @endforeach

        @foreach($draft_folders as $folder)
        @if($folder->profile_id == $current_profile->id)
            <div folder_id="{{$folder->id}}" drag-folder draggable="true" wire:key="folder-{{ $folder->id }}" class="side-nav-folder">
                <div class="folder-name">{{ svg('fas-folder') }} {{$folder->name}}</div>
                @isset($notes)
                @foreach($notes as $note)
                    @if($note->folder_id == $folder->id)
                    <div drag-note draggable="true" wire:key="note-{{ $note->id }}" drag-item="{{ $note->id }}">
                        <a href="/?note={{ $note->id }}">{{$note->name}}</a> 
                    </div>
                    @endif
                @endforeach
                @endisset
            </div>
        @endif
        @endforeach
    @endisset
    @endisset
    </div>
    <script>
        window.onload = setUpDragNDrop();

        window.onload = (function(){
            Livewire.on('moveNoteExecuted', function(){
                setUpDragNDrop();
            });

        })
        
        function setUpDragNDrop (){
            console.log('executed');
        let dragFolders = document.querySelectorAll('[drag-folder]');
        dragFolders.forEach(dragFolder => {
            // console.log('dragFolders', dragFolder)
            dragFolder.addEventListener('drop', e => {
                // let draggingEl = document.querySelector('[dragging]').getAttribute('drag-item');
                e.preventDefault();
                var note_id = e.dataTransfer.getData('note_id');
                console.log('drop', e.dataTransfer);
                let folder = '';
                if(e.target.hasAttribute('folder_id')){
                    console.log('has', e.target.getAttribute('folder_id'));
                    folder = e.target.getAttribute('folder_id'); 
                } else {
                    console.log('closest', e.target.closest('[folder_id]').getAttribute('folder_id'));
                    folder = e.target.closest('[folder_id]').getAttribute('folder_id');
                }
                // let folder = e.target.closest('[folder_id]').getAttribute('folder_id');
                let component = Livewire.find(e.target.closest('[wire\\:id]').getAttribute('wire:id'));
                let params = (new URL(document.location)).searchParams.toString();
                console.log('params', params);
                component.call('moveNote', note_id, folder, params);
                e.dataTransfer.clearData();
            });
            dragFolder.addEventListener('dragstart', e => {
                // console.log(e.target)
            });
            dragFolder.addEventListener('dragenter', e => {
                e.target.classList.add('bg-yellow-100');

                e.preventDefault();
                // console.log(e.target)
            });
            dragFolder.addEventListener('dragover', e => {
                e.preventDefault();
            });
            dragFolder.addEventListener('dragleave', e => {
                e.target.classList.remove('bg-yellow-100');

                // console.log(e.target)
            });
            dragFolder.addEventListener('dragend', e => {
                // console.log(e.target)
            })
    
            dragFolder.querySelectorAll('[drag-note]').forEach(dragNote => {
                // console.log(dragNote);
                dragNote.addEventListener('dragstart', e => {
                    // e.target.setAttribute('dragging', true);
                    $note_id = e.target.closest('[drag-item]').getAttribute('drag-item');
                    e.dataTransfer.setData("note_id", $note_id);
                })
    
                dragNote.addEventListener('drop', e => {
                    e.target.classList.remove('bg-yellow-100');
    
                    //get the note just getting one folder, could cause issues
                    let draggingEl = dragFolder.querySelector('[dragging]');
                    //insert into folder
                    //add possible conditions for dragging up and dragging down
                    e.target.before(draggingEl);
                    // let component = Livewire.find(e.target.closest('[wire\\:id]').getAttribute('wire:id'));
                    // component.call('moveNote', e.target, dragFolder);
    
                })
                dragNote.addEventListener('dragenter', e => {
                    e.target.classList.add('bg-yellow-100');
                    // console.log(e.target);
                    e.preventDefault();
                })
    
                dragNote.addEventListener('dragover', e => {
                    // console.log('over');
                    e.preventDefault();
                })
    
                dragNote.addEventListener('dragleave', e => {
                    e.target.classList.remove('bg-yellow-100');
                    // console.log('leave');
                })
    
                dragNote.addEventListener('dragend', e => {
                    // console.log('end');    
                })
            })
        });
    }
    </script>
</div>
    