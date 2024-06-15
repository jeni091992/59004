<?php

// app/Http/Controllers/DealController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'deal_value' => 'required|numeric',
        ]);

        $lead = Lead::findOrFail($request->lead_id);

        $deal = Deal::create([
            'name' => $lead->name,
            'email' => $lead->email,
            'phone' => $lead->phone,
            'message' => $lead->message,
            'agent_id' => $lead->agent_id,
            'lead_id' => $lead->id,
            'deal_value' => $request->deal_value,
        ]);

        // Optional: update lead status or delete lead
        $lead->stage = 'Closed-Won';
        $lead->save();

        return redirect()->route('leads.index')->with('success', 'Deal created successfully.');
    }

    public function index()
    {
        if(Auth::user()->role == 'agent'){
            $deals = Deal::where('agent_id', Auth::user()->id)->get();
        }
        else{
            $deals = Deal::all();
        }
        
        return view('deals.index', compact('deals'));
    }

    public function edit($id)
    {
        $deal = Deal::findOrFail($id);
        $agents = User::where('role', 'agent')->get();
        return view('deals.edit', compact('deal', 'agents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'nullable|string',
            'agent_id' => 'required|exists:agents,id',
            'deal_value' => 'required|numeric',
        ]);

        $deal = Deal::findOrFail($id);
        $deal->name = $request->input('name');
        $deal->email = $request->input('email');
        $deal->phone = $request->input('phone');
        $deal->message = $request->input('message');
        $deal->agent_id = $request->input('agent_id');
        $deal->deal_value = $request->input('deal_value');
        $deal->save();

        return redirect()->route('deals.index')->with('success', 'Deal updated successfully.');
    }

    public function destroy($id)
    {
        Deal::findOrFail($id)->delete();
        return redirect()->route('deals.index')->with('success', 'Deal deleted successfully.');
    }

}
