@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination-container">
        @if($position === 'top')
            <div class="pagination-top">
                <p class="pagination-info">
                    <span class="pagination-total">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                    @if ($paginator->firstItem())
                        <small>
                            (<span class="pagination-counters">{{ $paginator->firstItem() }}</span>
                            <i class="fa-solid fa-arrow-right"></i>
                            <span class="pagination-counters">{{ $paginator->lastItem() }}</span>)
                        </small>
                    @endif
                </p>
            </div>
        @elseif($position === 'bottom')
            <div class="pagination-bottom">
                <span class="pagination-links">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="pagination-previous-link disabled">
                            <i class="fa-solid fa-angle-left"></i>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-previous-link">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true" class="pagination-dots">
                                <i class="fa-solid fa-ellipsis"></i>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page === $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="pagination-page-number active">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="pagination-page-number" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next-link">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    @else
                        <span class="pagination-next-link disabled">
                           <i class="fa-solid fa-angle-right"></i>
                        </span>
                    @endif
                </span>
            </div>
        @endif
    </nav>
@endif
