@if ($paginator->hasPages())
    <div style="margin-top: 20px;">
        <p style="font-size: 13px; color: #6b7280; margin: 0 0 8px 0;">
            Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
        </p>
        <div style="display: flex; gap: 4px; flex-wrap: wrap;">

            {{-- Prev --}}
            @if ($paginator->onFirstPage())
                <span style="padding: 5px 10px; border: 1px solid #e5e7eb; border-radius: 4px; background: #f3f4f6; color: #9ca3af; font-size: 14px;">&laquo;</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" style="padding: 5px 10px; border: 1px solid #d1d5db; border-radius: 4px; background: #fff; color: #2563eb; text-decoration: none; font-size: 14px;">&laquo;</a>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span style="padding: 5px 10px; font-size: 14px; color: #6b7280;">{{ $element }}</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="padding: 5px 10px; border: 1px solid #2563eb; border-radius: 4px; background: #2563eb; color: #fff; font-size: 14px; font-weight: bold;">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" style="padding: 5px 10px; border: 1px solid #d1d5db; border-radius: 4px; background: #fff; color: #2563eb; text-decoration: none; font-size: 14px;">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" style="padding: 5px 10px; border: 1px solid #d1d5db; border-radius: 4px; background: #fff; color: #2563eb; text-decoration: none; font-size: 14px;">&raquo;</a>
            @else
                <span style="padding: 5px 10px; border: 1px solid #e5e7eb; border-radius: 4px; background: #f3f4f6; color: #9ca3af; font-size: 14px;">&raquo;</span>
            @endif

        </div>
    </div>
@endif
