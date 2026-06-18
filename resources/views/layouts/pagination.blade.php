@if(isset($items) && $items->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
        <p>
            Menampilkan <span class="font-semibold">{{ $items->firstItem() }}</span> 
            sampai <span class="font-semibold">{{ $items->lastItem() }}</span> 
            dari <span class="font-semibold">{{ $items->total() }}</span> data
        </p>
        <div class="flex items-center space-x-1">
            @if($items->onFirstPage())
                <span class="px-3 py-1.5 border border-gray-200 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed select-none">Sebelumnya</span>
            @else
                <a href="{{ $items->previousPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition">Sebelumnya</a>
            @endif

            @foreach ($items->getUrlRange(max(1, $items->currentPage() - 2), min($items->lastPage(), $items->currentPage() + 2)) as $page => $url)
                @if ($page == $items->currentPage())
                    <span class="px-3 py-1.5 bg-[#2D1622] text-white font-bold rounded-lg select-none">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-3 py-1.5 border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition">{{ $page }}</a>
                @endif
            @endforeach

            @if($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="px-3 py-1.5 border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition">Selanjutnya</a>
            @else
                <span class="px-3 py-1.5 border border-gray-200 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed select-none">Selanjutnya</span>
            @endif
        </div>
    </div>
@endif