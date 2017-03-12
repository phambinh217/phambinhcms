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
        @foreach($categories as $category_item)
            @php $has_child = $categories->where('parent_id', $category_item->id)->first(); @endphp
            @php $active = in_array($category_item->id, $checked); @endphp
            @if($category_item->parent_id == $parent_id)        
                <label>
                    {{ str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $level) }}<input {{ $active ? 'checked' : '' }} type="checkbox" name="{{ $name }}" value="{{ $category_item->id }}" class="icheck" data-checkbox="icheckbox_square-grey"> {{ $category_item->name }}
                </label>
                @if($has_child)
                    <div id="checkbox-category-{{ $category_item->id }}" class="collapse {{ $active ? 'in' : '' }}"  style="margin-bottom: 8px">
                        <div class="icheck-list">
                            @include('News::admin.components.form-checkbox-category', [
                                'categories' => $categories,
                                'name' => $name,
                                'parent_id' => $category_item->id,
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
                        $('#checkbox-category-'+id).collapse('show');
                    } else {
                        $('#checkbox-category-'+id).collapse('hide');
                        $('#checkbox-category-'+id +' input[type="checkbox"]').iCheck('uncheck');
                    }
                });
            });
        </script>
    @endpush
@endif