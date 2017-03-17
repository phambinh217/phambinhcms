<textarea name="{{ $name or '' }}" class="form-control texteditor {{ $params['class'] or '' }}">{!! $content or '' !!}</textarea>

@addJs('js_footer', asset_url('admin', 'global/plugins/tinymce/tinymce.min.js'))