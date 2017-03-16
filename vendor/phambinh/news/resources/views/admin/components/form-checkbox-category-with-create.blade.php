@php 
    if (!isset($level)) {
        $level = 0;
        $parent_id = 0;
    }
@endphp

@if($level == 0)
    <div class="well">
        <div class="input-group">
            <div class="icheck-list" id="list-categories">
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
    </div>
@endif

@if($level == 0)
    <p class="btn btn-link mb-10" data-toggle="collapse" data-target="#create-news-category">@lang('news.category.add-new-category')</p>
    <div id="create-news-category" class="collapse">
        <div class="row">
            <div class="col-sm-3 mb-10">
                <input class="form-control input-sm name" />
            </div>
            <div class="col-sm-3 mb-10">
                @include('News::admin.components.form-select-category', [
                    'name' => '',
                    'categories' => $categories,
                    'class' => 'parent-id'
                ])
            </div>
            <div class="col-sm-3 util-btn-margin-bottom-5">
                <span class="btn btn-sm full-width-xs cur-pointer add">@lang('cms.add')</span>
                <span class="btn btn-sm btn-link full-width-xs cur-pointer cancel">@lang('cms.cancel')</span>
            </div>
        </div>
    </div>

    @addCss('css', asset_url('admin', 'global/plugins/icheck/skins/all.css'))
    @addJs('js_footer', asset_url('admin', 'global/plugins/icheck/icheck.min.js'))
    @push('js_footer')
        <script type="text/javascript">
            $(function(){
                $('#create-news-category .cancel').click(function () {
                    $('#create-news-category').collapse('hide');
                });

                $('#create-news-category .add').click(function () {
                    var category = {};
                    category.name = $('#create-news-category .name').val();
                    category.parent_id = $('#create-news-category .parent-id').val();
                    if (category.name.trim() == '') {
                        $('#create-news-category .name').focus();
                        return false;
                    }

                    $.ajax({
                        url: '{{ route('api.news.category.store') }}',
                        type : 'POST',
                        dataType: 'json',
                        data: {
                            category: {
                                name: category.name,
                                parent_id: category.parent_id,
                            },
                            api_token: '{{ \Auth::user()->api_token }}',
                            _method: 'POST',
                            _token: csrfToken(),
                        },

                        success: function (response) {
                            $('#list-categories').append(
                                '<label><input checked type="checkbox" name="{{ $name }}" value="'+response.id+'" class="icheck" data-checkbox="icheckbox_square-grey">' + response.name +'</label>'
                            );

                            $('#create-news-category .parent-id').append(
                                '<option value="'+response.id+'">'+response.name+'</option>'
                            );

                            $('#create-news-category .name').val('');
                            $('#create-news-category .parent-id').val('');
                        },
                    });
                });

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
