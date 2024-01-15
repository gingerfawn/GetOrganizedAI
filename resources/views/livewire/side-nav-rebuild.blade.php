<div>
<div>
    <div>
    @isset($current_profile)
            @isset($folders)
            @foreach($folders as $folder)
            @if($folder->profile_id == $current_profile->id)
            <div >
                <div>{{$folder->name}}</div>

                @isset($notes)
                    <ul drag-folder draggable="true" class="side-menu-panel">
                    @foreach($notes as $note)
                    @if($note->folder_id == $folder->id)

                    <li drag-note draggable="true" wire:key="{{ $note->id }}" drag-item="{{ $note->id }}">
                        <a href="/edit-note?note_id={{ $note->id }}">{{$note->name}}</a> 
                    </li>

                    @endif {{--notes has folder id --}}
                    @endforeach {{--notes--}}
                    </ul>
                @endisset {{--notes--}}
                {{-- <div>
                    <a class="icon-small" href="/">{{ svg('ri-add-fill') }}New Note</a>
                </div> --}}
            </div>
            @endif {{--folder has profile id--}}
            @endforeach {{--folders--}}
            @endisset {{--folders--}}
            {{-- <div>
                <a class="icon-small" data-bs-toggle="modal" data-bs-target="#addNewFolder">{{ svg('ri-add-fill') }}New Folder</a>
                @include('popups.add-new-folder')
            </div> --}}

        @endisset {{--profile--}}
    {{-- <div>
        <a class="icon-small" data-bs-toggle="modal" data-bs-target="#addNewProfile">{{ svg('ri-add-fill') }}New Profile</a>
        @include('popups.add-new-profile')
    </div> --}}
</div>

<div>
    @isset($draft_folder)
        {{$draft_folder->name}}
        <ul drag-folder draggable="true" class="side-menu-panel">
        @foreach($notes as $note)
            <li drag-note draggable="true" wire:key="{{ $note->id }} drag-item="{{ $note->id }}">
                <a href="/edit-note?note_id={{ $note->id }}">{{$note->name}}</a> 
            </li>
        @endforeach
        </ul>
    @endisset

    
</div>
</div>
<script>
    let dragFolders = document.querySelectorAll('[drag-folder]');
    dragFolders.forEach(dragFolder => {
        dragFolder.addEventListener('drop', e => {
            console.log(e.target);
        });
        dragFolder.addEventListener('dragstart', e => {
            console.log(e.target)
        });
        dragFolder.addEventListener('dragenter', e => {
            e.preventDefault();
            console.log(e.target)
        });
        dragFolder.addEventListener('dragover', e => {
            e.preventDefault();
            console.log(e.target)
        });
        dragFolder.addEventListener('dragleave', e => {
            console.log(e.target)
        });
        dragFolder.addEventListener('dragend', e => {
            console.log(e.target)
        })

        dragFolder.querySelectorAll('[drag-note]').forEach(dragNote => {
            dragNote.addEventListener('dragstart', e => {
                e.target.setAttribute('dragging', true);
            })

            dragNote.addEventListener('drop', e => {
                e.target.classList.remove('bg-yellow-100');

                //get the note just getting one folder, could cause issues
                let draggingEl = dragFolder.querySelector('[dragging]');
                //insert into folder
                //add possible conditions for dragging up and dragging down
                e.target.before(draggingEl);
                let component = Livewire.find(e.target.closest('[wire\\:id]').getAttribute('wire:id'));
                component.call('moveNote', e.target, dragFolder);

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
                e.target.removeAttribute('dragging');

            })
        })
    });
</script>
</div>

