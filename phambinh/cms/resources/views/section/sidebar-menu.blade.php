@php 
    if (!isset($level)) {
        $level = 0;
        $parent = '0';
        $menus = \AdminMenu::sortBy('order')->all();
    }
@endphp

@if($level == 0)
    <ul class="page-sidebar-menu page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 10px">
        <li class="sidebar-toggler-wrapper hide">
            <div class="sidebar-toggler">
                <span></span>
            </div>
        </li>
        @foreach($menus as $key => $menu_item)
            @php $has_child = \AdminMenu::where('parent', $menu_item['id'])->first() ;@endphp
            @if($menu_item['parent'] == $parent)
                @php unset($menus[$key]); @endphp
                @if(isset($menu_item['label']))
                    <li class="heading">
                        <h3 class="uppercase">{{ $menu_item['label'] }}</h3>
                    </li>
                @endif
                @if($has_child)
                    @include('Cms::section.sidebar-menu', [
                        'parent' => $menu_item['id'],
                        'level' => $level + 1,
                        'menus' => $menus,
                    ])
                @endif
            @endif
        @endforeach
    </ul>
@else
    @foreach($menus as $key => $menu_item)
        @php $has_child = \AdminMenu::where('parent', $menu_item['id'])->first() ;@endphp
        @if($menu_item['parent'] == $parent)
            @php unset($menus[$key]); @endphp
            @if(isset($menu_item['label']))
                <li class="nav-item {{ in_array($menu_item['id'], $active_admin_menu) ? 'active open' : '' }}">
                    <a href="{{ $menu_item['url'] }}" class="nav-link nav-toggle" {!! $menu_item['attributes'] or '' !!}>
                        <i class="{{ $menu_item['icon'] }}"></i>
                        <span class="title">{!! $menu_item['label'] !!}</span>
                        @if($has_child) <span class="arrow"></span> @endif
                    </a>
                    @if($has_child)
                        <ul class="sub-menu">
                             @include('Cms::section.sidebar-menu', [
                                'parent' => $menu_item['id'],
                                'level' => $level + 1,
                                'menus' => $menus,
                            ])
                        </ul>
                    @endif
                </li>
            @endif
        @endif
    @endforeach
@endif