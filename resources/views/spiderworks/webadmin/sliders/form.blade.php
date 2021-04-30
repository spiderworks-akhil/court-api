@extends('spiderworks.webadmin.fileupload')

@section('head')
    @parent
    <link rel="stylesheet" href="{{ asset('webadmin/assets/cropper/css/cropper.css')}}">
    <link rel="stylesheet" href="{{ asset('webadmin/assets/cropper/css/main.css')}}">
    <style>
        .page-sidebar{
            z-index: 999 !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">


            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">Edit Slider</span>
            </div>
            <!-- START card -->
            <div class="card card-borderless filter-wrap">
                <form method="POST" action="{{ route($route.'.update', [encrypt($obj->id)]) }}" class="p-t-15" id="SliderFrm" data-validate=true>
                  @csrf
                  <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">
                <div class="row m-2">
                    <div class="col-md-12">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default required">
                                <label>Slider Name</label>
                                <input type="text" name="slider_name" class="form-control" value="{{$obj->slider_name}}" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default required">
                                <label>Width</label>
                                <input type="text" name="width" class="form-control" value="{{$obj->width}}" maxLength="4" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row column-seperation padding-5">
                            <div class="form-group form-group-default required">
                                <label>Height</label>
                                <input type="text" name="height" class="form-control" value="{{$obj->height}}" maxLength="4" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" align="right">
                            <a href="{{route('spiderworks.webadmin.media.popup', ['popup_type'=>'sliders-'.$obj->id, 'type'=>'Image'])}}" class="webadmin-open-ajax-popup btn btn-primary" title="Media Images" data-popup-size="large"><i class="fa fa-plus-sign"></i> Add Photos</a>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route($route.'.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="card card-borderless padding-15">
                    <div class="row" id="photoList">
                        @include('spiderworks.webadmin.sliders.ajax_photos', ['photos'=>$obj->photos, 'slider'=>$obj->id, 'type'=>$type])
                    </div>
            </div>
            <!-- END card -->

    </div>
@endsection
@section('bottom')

    <script src="{{ asset('webadmin/assets/cropper/js/common.js')}}"></script>
    <script src="{{ asset('webadmin/assets/cropper/js/cropper.js')}}"></script>
    <script src="{{ asset('webadmin/assets/cropper/js/jquery-cropper.js')}}"></script>

    <script type="text/javascript">
        var validator = $('#SliderFrm').validate({
            ignore: [],
            rules: {
                "width": "required",
                "height": "required",
                slider_name: {
                  required: true,
                  remote: {
                      url: "{{route('spiderworks.webadmin.sliders.unique-name')}}",
                      data: {
                        id: function() {
                          return $( "#inputId" ).val();
                        },
                    }
                  }
                },
              },
              messages: {
                "width": "Slider width cannot be blank",
                "height": "Slider height cannot be blank",
                slider_name: {
                  required: "Slider name cannot be blank",
                  remote: "Slider name is already in use",
                },
              },
            });
    </script>
    @parent
@endsection