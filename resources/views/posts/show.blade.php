@extends('layouts.front')
@section('title', 'Lire l\'article '.$post->title)
@section('content')
	<section class="mx-auto py-2 my-6">
	    <h1 class="text-3xl text-blue-700 my-8 underline">{{ $post->title}}</h1>
	    <p>{{ $post->content }}</p>
	</section>
	<h2 class="text-xl text-blue-500 underline">Les commentaires liés à ce post</h2>
	@forelse($post->comments as $comment)
		<section class="mx-auto py-2 my-6 border border-blue-100">
		    <h3 class="text-base text-blue-400">{{ $comment->title }} par {{ $comment->author }}</h3>
            @if($comment->reported)
		    	<p>Le message a été signalé</p>
		    @else
		    <p class="text-sm">{{ $comment->content }}</p>
		    @if(Auth::check() and Auth::user()->role === \App\Enums\UserRole::Admin)
                <p class="mt-2">
                    <a class="underline text-blue-400 text-xs" href="{{ route('comments.edit', $comment) }}">Editer le commentaire</a>
                </p>
		    @endif
		</section>
	@empty
		<p>Soyez le premier à laisser un commentaire ! </p>
	@endforelse
    <form action="{{ route('comments.store') }}" method="POST" class="my-6 sm:w-1/2 mx-auto">
    	<h2 class="text-xl">Laisser un commentaire</h2>
    	 @if(session('success'))
            <div class="text-xl text-green-400">
                {{ session('success') }}
            </div>
        @endif
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <div class="px-4 py-5 bg-white sm:p-6">
        	<div class="py-2">
                <label for="author" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="author" id="author" class="mt-1 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" @auth value="{{ old('author', Auth::user()->name) }}" @else value="{{ old('author') }}" @endauth>
                @error('author')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="py-2">
                <label for="title" class="block text-sm font-medium text-gray-700">Titre du commentaire</label>
                <input type="text" name="title" id="title" class="mt-1 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('title') }}">
                @error('title')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="py-2">
                <label for="content" class="block text-sm font-medium text-gray-700">Contenu</label>
                <textarea id="content" name="content" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('content') }}</textarea>
                @error('content')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="py-2">
                <input type="submit" class="cursor-pointer inline-flex items-center w-1/4 py-4 border border-gray-400 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white justify-center" value="Créer">
            </div>
        </div>
    </form>
@endsection