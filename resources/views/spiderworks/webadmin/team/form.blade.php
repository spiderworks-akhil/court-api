
@extends('spiderworks.webadmin.fileupload')

@section('head')
@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT TEAM MEMBER</span>
            @else
                <span class="page-heading">CREATE NEW TEAM MEMBER</span>
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
                        <a @if($tab == 'basic') class="active show" @endif data-toggle="tab" role="tab"
                           data-target="#tab1Basic"
                        href="#" aria-selected="true">Basic Details</a>
                    </li>
                    <li class="nav-item">
                        <a @if($tab == 'social-media') class="active show" @endif data-toggle="tab" role="tab"
                           data-target="#tab2SocialMedia"
                        class="" aria-selected="false">Social Media</a>
                    </li>
                    <li class="nav-item">
                        <a @if($tab == 'seo') class="active show" @endif data-toggle="tab" role="tab"
                           data-target="#tab2Content"
                        class="" aria-selected="false">SEO</a>
                    </li>
                    <li class="nav-item">
                        <a @if($tab == 'media') class="active show" @endif data-toggle="tab" role="tab"
                           data-target="#tab3SEO"
                        class="" aria-selected="false">Media</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if($tab == 'basic') active show @endif" id="tab1Basic">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control @if(!$obj->id) copy-name @endif" value="{{$obj->name}}" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label class="">Slug (for url)</label>
                                        <input type="text" name="slug" class="form-control" value="{{$obj->slug}}" id="slug">
                                    </div>
                                    <p class="hint-text small">The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Heading</label>
                                        <input type="text" name="title" class="form-control" value="{{$obj->title}}" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Priority</label>
                                        <input type="text" name="priority" class="form-control numeric" value="{{$obj->priority}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Department</label>
                                            <select name="department_id" class="full-width js-location-tags">
                                                <option value="">Select Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{$department->id}}" @if($obj->department_id == $department->id) selected="selected" @endif>{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Designation</label>
                                        <input type="text" name="designation" class="form-control" value="{{$obj->designation}}" required="" id="designation">
                                    </div>
                                </div>
                            </div>
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
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Summary</label>
                                        <textarea class="form-control" name="short_description" rows="3">{{$obj->short_description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Description</label>
                                            <textarea name="content" class="form-control richtext" id="description">{{$obj->content}}</textarea>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($tab == 'social-media') active show @endif" id="tab2SocialMedia">
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Facebook</label>
                                            <input type="text" name="facebook_link" class="form-control" value="{{$obj->facebook_link}}" required="" id="facebook_link">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Twitter</label>
                                            <input type="text" name="twitter_link" class="form-control" value="{{$obj->twitter_link}}" required="" id="twitter_link">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Instagram</label>
                                            <input type="text" name="instagram_link" class="form-control" value="{{$obj->instagram_link}}" required="" id="instagram_link">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>LinkedIn</label>
                                            <input type="text" name="linkedin_link" class="form-control" value="{{$obj->linkedin_link}}" required="" id="linkedin_link">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Youtube</label>
                                            <input type="text" name="youtube_link" class="form-control" value="{{$obj->youtube_link}}" required="" id="youtube_link">
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($tab == 'seo') active show @endif" id="tab2Content">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Top Description</label>
                                            <textarea name="top_description" class="form-control richtext" id="top_description" >{{$obj->top_description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Bottom Description</label>
                                            <textarea name="bottom_description" class="form-control richtext" id="bottom_description">{{$obj->bottom_description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Browser Title</label>
                                            <input type="text" name="browser_title" class="form-control" value="{{$obj->browser_title}}" required="" id="browser_title">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Meta Description</label>
                                            <textarea class="form-control" name="meta_description" rows="3">{{$obj->meta_description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Meta Keywords</label>
                                            <textarea class="form-control" name="meta_keywords" rows="3">{{$obj->meta_keywords}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>Extra Js</label>
                                            <textarea class="form-control" name="extra_js" rows="3">{{$obj->extra_js}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label class="">Extra Js</label>
                                            <textarea name="extra_js" class="form-control" rows="3" id="extra_js">{{$obj->extra_js}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label>OG Title</label>
                                            <input type="text" class="form-control" name="og_title" id="og_title" value="{{$obj->og_title}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label class="">OG Description</label>
                                            <textarea name="og_description" class="form-control" rows="3" id="og_description">{{$obj->og_description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <p class="col-md-12">OG Image</p>
                                        <div class="default-image-holder padding-5">
                                            <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId_og_image"><i class="fa  fa-times-circle"></i></a>
                                            <a href="{{route('spiderworks.webadmin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'_og_image', 'related_id'=>$obj->id])}}" class="webadmin-open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder_og_image">
                                              @if($obj->og_image_id && $obj->og_image)
                                                <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->og_image->thumb_file_path) }}">
                                              @else
                                                <img class="card-img-top padding-20" src="{{asset('webadmin/img/add_image.png')}}">
                                              @endif
                                            </a>
                                            <input type="hidden" name="og_image_id" id="mediaId_og_image" value="{{$obj->og_image_id}}">
                                        </div>
                                  </div>
                                </div>
                        </div>
                    </div>
                    <div class="tab-pane @if($tab == 'media') active show @endif" id="tab3SEO">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">Featured Image</p>
                                    <div class="default-image-holder padding-5">
                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId_featured_image"><i class="fa  fa-times-circle"></i></a>
                                        <a href="{{route('spiderworks.webadmin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'_featured_image', 'related_id'=>$obj->id])}}" class="webadmin-open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder_featured_image">
                                          @if($obj->featured_image_id && $obj->featured_image)
                                            <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->featured_image->thumb_file_path) }}">
                                          @else
                                            <img class="card-img-top padding-20" src="{{asset('webadmin/img/add_image.png')}}">
                                          @endif
                                        </a>
                                        <input type="hidden" name="featured_image_id" id="mediaId_featured_image" value="{{$obj->featured_image_id}}">
                                    </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <p class="col-md-12">Banner Image</p>
                                    <div class="default-image-holder padding-5">
                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId_banner_image"><i class="fa  fa-times-circle"></i></a>
                                        <a href="{{route('spiderworks.webadmin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'_banner_image', 'related_id'=>$obj->id])}}" class="webadmin-open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder_banner_image">
                                          @if($obj->banner_image_id && $obj->banner_image)
                                            <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->banner_image->thumb_file_path) }}">
                                          @else
                                            <img class="card-img-top padding-20" src="{{asset('webadmin/img/add_image.png')}}">
                                          @endif
                                        </a>
                                        <input type="hidden" name="banner_image_id" id="mediaId_banner_image" value="{{$obj->banner_image_id}}">
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
              rules: {
                "name": "required",
                slug: {
                  required: true,
                  remote: {
                      url: "{{url('webadmin/validation/unique-slug')}}",
                      data: {
                        id: function() {
                          return $( "#inputId" ).val();
                        },
                        table: 'team',
                    }
                  }
                },
              },
              messages: {
                "name": "Service name cannot be blank",
                "slug": {
                    required: "Slug cannot be blank",
                    remote: "Slug already in use"
                },
              },
            });

        $(function(){
            $(".js-location-tags").select2({
              tags: true
            });
        })
    </script>
@parent
@endsection