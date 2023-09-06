<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserRole;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->isAbleToEdit($user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->isAbleToEdit($user);
        $validatedData = $request->validate([
            'name' => ['required', 'min:2', 'max:50'],
            'email' => 'required|email',
            'role'=> [new Enum(\App\Enums\UserRole::class)],
        ]);

        if(request()->user()->role === \App\Enums\UserRole::Admin) {
            $user->update($validatedData);
        } else {
            $user->update([
                'name'=>$validatedData['name'],
                'email'=>$validatedData['email']
            ]);
        }
        return redirect()->back()->with('success', 'Les informations ont bien été modifiées');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'L\'utilisateur a bien été supprimé');
    }

    private function isAbleToEdit(User $user)
    {
        if (!($user->id === request()->user()->id or request()->user()->role === UserRole::Admin)) {
            abort(403);
        }
    }
}