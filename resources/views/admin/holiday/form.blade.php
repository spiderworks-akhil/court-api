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
                <span class="page-heading">EDIT Holiday details</span>
            @else
                <span class="page-heading">CREATE NEW Holiday</span>
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
                                                        <label for="">Is booking open for Holiday?</label>
                                                        <select name="is_business_open" class="form-control">
                                                            <option value="1" @if($obj->is_business_open == 1) selected @endif>Yes</option>
                                                            <option value="0" @if($obj->is_business_open == 0) selected @endif>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8"><br></div>



                                            <div class="col-md-6">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default required">
                                                        <label>Holiday name</label>
                                                        <input type="text" name="name" class="form-control" value="{{$obj->name}}" required="" id="title">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default">
                                                        <label>Holiday Date</label>
                                                        <input type="date" name="date" class="form-control" id="address" value="{{$obj->date}}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default required">
                                                        <label>Surcharge</label>
                                                        <input type="text" name="surcharge" class="form-control" value="{{$obj->surcharge}}" required="" id="title">
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