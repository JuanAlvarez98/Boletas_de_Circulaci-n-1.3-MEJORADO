@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; width: 100%; margin-top: 20px; font-size: 13.5px;">
        <div>
            <p style="margin: 0; color: #64748b; font-size: 13px;">
                Mostrando
                @if ($paginator->firstItem())
                    <span style="font-weight: 700; color: #0f172a;">{{ $paginator->firstItem() }}</span>
                    a
                    <span style="font-weight: 700; color: #0f172a;">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                de
                <span style="font-weight: 700; color: #0f172a;">{{ $paginator->total() }}</span>
                resultados
            </p>
        </div>

        <div style="display: inline-flex; align-items: center; background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 9px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            {{-- Anterior --}}
            @if ($paginator->onFirstPage())
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #cbd5e1; cursor: not-allowed; background: #f8fafc; border-right: 1px solid #e2e8f0;" aria-disabled="true">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #334155; text-decoration: none; border-right: 1px solid #e2e8f0; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif

            {{-- Elementos de paginación --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span style="display: inline-flex; align-items: center; justify-content: center; padding: 0 12px; height: 36px; color: #94a3b8; font-weight: 600; border-right: 1px solid #e2e8f0;">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 10px; font-weight: 700; color: #ffffff; background: #2563eb; border-right: 1px solid #2563eb;" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 10px; font-weight: 600; color: #334155; text-decoration: none; border-right: 1px solid #e2e8f0; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #334155; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#ffffff'">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; color: #cbd5e1; cursor: not-allowed; background: #f8fafc;" aria-disabled="true">
                    <svg width="16" height="16" style="width: 16px; height: 16px; display: inline-block;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif
