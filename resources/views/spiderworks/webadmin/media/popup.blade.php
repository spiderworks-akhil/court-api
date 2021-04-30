<div class="">
  <div class="col-md-12">
	   <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
                        <li class="nav-item">
                            <a @if(count($files)==0) class="active show" @endif data-toggle="tab" role="tab"
                               data-target="#tab1Media"
                            href="#" aria-selected="true">Upload Files</a>
                        </li>
                        <li class="nav-item">
                            <a @if(count($files)>0) class="active show" @endif data-toggle="tab" role="tab"
                               data-target="#tab2Media"
                            href="#" aria-selected="true">Media Library</a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <input type="hidden" id="popupType" value="{{$popup_type}}">
                        <input type="hidden" id="holder_attr" value="{{$holder_attr}}">
                        <input type="hidden" id="related_type" value="{{$type}}">
                        <input type="hidden" id="related_id" value="{{$related_id}}">
                        @php
                          $data_url = route('spiderworks.webadmin.media.save');
                        @endphp
                        <div class="tab-pane @if(count($files)==0) active show @endif" id="tab1Media">
                          <div class="col-md-12">
                            <div class="upload-wrapper">
                              <div id="error_output"></div>
                                  <!-- file drop zone -->
                              <div id="dropzone" class="dropzone-wrapper">
                                      <i>Drop files here</i>
                                      <i class="sm-text">or</i>
                                      <!-- upload button -->
                                      <span class="button btn-blue input-file">
                                          Browse Files <input type="file" id="fileupload" name="files[]" data-url="{{$data_url}}" multiple />
                                      </span>
                              </div>
                              <p class="warning"><b>Avoid multiple uploads of same files</b></p>
                                  <!-- The container for the uploaded files -->
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane @if(count($files)>0) active show @endif" id="tab2Media">
                          <div class="media-list-head row padding-10">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 text-right">
                              <label>
                                <input class="form-control input-sm" placeholder="Search..." aria-controls="datatable" data-type="{{$type}}" type="search" id="mediaPopupSearchInput">
                              </label>
                            </div>
                          </div>
                          <div class="row media-list-modal" id="mediaList">
                            @include($views.'.ajax_index_popup', ['files'=>$files, 'holder_attr'=>$holder_attr])
                          </div>
                          <div class="text-right">
                              @if($popup_type == 'single_image')
                                <button class="btn btn-primary" id="setSingleImage"><i class="glyphicon glyphicon-plus-sign"></i> Add Media</button>
                              @elseif($popup_type == 'product_gallery')
                                <button class="btn btn-primary" id="setProductGallery" data-product="{{$related_id}}"><i class="glyphicon glyphicon-plus-sign"></i> Add Images</button>
                              @else
                                <button class="btn btn-primary" id="addPhotos" @if($popup_type == 'photos') data-url="{{url('admin/photos/save')}}" @elseif($popup_type == 'sliders') data-url="{{url('admin/sliders/update', ['id'=>encrypt($id)])}}" @endif><i class="glyphicon glyphicon-plus-sign"></i> Add Photos</button>
                              @endif
                          </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>