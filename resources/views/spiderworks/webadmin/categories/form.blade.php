@extends('spiderworks.webadmin.fileupload')

@section('head')

@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT CATEGORY</span>
            @else
                <span class="page-heading">CREATE NEW CATEGORY</span>
            @endif
            <div >
                <div class="btn-group">
                    <a href="{{route($route.'.index', [$parent])}}"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    @if($obj->id)
                        <a href="{{route($route.'.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                        </a>
                        @if(count($obj->children) == 0)
                            <a href="{{route($route.'.destroy', [encrypt($obj->id)])}}" class="btn btn-success webadmin-btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{route($route.'.index', [$obj->parent_id])}}"><i class="fa fa-trash"></i> Delete</a>
                        @endif
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
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab2Content"
                        class="" aria-selected="false">Content</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab3SEO"
                        class="" aria-selected="false">SEO</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab"
                           data-target="#tab4Media"
                           class="" aria-selected="false">Media</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active show" id="tab1Basic">
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
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Category Type</label>
                                            <select name="category_type" class="full-width webadmin-select2-input" data-placeholder="Select a Category Type">
                                                <option value="">-- No Category Type --</option>
                                                <option value="Events" @if($obj->category_type == 'Events') selected="selected" @endif>Events</option>
                                                <option value="Blogs" @if($obj->category_type == 'Blogs') selected="selected" @endif>Blogs</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Parent Category</label>
                                            <select name="parent_id" class="full-width webadmin-select2-input" data-placeholder="Select a Parent Category">
                                                <option value="0">-- No Parent --</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" @if($category->id == $parent) selected="selected" @endif>{{$category->name}}</option>
                                                    @include('spiderworks.webadmin._partials.category', ['category'=>$category, 'depth'=>1, 'selected'=>$parent])
                                                @endforeach
                                            </select>
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
                            <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">FAQ</label>
                                            <select name="faq_id" class="full-width webadmin-select2-input" data-select2-url="{{route('spiderworks.webadmin.select2.faq')}}" data-placeholder="Select a FAQ">
                                                @if($obj->faq)
                                                    <option value="{{$obj->faq->id}}" selected="selected">{{$obj->faq->name}}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Short Description</label>
                                        <textarea name="short_description" class="form-control" rows="3" id="short_description">{{$obj->short_description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default required">
                                        <label>Content</label>
                                        <textarea name="content" class="form-control richtext" id="content">{{$obj->content}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2Content">
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default required">
                                            <label>Top content</label>
                                            <textarea name="top_description" class="form-control richtext" id="top_description">{{$obj->top_description}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default required">
                                            <label>Bottom content</label>
                                            <textarea name="bottom_description" class="form-control richtext" id="bottom_description">{{$obj->bottom_description}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default">
                                            <label class="">Extra Css</label>
                                            <textarea name="extra_css" class="form-control" rows="3" id="extra_css">{{$obj->extra_css}}</textarea>
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
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3SEO">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label>Browser title</label>
                                        <input type="text" class="form-control" name="browser_title" id="browser_title" value="{{$obj->browser_title}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Meta Keywords</label>
                                        <textarea name="meta_keywords" class="form-control" rows="3" id="meta_keywords">{{$obj->meta_keywords}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row column-seperation padding-5">
                                    <div class="form-group form-group-default">
                                        <label class="">Meta description</label>
                                        <textarea name="meta_description" class="form-control" rows="3" id="meta_description">{{$obj->meta_description}}</textarea>
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
                    <div class="tab-pane" id="tab4Media">
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
            ignore: [],
            rules: {
                "name": "required",
                "title": "required",
                slug: {
                  required: true,
                  remote: {
                      url: "{{url('webadmin/validation/unique-slug')}}",
                      data: {
                        id: function() {
                          return $( "#inputId" ).val();
                        },
                        table: 'categories',
                    }
                  }
                },
              },
              messages: {
                "name": "Blog name cannot be blank",
                "title": "Blog heading cannot be blank",
                slug: {
                  required: "Slug cannot be blank",
                  remote: "Slug is already in use",
                },
              },
            });
    </script>
@parent
@endsection