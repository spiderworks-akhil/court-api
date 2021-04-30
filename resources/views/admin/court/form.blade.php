@extends('spiderworks.webadmin.fileupload')

@section('head')
    <style>
        .remove-image{
            color: red;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        @php $tab = 'basic'; @endphp
        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT Project</span>
            @else
                <span class="page-heading">CREATE NEW Project</span>
            @endif
            <div >
                <div class="btn-group">
                    <a href="{{route($route.'.index')}}"  class="btn btn-success"><i class="fa fa-list"></i> List
                    </a>
                    @if($obj->id)
                        <a href="{{route($route.'.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                        </a>
                        <a href="{{route($route.'.destroy', [encrypt($obj->id)])}}" class="btn btn-success miniweb-btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." data-redirect-url="{{route($route.'.index')}}"><i class="fa fa-trash"></i> Delete</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">
                @if($obj->id)
                    <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="InputFrm" data-validate=true enctype="multipart/form-data">
                        @else
                            <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="InputFrm" data-validate=true enctype="multipart/form-data">
                                @endif
                                @csrf
                                <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">


                                <div class="tab-content">
                                    <div class="tab-pane @if($tab == 'basic') active show @endif" id="tab1Basic">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default">
                                                        <label for="">Should we show this item in website?</label>
                                                        <select name="status" class="form-control">
                                                            <option value="1" @if($obj->status == 1) selected @endif>Yes</option>
                                                            <option value="0" @if($obj->status == 0) selected @endif>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-md-6">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default required">
                                                        <label>Name of this court</label>
                                                        <input type="text" name="name" class="form-control" value="{{$obj->name}}" required="" id="title">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default">
                                                        <label>tagline</label>
                                                        <textarea name="tagline" class="form-control" id="address">{{$obj->tagline}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default">
                                                        <label>features</label>
                                                        <textarea name="features" class="form-control" id="map" rows="5">{{$obj->features}}</textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default">
                                                        <label>location</label>
                                                        <textarea name="location" class="form-control" id="map" rows="5">{{$obj->location}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <p class="col-md-12">Court Image</p>
                                                    <div class="default-image-holder padding-5">
                                                        <a href="javascript:void(0);" class="image-remove" data-remove-id="mediaId_banner_image"><i class="fa  fa-times-circle"></i></a>
                                                        <a href="{{route('spiderworks.webadmin.media.popup', ['popup_type'=>'single_image', 'type'=>'Image', 'holder_attr'=>'_banner_image', 'related_id'=>$obj->id])}}" class="webadmin-open-ajax-popup" title="Media Images" data-popup-size="large" id="image-holder_banner_image">
                                                            @if($obj->image_id && $obj->image)
                                                                <img class="card-img-top padding-20" src="{{ asset('public/'.$obj->image->thumb_file_path) }}">
                                                            @else
                                                                <img class="card-img-top padding-20" src="{{asset('webadmin/img/add_image.png')}}">
                                                            @endif
                                                        </a>
                                                        <input type="hidden" name="image_id" id="mediaId_banner_image" value="{{$obj->banner_image_id}}">
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12" align="right">              <hr>
                                            @if(empty($obj->id))
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            @else
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            @endif
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
        $("#name").keyup(function () {
            $("#slug").val(slugify($("#name").val()))
        });
        var validator = $('#InputFrm').validate({
            rules: {
                "title": "required",
                slug: {
                    required: true,
                    remote: {
                        url: "{{url('validation/unique-slug')}}",
                        data: {
                            id: function() {
                                return $( "#inputId" ).val();
                            },
                            table: 'clients',
                        }
                    }
                },
            },
            messages: {
                "name": "Client name cannot be blank",
                "slug": {
                    required: "Slug cannot be blank",
                    remote: "Slug already in use"
                },
            },
        });

    </script>

    <script>
        $(function () {
            $( "#sortable1" ).sortable({
                connectWith: ".connectedSortable"
            }).disableSelection();

            var $sortable = $( "#sortable2" ).sortable({
                connectWith: ".connectedSortable",
                update: function (event, ui) {
                    var data = $(this).sortable('toArray');
                    $("#services").val(data);
                }
            }).disableSelection();

            $("#services").val($sortable.sortable("toArray"));
        });
    </script>
    @parent
@endsection