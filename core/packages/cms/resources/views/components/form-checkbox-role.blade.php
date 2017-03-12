<div class="input-group">
    <div class="icheck-list">
        @foreach($roles as $role_item)
            @php $active = in_array($role_item->id, $checked); @endphp
            <label>
                <input {{ $active ? 'checked' : '' }} type="checkbox" name="{{ $name }}[]" value="{{ $role_item->id }}" class="icheck" data-checkbox="icheckbox_square-grey"> {{ $role_item->name }}
            </label>
        @endforeach
    </div>
</div>

@push('css')
    <link href="{{ asset_url('admin', 'global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />
@endpush
@push('js_footer')
    <script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/icheck/icheck.min.js')}} "></script>
@endpush
