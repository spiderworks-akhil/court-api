<div class="settings-item w-100 confirm-wrap">
    <?php
    if($obj->type != 'Image')
        $validate = true;
    else
        $validate = false;
    ?>
        <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="SettingsFrm" enctype="multipart/form-data" data-validate=true>
                    @csrf
            <input type="hidden" name="id" value="{{encrypt($obj->id)}}">
            <input type="hidden" name="type" value="{{$obj->setting_type}}">
                                @if($obj->setting_type != 'Image')
                                <div class="column-seperation padding-5 text-field">
                                    <div class="form-group form-group-default required">
                                        <label>Value</label>
                                        <input type="text" name="value" class="form-control" id="value_1" value="{{$obj->value_text}}">

                                    </div>
                                </div>
                                @else
                                <div class="column-seperation padding-5 image-field">
                                    <div class="fileinput fileupload-exists center-block" data-provides="fileupload" >
                                      <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 100px; height: 100px; margin: 0 auto;">
                                        <img src="{{ asset($obj->media->file_path) }}"  alt="{{$obj->value_text}}"/>
                                      </div>
                                      <div>
                                        <span class="btn-file">
                                            <input type="file" name="image" id="image_1" >
                                        </span>
                                      </div>
                                    </div>
                                    <p class="help-block text-info text-center">Click on the image to change</p>
                                </div>
                                @endif
                                <div class="row bottom-btn">
                                    <div class="col-md-12" align="right">
                                        <button type="button" id="webadmin-ajax-form-submit-btn" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
        </form>               
</div>
