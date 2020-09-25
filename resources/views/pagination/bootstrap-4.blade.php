@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" style="background-color: #f1f1f1c7;" href="{{ $paginator->previousPageUrl() }}" rel="prev">Anterior</a></li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a style="background-color: #f1f1f1c7;" class="page-link " href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link waves-effect" style="background-color: #f1f1f1c7;" href="{{ $paginator->nextPageUrl() }}" rel="next">Próximo</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">Último</span></li>
        @endif
    </ul>
@endif
