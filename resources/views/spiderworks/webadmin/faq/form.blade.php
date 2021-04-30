@extends('spiderworks.webadmin.fileupload')

@section('head')
    <style type="text/css">
        #add-more-faq{
            padding: 20px;
            border: 1px solid #ddd;
            text-align: center;
            margin: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT FAQ</span>
            @else
                <span class="page-heading">CREATE NEW FAQ</span>
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
<ul class="nav nav-tabs nav-tabs-simple d-none d-md-flex d-lg-flex d-xl-flex" role="tablist" data-init-reponsive-tabs="dropdownfx">
    <li class="nav-item">
        <a class="active show" data-toggle="tab" role="tab"
        data-target="#tab1Basic"
        href="#" aria-selected="true">FAQ</a>
    </li>
 
</ul>
<div class="tab-content">
    <div class="tab-pane active show" id="tab1Basic">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                     @if($obj->id)
                     <?php
                              $id = array($obj->id);
                            ?>
                    <form role="form" method="post"  action="{{URL::to('admin/faq/update', $obj->id)}}">
                         @else
                            <?php
                              $id = array();
                            ?>
                            <form role="form" method="post"  action="{{URL::to('admin/faq/store')}}">
                            @endif
                        @csrf
                        <input type="hidden" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId" >
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="row column-seperation padding-5">
                                        <div class="form-group form-group-default required">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" value="{{$obj->name}}" required="">
                                        </div>
                                    </div>
                                </div>

                        <div class="row" id="box">
                             @php
                                        if($obj->id)
                                            $count = count($obj->question_answers);
                                        else
                                            $count = 0;
                                    @endphp
                           @if(count($obj->question_answers)>0)     
                                        @foreach ($obj->question_answers as $key => $value) 
                                        <div class="row w-100 mb-2 descriptionwrapper" >
                                            <div class="col-md-4">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default">
                                                        <label>Display Order</label>
                                                        <input type="number" name="faq[{{$key}}][display_order]" class="form-control numeric" value="{{$value->display_order}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default">
                                                        <label>Question</label>
                                                        <textarea name="faq[{{$key}}][question]" class="form-control">{{$value->question}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row column-seperation padding-5">
                                                    <div class="form-group form-group-default">
                                                        <label>Answer</label>
                                                        <textarea name="faq[{{$key}}][answer]" class="form-control richtext">{{$value->answer}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-right"><div class="form-group "><button type="button" class="btn btn-danger btn-sm remove" >Remove</button></div></div>
                                        </div>  
                            @endforeach
                            @endif
                              <div class="row w-100 mb-2 descriptionwrapper" >
                                    <div class="col-md-4">
                                        <div class="row column-seperation padding-5">
                                            <div class="form-group form-group-default">
                                                <label>Display Order</label>
                                                <input type="number" name="faq[{{$count}}][display_order]" class="form-control numeric"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row column-seperation padding-5">
                                            <div class="form-group form-group-default">
                                                <label>Question</label>
                                                <textarea name="faq[{{$count}}][question]" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row column-seperation padding-5">
                                            <div class="form-group form-group-default">
                                                <label>Answer</label>
                                                <textarea name="faq[{{$count}}][answer]" class="form-control richtext"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>  
                            </div>
                        </div>
                 

  <div class="row">
                                <div class="col align-self-end" id="add-more-faq">
                                    <button type="button" name="add" id="add" class="btn btn-success" >Add More</button>
                                </div>
                            </div>


                        <!--<button class="btn btn-success" type="submit">Submit</button>-->
                             <button type="submit" class="float-right btn btn-success">Save</button>
                    </form>
                </div>
                <br>
            </div>
        </div>
    </div>


</div>
</div>
        </div>
    </div>
@endsection
@section('bottom')
    <script type="text/javascript">
        var validator = $('#PageFrm').validate({
            ignore: [],
            rules: {
                "name": "required",
              },
              messages: {
                "name": "Page title cannot be blank",
              },
            });
            
            
        var i = '{{$count}}';
        $("#add").click(function(){
            i++;
            $("#box").append('<div class="row w-100 mb-2 descriptionwrapper" ><div class="col-md-4"><div class="row column-seperation padding-5"><div class="form-group form-group-default"><label>Display Order</label><input type="number" name="faq['+i+'][display_order]" class="form-control numeric"/></div></div></div><div class="col-md-8"><div class="row column-seperation padding-5"><div class="form-group form-group-default"><label>Question</label><textarea name="faq['+i+'][question]" class="form-control"></textarea></div></div></div><div class="col-md-12"><div class="row column-seperation padding-5"><div class="form-group form-group-default"><label>Answer</label><textarea name="faq['+i+'][answer]" class="form-control richtext"></textarea></div></div></div><div class="col-md-12 text-right"><div class="form-group "><button type="button" class="btn btn-danger btn-sm remove" >Remove</button></div></div></div>');
            $('.richtext').summernote({
                callbacks: {
                    onImageUpload: function(files) {
                        that = $(this);
                        sendFile(files[0], that, image_upload_url);
                    }
                }
            });
        });

$(document).on('click', '.remove', function(){  
$(this).parents('.descriptionwrapper').remove();
}); 
$(document).on('click', '.delete', function(){  
$(this).parents('.delete').remove();
}); 
    </script>
@parent
@endsection