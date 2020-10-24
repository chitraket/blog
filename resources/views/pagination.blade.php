@if ($paginator->hasPages())

    <ul class="pager">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <!--<a class="primary-btn loadmore-btn mt-70 mb-60 disabled" style="color: white"><</a>-->
        @else
        <a class="primary-btn loadmore-btn mt-70 mb-60" href="{{ $paginator->previousPageUrl() }}" rel="prev" ><</a>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
            <a class="primary-btn loadmore-btn mt-70 mb-60 disabled text-white" >{{ $element }}</a>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())

                    <a class="primary-btn loadmore-btn mt-70 mb-60 active text-white">{{ $page }}</a>
                        
                    @else
                    <a class="loadmore-btn mt-70 mb-60 text-secondary"  href="{{ $url }}" >{{ $page }}</a>

                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <a class="primary-btn loadmore-btn mt-70 mb-60" href="{{ $paginator->nextPageUrl() }}" rel="next">></a>
            
        @else
           <!-- <li class="disabled"><span>Next ?</span></li>-->
        @endif
    </ul>
@endif