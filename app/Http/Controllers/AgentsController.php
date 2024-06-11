<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AgentsController extends Controller
{
    public function index()
    {
        $agents = User::where('role', 'agent')->get();
        return view('agents.index', compact('agents'));
    }

    public function create()
    {
        return view('agents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'agent', // Setting the role to 'agent'
        ]);

        return redirect()->route('agents.index')->with('success', 'Agent created successfully.');
    }

    public function edit(User $agent)
    {
        return view('agents.edit', compact('agent'));
    }

    public function update(Request $request, User $agent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$agent->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $agent->name = $request->name;
        $agent->email = $request->email;

        if ($request->filled('password')) {
            $agent->password = Hash::make($request->password);
        }

        $agent->save();

        return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
    }

    public function destroy(User $agent)
    {
        $agent->delete();
        return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
    }
}
