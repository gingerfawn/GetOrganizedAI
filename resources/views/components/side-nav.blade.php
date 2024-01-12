<div class="sideNavContainer">

    @livewire('switch-profiles', ['profiles' => $profiles, 'current_profile' => $current_profile])
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

                        <div>{{$note->name}}{{$note->id}}</div><a class="icon-small">{{ svg('gmdi-edit') }}</a>

                    @endif {{--notes has folder id--}}
                    @endforeach {{--notes--}}
                    @endisset {{--notes--}}
                    <div>
                        <a class="icon-small" href="/">{{ svg('ri-add-fill') }}New Note</a>
                    </div>

                @endif {{--folder has profile id--}}
                @endforeach {{--folders--}}
                @endisset {{--folders--}}
                <div>
                    <a class="icon-small" data-bs-toggle="modal" data-bs-target="#addNewFolder">{{ svg('ri-add-fill') }}New Folder</a>
                    @include('popups.add-new-folder')
                </div>

            @endisset {{--profile--}}
        <div>
            <a class="icon-small" data-bs-toggle="modal" data-bs-target="#addNewProfile">{{ svg('ri-add-fill') }}New Profile</a>
            @include('popups.add-new-profile')
        </div>
    </div>

    <div>
        @isset($draft_folder)
            {{$draft_folder->name}}
            @foreach($notes as $note)
                <div>
                    <a href="/edit-note?note_id={{ $note->id }}">{{$note->name}}</a><a class="icon-small">{{ svg('gmdi-edit') }}</a>
                </div>
            @endforeach
        @endisset
    </div>
</div>

