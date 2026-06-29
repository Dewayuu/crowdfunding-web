<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class UserCampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::with(['category'])
            ->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('short_description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('verification_status', $request->status);
        }

        if ($request->filled('category')) {
            $categoryName = $request->category;
            $query->whereHas('category', function($q) use ($categoryName) {
                $q->where('category_name', $categoryName);
            });
        }

        $campaigns = $query->orderBy('created_at', 'DESC')
                           ->paginate(6)
                           ->withQueryString();

        return view('user.campaigns.index', compact('campaigns'));
    }

    public function ownerDetail($id)
    {
        $campaign = Campaign::findOrFail($id);

        return view('user.campaigns.owner-detail', compact('campaign'));
    }
}