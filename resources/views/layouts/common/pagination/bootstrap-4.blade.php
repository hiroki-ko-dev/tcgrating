@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)

            @if (is_array($element))
              @foreach ($element as $page => $url)
                {{-- アクティブ --}}
                @if ($page == $paginator->currentPage())
                  <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                @elseif($page > $paginator->currentPage() - 4 && $page < $paginator->currentPage() + 4)
                  <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @else
                  {{-- 最初のページ --}}
                  @if ($page == 1)
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                  @endif

                  {{-- 最後のページ --}}
                  @if ($page == $paginator->lastPage())
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                  @endif
                @endif
              @endforeach
            @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
