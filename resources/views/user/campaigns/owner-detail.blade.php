@extends('layouts.sidebar.user') @section('title', 'Detail Campaign Owner')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <div>
        <a href="{{ route('user.campaigns') }}" class="text-xs font-semibold text-gray-500 hover:text-[#2D1622] transition flex items-center space-x-1 w-fit">
            <i class="fa-solid fa-chevron-left text-[10px]"></i>
            <span>Kembali ke Campaign Saya</span>
        </a>
    </div>

    <div class="text-center py-20 bg-white rounded-3xl border border-gray-200 shadow-sm space-y-4">
        <div class="text-[#EE7D43] text-6xl animate-bounce">
            <i class="fa-solid fa-circle-info"></i>
        </div>
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-[#2D1622]">Detail Campaign Owner</h1>
        </div>
        <div class="pt-2">
            <span class="inline-flex items-center px-4 py-1.5 text-xs font-mono font-bold bg-[#F6ECEF] text-[#2D1622] rounded-xl border border-gray-100">
                Campaign ID: #CAM-{{ $campaign->campaign_id }}
            </span>
        </div>
    </div>

</div>
@endsection