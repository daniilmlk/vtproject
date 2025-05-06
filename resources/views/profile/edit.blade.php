@extends('layouts.app')

@section('content')
    <div class="edit-profile-container">
        <h1 class="edit-profile-title">Edit Profile</h1>

        <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Name Field --}}
            <div class="edit-form-group">
                <label for="name" class="edit-form-label">Name</label>
                <input type="text" id="name" name="name" class="edit-form-input" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="edit-error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Field --}}
            <div class="edit-form-group">
                <label for="password" class="edit-form-label">New Password (optional)</label>
                <input type="password" id="password" name="password" class="edit-form-input">
                @error('password')
                    <p class="edit-error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Avatar Upload --}}
            <div class="edit-form-group">
                <label for="avatar" class="edit-form-label">Avatar</label>
                <input type="file" id="avatar" name="avatar" class="edit-form-file">
                @error('avatar')
                    <p class="edit-error-message">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="edit-submit-btn">Save Changes</button>
        </form>
    </div>
@endsection
