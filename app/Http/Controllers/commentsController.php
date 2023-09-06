<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;

class commentsController extends Controller
{
    public function __construct() {
        $this->middleware('admin')->only(['index', 'destroy', 'edit', 'update']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('comments.index', ['comments'=>Comment::with('post')->get()]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post_id'=>'required|numeric|exists:App\Models\Post,id',
            'title'=>'required|min:2|max:255',
            'author'=>'required|min:2|max:50',
            'content'=>'required|min:5',
        ]);
        $comment = Post::find($request->input('post_id'))->comments()->create($validatedData);

        return redirect()->back()->with('success', 'Le commentaire a été créé');
    }

    /**
     * Display the specified resource.
     */
    public function show(comment $comment)
    {
        return view('comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(comment $comment)
    {
        $this->isAbleToEdit($comment);
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, comment $comment)
    {
        $validatedData = $request->validate([
            'title'=>'required|min:2|max:255',
            'author'=>'required|min:2|max:50',
            'content'=>'required|min:5',
        ]);
        if($comment->reported) {
            $comment->update(array_merge($validatedData, ['reported' => 0]));
        } else {
            $comment->update($validatedData);
        }
        return redirect()->back()->with('success', 'Le commentaire a été modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Le commentaire a été supprimé');
    }
    public function report(Comment $comment) {
        $comment->reported = 1;
        $comment->save();

        return redirect()->back()->with('success', 'Le commentaire a été signalé');
    }
}
