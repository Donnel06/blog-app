<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>
<div class="py-12">
<div class="max-w-lg mx-auto bg-white shadow-md rounded-md p-6">
        <h2 class="text-xl font-semibold mb-4">Créer un nouveau poste</h2>

        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titre du poste :</label>
                <input type="text" id="title" name="title" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" placeholder="Entrez le titre du poste" required>
            </div>

            <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Contenu du poste :</label>
                <textarea id="content" name="content" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" rows="6" placeholder="Entrez le contenu du poste" required></textarea>
            </div>

           

            
            <div class="py-2">
                <input type="submit" class="cursor-pointer inline-flex items-center w-1/4 py-4 border border-gray-400 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white justify-center" value="Créer">
            </div>
        </form>
    </div>
    </div>
</div>
</x-app-layout>
