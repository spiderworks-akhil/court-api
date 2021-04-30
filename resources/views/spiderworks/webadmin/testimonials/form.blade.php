@extends('spiderworks.webadmin.fileupload')

@section('head')

@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT TESTIMONIAL</span>
            @else
                <span class="page-heading">CREATE TESTIMONIAL</span>
            @endif
            <div >
                <div class="btn-group">
                    <a href="{{route($route.'.index')}}"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    @if($obj->id)
                    <a href="{{route($route.'.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                    </a>
                    <a href="{{route($route.'.destroy', [encrypt($obj->id)])}}" class="btn btn-success webadmin-btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{route($route.'.index')}}"><i class="fa fa-trash"></i> Delete</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="InputFrm" data-validate=true>
                @else
                    <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="InputFrm" data-validate=true>
                @endif
                @csrf
                <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">
                
                

                <ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active show" data-toggle="tab" role="tab"
                           data-target="#tab1Basic"
                        href="#" aria-selected="true">Basic Details</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-6">
                                  <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                          <div class="checkbox check-success  ">
                                            <input type="checkbox" name="is_featured" id="checkbox-agree" @if($obj->is_featured == 1) checked="checked" @endif>
                                            <label for="checkbox-agree">Is Featured?
                                            </label>
                                          </div>
                                        </div>
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{$obj->name}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Designation</label>
                                        <textarea class="form-control" name="designation">{{$obj->designation}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
						        <div class="form-group form-group-default form-group-default-select2 required">
						          <label>Type</label>
						          <select name="comment_type" class="full-width webadmin-select2-input" id="type-select">
						            <option value="Text" @if($obj->comment_type == 'Text') selected="selected" @endif>Text</option>
						            <option value="Youtube Video" @if($obj->comment_type == 'Youtube Video') selected="selected" @endif>Youtube Video</option>
                                    <option value="Video from Computer" @if($obj->comment_type == 'Video from Computer') selected="selected" @endif>Video from Computer</option>
						          </select>
						        </div>
						    </div>
						    <div class="col-md-12" id="text-div" @if($obj->comment_type == 'Youtube Video' || $obj->comment_type == 'Video from Computer') style="display:none;" @endif>
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Comment</label>
                                        <textarea class="form-control" name="comment">{{$obj->comment}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="youtube-div" @if(!$obj->id || $obj->comment_type == 'Text' || $obj->comment_type == 'Video from Computer') style="display:none;" @endif >
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Youtube Link</label>
                                        <input type="text" name="youtube_link" class="form-control" value="{{$obj->youtube_link}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" id="video-div" @if(!$obj->id || $obj->comment_type == 'Text' || $obj->comment_type == 'Youtube Video') style="display:none;" @endif>
                                <div class="row">
                                    <p class="col-md-12">Upload Video from Computer</p>
                                    <div class="default-image-holder padding-5 @if($obj->video_link_id && $obj->video) default-video-holder @endif" >
                                        <a href="javascript:void(0);" class="video-remove" data-remove-id="mediaId_video"><i class="fa  fa-times-circle"></i></a>
                                        <a href="{{route('spiderworks.webadmin.media.popup', ['popup_type'=>'single_image', 'type'=>'Video', 'holder_attr'=>'_video', 'related_id'=>$obj->id])}}" class="webadmin-open-ajax-popup" title="Media Videos" data-popup-size="large" id="image-holder_video">
                                          @if($obj->video_link_id && $obj->video)
                                            <div class="embed-responsive embed-responsive-16by9">
                                              <video class="embed-responsive-item" controls>
                                                <source src="{{ asset('public/'.$obj->video->file_path) }}" type="{{$obj->video->file_type}}">
                                                Your browser does not support the video tag.
                                              </video>
                                            </div>
                                          @else
                                            <img class="card-img-top padding-20" src="{{asset('webadmin/img/add_image.png')}}">
                                          @endif
                                        </a>
                                        <input type="hidden" name="video_link_id" id="mediaId_video" value="{{$obj->video_link_id}}">
                                    </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">User Image</p>
                                    <div class="default-image-holder padding-5">
                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId_photo"><i class="fa  fa-times-circle"></i></a>
                                        <a href="{{route('spiderworks.webadmin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'_photo', 'related_id'=>$obj->id])}}" class="webadmin-open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder_photo">
                                          @if($obj->featured_image_id && $obj->featured_image)
                                            <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->featured_image->thumb_file_path) }}">
                                          @else
                                            <img class="card-img-top padding-20" src="{{asset('webadmin/img/add_image.png')}}">
                                          @endif
                                        </a>
                                        <input type="hidden" name="featured_image_id" id="mediaId_photo" value="{{$obj->featured_image_id}}">
                                    </div>
                              </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12" align="right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('bottom')
    <script type="text/javascript">
        var validator = $('#InputFrm').validate({
              rules: 
              {
                "name": "required",
              },
              messages: 
              {
                "name": "Name cannot be blank",
              },
        });

        $(document).ready(function(){
        	$('#type-select').change(function(){
        		if($(this).val() == 'Text')
        		{
        			$('#text-div').show();
        			$('#youtube-div').hide();
                    $('#video-div').hide();
        		}
        		else if($(this).val() == 'Youtube Video')
        		{	
        			$('#text-div').hide();
                    $('#video-div').hide();
        			$('#youtube-div').show();
        		}
                else{
                    $('#text-div').hide();
                    $('#video-div').show();
                    $('#youtube-div').hide();
                }
        	})
        })
    </script>
@parent
@endsection