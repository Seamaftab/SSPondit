<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('access_to_change_power');

        $users = User::with('role')->latest()->paginate(15);
        return view('admin.pages.users.index', compact('users'));
    }

    public function show(string $users)
    {
        $this->authorize('access_to_change_power');

        $users = User::findOrFail($users);
        return view('admin.pages.users.show', compact('users'));
    }

    public function edit(string $users)
    {
        $this->authorize('access_to_change_power');

        $users = User::findOrFail($users);
        return view('admin.pages.users.edit', compact('users'));
    }

    public function update(Request $request, string $users)
    {
        $this->authorize('access_to_change_power');

        $users = User::where('id', $users);
        $role  = Role::find('id');

        $users->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'users updated successfully.');
    }

    public function destroy(string $users)
    {
        $this->authorize('access_to_change_power');

        $user = User::findOrFail($users);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User info sent to trash');
    }

    public function trash()
    {
        $this->authorize('access_to_change_power');

        $users = User::onlyTrashed()->get();
        //dd($users);
        return view('admin.pages.users.trash', compact('users'));
    }

    public function restore($id)
    {
        $this->authorize('access_to_change_power');

        $user = User::onlyTrashed()->find($id);
        $user->restore();
        return redirect()->route('users.trash')->with('success', 'User Info restored successfully');
    }

    public function delete($id)
    {
        $this->authorize('access_to_change_power');

        $user = User::onlyTrashed()->find($id);
        $user->forceDelete();
        return redirect()->route('users.trash')->with('success', 'User Info deleted successfully');
    }
}
