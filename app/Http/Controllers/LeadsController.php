<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LeadsController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'agent'){
            $leads = Lead::where('agent_id', Auth::user()->id)->get();
        }
        else{
            $leads = Lead::all();
        }
        
        return view('leads.index', compact('leads'));
    }

    public function create()
    {
        $agents = User::where('role', 'agent')->get();
        return view('leads.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:leads',
            'phone' => 'required',
            'message' => 'nullable',
            'agent_id' => 'nullable|exists:users,id'
        ]);

        Lead::create($request->all());

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function edit(Lead $lead)
    {
        $agents = User::where('role', 'agent')->get();
        return view('leads.edit', compact('lead', 'agents'));
    }

    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:leads,email,' . $lead->id,
            'phone' => 'required',
            'message' => 'nullable',
            'agent_id' => 'nullable|exists:users,id',
            'stage' => 'required|string'
        ]);

        $lead->update($request->all());

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

}
