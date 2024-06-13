<?php

// app/Http/Controllers/DealController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use App\Models\Lead;

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
        $deals = Deal::all();
        return view('deals.index', compact('deals'));
    }
}
