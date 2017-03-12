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
            @foreach($brands as $brand_item)
                @php $has_child = $brands->where('parent_id', $brand_item->id)->first(); @endphp
                @php $active = in_array($brand_item->id, $checked); @endphp
                @if($brand_item->parent_id == $parent_id)        
                    <label>
                        {{ str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level) }}<input {{ $active ? 'checked' : '' }} type="checkbox" name="{{ $name }}" value="{{ $brand_item->id }}" class="icheck" data-checkbox="icheckbox_square-grey"> {{ $brand_item->name }}
                    </label>
                    @if($has_child)
                        <div id="checkbox-brand-{{ $brand_item->id }}" class="collapse {{ $active ? 'in' : '' }}" style="margin-bottom: 8px">
                            <div class="icheck-list">
                                @include('Ecommerce::admin.components.form-checkbox-brand', [
                                    'brands' => $brands,
                                    'name' => $name,
                                    'parent_id' => $brand_item->id,
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
                        $('#checkbox-brand-'+id).collapse('show');
                    } else {
                        $('#checkbox-brand-'+id).collapse('hide');
                        $('#checkbox-brand-'+id +' input[type="checkbox"]').iCheck('uncheck');
                    }
                });
            });
        </script>
    @endpush
@endif