@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Name:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Email:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Profile Photo:</label>
            <input type="file" name="profile_photo" class="w-full border rounded p-2">
            @if ($user->profile_photo)
                <img src="{{ Storage::url($user->profile_photo) }}" alt="Profile Photo" class="mt-2 w-24 h-24 object-cover rounded">
            @endif
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
    </form>
    <a href="{{ route('dashboard') }}" class="inline-block mt-4 text-blue-500 hover:underline">Back to Dashboard</a>
@endsection