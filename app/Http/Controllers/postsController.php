<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;

class postsController extends Controller
{
    public function __construct() {
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('posts.index', ['posts'=>Post::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'content' => 'required|min:10'
        ]);
    
        // Obtenez l'utilisateur actuellement connecté
        $user = auth()->user();
    
        // Créez un nouveau post associé à l'utilisateur actuel
        $post = $user->posts()->create($validatedData);
    
        return redirect()->back()->with('success', 'Le post a été créé');
    }

    /**
     * Display the specified resource.
     */
    public function show(post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(post $post)
    {
        $this->isAbleToEdit($post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, post $post)
    {
        $this->isAbleToEdit($post);
        $validatedData = $request->validate([
            'title'=>'required|min:2|max:255',
            'content'=>'required|min:10'
        ]);
        $post->update($validatedData);

        return redirect()->back()->with('success', 'Le post a été modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(post $post)
    {
        $post->delete();
        return redirect()->back()->with('success', 'Le post a été supprimé');
    }
}
