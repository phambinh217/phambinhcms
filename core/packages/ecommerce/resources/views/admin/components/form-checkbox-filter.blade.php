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

        @foreach($filters as $filter_item)
            @php $has_child = $filters->where('parent_id', $filter_item->id)->first(); @endphp
            @php $active = in_array($filter_item->id, $checked); @endphp
            @if($filter_item->parent_id == $parent_id)        
                <label>
                    <input {{ $active ? 'checked' : '' }} type="checkbox" name="{{ $name }}" value="{{ $filter_item->id }}" class="icheck" data-checkbox="icheckbox_square-grey"> {{ $filter_item->name }}
                </label>
                @if($has_child)
                    <div id="checkbox-filter-{{ $filter_item->id }}" class="collapse {{ $active ? 'in' : '' }}" style="margin-bottom: 8px">
                        <div class="icheck-list">
                            @include('Ecommerce::admin.components.form-checkbox-filter', [
                                'filters' => $filters,
                                'name' => $name,
                                'parent_id' => $filter_item->id,
                                'level' => $level + 1,
                                'checked' => $checked,
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
                        $('#checkbox-filter-'+id).collapse('show');
                    } else {
                        $('#checkbox-filter-'+id).collapse('hide');
                        $('#checkbox-filter-'+id +' input[type="checkbox"]').iCheck('uncheck');
                    }
                });
            });
        </script>
    @endpush
@endif