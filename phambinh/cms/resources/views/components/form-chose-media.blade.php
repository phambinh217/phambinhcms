<input type="hidden" name="{{ $name }}" class="hide file-input" value="{{ $value }}" />
<div class="row">
    <div class="col-lg-4">
        <div class="mt-element-card mt-element-overlay">
            <div class="mt-card-item">
                <div class="mt-overlay-1 fileinput-new">
                    <div class="fileinput-new">
                        <img src="{{ $url_image_preview }}" class="image-preview" />
                    </div>
                    <div class="fileinput-preview fileinput-exists"></div>
                    <div class="mt-overlay">
                        <ul class="mt-info">
                            <li>
                                <a class="btn default btn-outline open-file-broswer">
                                    <i class="fa fa-upload"></i>
                                </a>
                            </li>
                            <li>
                                <a class="btn default btn-outline">
                                    <i class="fa fa-times"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>