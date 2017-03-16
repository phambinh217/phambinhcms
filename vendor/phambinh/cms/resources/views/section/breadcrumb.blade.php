<ul class="page-breadcrumb breadcrumb hidden-xs">
    @if(count($breadcrumbs))
        @foreach($breadcrumbs['title'] as $title)
            <li>
                @if(! $loop->last)
                    <a href="{{ isset($breadcrumbs['url'][$loop->index]) ? $breadcrumbs['url'][$loop->index] : '' }}">{{ $title }}</a>
                    <i class="fa fa-circle"></i>
                @else
                    <span class="active">{{ $title }}</span>
                @endif
            </li>
        @endforeach
    @endif
</ul>