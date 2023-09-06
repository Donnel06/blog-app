@extends('layouts.front')
@section('title', 'Modification de mon profil')
@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <h3 class="text-3xl mx-4 my-4">Modification de mon profil</h3>
    @if(session('success'))
        <div class="text-xl text-green-400">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('users.update', $user) }}" method="POST" class="mx-auto">
        @csrf
        @method('PUT')
        <div class="px-4 py-5 bg-white sm:p-6">
            <div class="py-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Prénom</label>
                <input type="text" name="name" id="name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('name', $user->name) }}">
                @error('name')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="py-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="text" name="email" id="email" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('email', $user->email) }}">
                @error('email')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            @if(Auth::user()->role === \App\Enums\UserRole::Admin)
                <div class="py-2">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role">
                        @foreach(\App\Enums\UserRole::cases() as $role)
                            <option value="{{ $role->value}}" @selected(old('role', Auth::user()->role) == $role)>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="py-2">
                <input type="submit" class="cursor-pointer inline-flex items-center w-1/4 py-4 border border-gray-400 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white justify-center" value="Modifier">
            </div>
        </div>
    </form>
</div>
@endsection