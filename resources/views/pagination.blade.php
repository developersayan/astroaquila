@if($paginator->hasPages())
    <nav>
        <ul>
            {{-- Previous Page Link --}}
            @if($paginator->currentPage() > 5)
                <li><a href="#url">
                  <i class="fa fa-angle-double-left"></i>
                  </a>
                </li>
            @endif
            @if ($paginator->onFirstPage())
                 <li><a href="<?php echo $paginator->url( $paginator->currentPage() - 5 ); ?>">
                   <i class="fa fa-angle-double-left"></i>
                  </a>
                </li>
            @else
                <li><a href="<?php echo $paginator->url( $paginator->currentPage() - 5 ); ?>">
                  <i class="fa fa-angle-double-left"></i>
                  </a>
                </li>
            @endif
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                             <li><a href="#url" class="activ">{{ $page }}</a></li>
                           {{--  <li class="active" aria-current="page"><span class="custome"></span></li> --}}
                        @else
                            <li><a  href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li >
                    <a  href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li><a href="<?php echo $paginator->url( $paginator->currentPage() - 5 ); ?>">
                  <i class="fa fa-angle-double-right"></i>
                  </a>
                </li>
            @endif
            {{-- @if($paginator->lastPage() >= $paginator->currentPage()+1)
                <li>
                    <a href="{{ $paginator->url( $paginator->currentPage() + 1 ) }}" rel="prev" aria-label="Skip 5  &rsaquo;">Skip 1 &rsaquo;</a>
                </li>
            @endif --}}
        </ul>
    </nav>
@endif
