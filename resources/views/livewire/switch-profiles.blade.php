<div class="select-profile">
    <select wire:model="selectedProfile" wire:change="updateSelectedProfile($event.target.value)" >
        @foreach($profiles as $profile)
            {{-- <option value="{{ $profile->id }}" @if($profile->id == $current_profile->id) selected @endif>{{ $profile->name }}</option> --}}
            <option value="{{ $profile->id }}">{{ $profile->name }}</option>
        @endforeach
    </select>
</div>