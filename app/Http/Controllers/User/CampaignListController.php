<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignCategory;
use Illuminate\Http\Request;

class CampaignListController extends Controller
{
    public function index(Request $request)
    {
        $categories = CampaignCategory::where('is_active', 'yes')->get();

        $query = Campaign::with(['category', 'user', 'images'])
            ->where('verification_status', 'approved')
            ->where('campaign_status', 'active');

        // Filter kategori
        if ($request->filled('category') && $request->category !== 'semua') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort/Filter
        switch ($request->sort) {
            case 'most_donated':
                $query->orderBy('current_amount', 'desc');
                break;
            case 'deadline':
                $query->orderBy('end_date', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $campaigns = $query->paginate(12)->withQueryString();

        $selectedCategory = $request->category ?? 'semua';
        $search = $request->search ?? '';
        $sort = $request->sort ?? 'latest';

        return view('user.campaigns.campaigns-list', compact('campaigns', 'categories', 'selectedCategory', 'search', 'sort'));
    }
}