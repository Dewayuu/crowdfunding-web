<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Campaign;
use App\Models\CampaignCategory;

class CampaignController extends Controller
{
    public function create()
    {
        $categories = CampaignCategory::all();

        return view('user.create-campaign', compact('categories'));
    }

    
public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required',
        'title' => 'required|max:255',
        'short_description' => 'required|max:255',
        'story' => 'required',
        'target_amount' => 'required|numeric|min:10000',
        'end_date' => 'required|date',
        'proposal_file' => 'nullable|mimes:pdf|max:5120',
    ]);

    $proposal = null;

    if ($request->hasFile('proposal_file')) {
        $proposal = $request->file('proposal_file')
            ->store('proposal', 'public');
    }

    Campaign::create([
        'user_id' => Auth::id(),
        'category_id' => $request->category_id,
        'title' => $request->title,
        'slug' => Str::slug($request->title).'-'.time(),
        'short_description' => $request->short_description,
        'story' => $request->story,
        'target_amount' => $request->target_amount,
        'current_amount' => 0,
        'end_date' => $request->end_date,
        'proposal_file' => $proposal,
    ]);

    return redirect()
        ->route('user.dashboard')
        ->with('success','Campaign berhasil dibuat.');
}
}