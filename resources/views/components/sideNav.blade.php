<div class="sideNavContainer">
    <div>
        @isset($current_profile)
        <div>{{$current_profile->name}}</div>

                @isset($folders)
                @foreach($folders as $folder)
                @if($folder->profile_id == $current_profile->id)
                    <div>{{$folder->name}}</div>

                    @isset($notes)
                    @foreach($notes as $note)
                    @if($note->folder_id == $folder->id)

                        <div>{{$note->name}}{{$note->id}}</div>

                    @endif {{--notes has folder id--}}
                    @endforeach {{--notes--}}
                    @endisset {{--notes--}}
                    <div>
                        <a onclick="popupNewNote()" class="add-icon">{{ svg('ri-add-fill') }}New Note</a>
                        @include('popups.add-new-note')
                    </div>

                @endif {{--folder has profile id--}}
                @endforeach {{--folders--}}
                @endisset {{--folders--}}
                <div>
                    <a onclick="popupNewFolder()" class="add-icon">{{ svg('ri-add-fill') }}New Folder</a>
                    @include('popups.add-new-folder')
                </div>

            @endisset {{--profile--}}
        <div>
            <a onclick="popupNewProfile()" class="add-icon">{{ svg('ri-add-fill') }}New Profile</a>
            @include('popups.add-new-profile')
        </div>
    </div>

    <div>
        @isset($draft_folder)
            {{$draft_folder->name}}
            @foreach($notes as $note)
                <div>
                    <a href="/edit-note?note_id={{ $note->id }}">{{$note->name}}</a>
                </div>
            @endforeach
        @endisset
    </div>
</div>