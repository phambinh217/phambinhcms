@php 
    if (!isset($level)) {
        $level = 0;
        $parent_id = 0;
    }
@endphp

@if($level == 0)
    <div class="input-group">
        <div class="icheck-list">
@endif
            @foreach($items as $item_item)
                @php $has_child = $items->where('parent_id', $item_item->id)->first(); @endphp
                @if($item_item->parent_id == $parent_id)        
                    <label>
                        {{ str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level) }}<input type="checkbox" name="{{ $name }}" value="{{ $item_item->id }}" class="icheck" data-checkbox="icheckbox_square-grey"> {{ $item_item->menu_title }}
                    </label>
                    @if($has_child)
                        <div id="checkbox-item-{{ $item_item->id }}" class="collapse " style="margin-bottom: 8px">
                            <div class="icheck-list">
                                @include('Appearance::admin.components.form-checkbox-menu-item', [
                                    'items' => $items,
                                    'name' => $name,
                                    'parent_id' => $item_item->id,
                                    'level' => $level + 1,
                                ])
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach

@if($level == 0)
        </div>
    </div>
@endif

@if($level == 0)
    @push('css')
        <link href="{{ asset_url('admin', 'global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    @push('js_footer')
        <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/icheck/icheck.min.js')}} "></script>
        <script type="text/javascript">
            $(function(){
                $('input[name="{{ $name }}"]').on('ifChanged', function () {
                    var id = $(this).val();
                    if (this.checked) {
                        $('#checkbox-item-'+id).collapse('show');
                    } else {
                        $('#checkbox-item-'+id).collapse('hide');
                        $('#checkbox-item-'+id +' input[type="checkbox"]').iCheck('uncheck');
                    }
                });
            });
        </script>
    @endpush
@endif