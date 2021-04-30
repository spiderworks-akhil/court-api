@extends('spiderworks.webadmin.fileupload')
@section('head')
  <style type="text/css">
    .thumbnail .delete-btn{
      right: 0 !important;
    }
    .thumbnail .bulk-selet-media{
      left: 10px !important;
    }
  </style>
@endsection
@section('content')
    <div class="container-fluid">
            <!-- START card -->

        <div class="box-header with-border">
            <div class="upload-wrapper">
                <div id="error_output"></div>
                <!-- file drop zone -->
                <div id="dropzone" class="dropzone-wrapper">
                    <i>Drop files here</i>
                    <i class="sm-text">or</i>
                    <!-- upload button -->
                    <span class="button btn-blue input-file">
                                  Browse Files <input type="file" id="fileupload" name="files[]" data-url="{{ route('spiderworks.webadmin.media.save')}}" multiple />
                              </span>
                </div>
                <input type="hidden" id="popupType" value="main">
                <!-- The container for the uploaded files -->
            </div>
        </div>




        <div class="card card-borderless padding-15">
                    <!-- Default box -->



                <div class="box">
                  <div class="box-body">
                      <div id="files" class="files col-md-12"></div>
                      <div class="media-list-head row">
                        <div class="col-md-6">
                          <a href="javascript:void(0);" class="btn btn-danger bulk-select">Bulk Select</a>
                          <div class="bulk-delete-action" style="display: none;">
                            <a href="javascript:void(0);" class="btn btn-danger bulk-select-delete">Delete Selected</a>
                            <a href="javascript:void(0);" class="btn btn-default bulk-select-cancel">Cancel</a>
                          </div>
                        </div>
                        <div class="col-md-6 text-right">
                          <label>
                            <input class="form-control input-sm" placeholder="Search..." aria-controls="datatable" type="search" id="mediaSearchInput">
                          </label>
                        </div>
                      </div>
                      <div class="row" id="mediaList">
                        @include('spiderworks.webadmin.media.ajax_index', ['files'=>$files])
                      </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                  </div><!-- /.box-footer-->
                </div><!-- /.box -->
            </div>
            <!-- END card -->
    </div>
@endsection
@section('bottom')

    <script>
      var my_columns = [];
      var slno_i = 0;
      var order = [];

      $(function(){
        $(document).on('click', '.media-nav .pagination .page-link', function(e){
              e.preventDefault();
              var loadurl = $(this).attr('href');
              var targ = $('#mediaList');
              if(loadurl != 'undefined'){
                  targ.load(loadurl, function(){
                    $('#ajaxUrl').val(loadurl);
                    $('.bulk-select-delete').parent().hide();
                    $('.bulk-select').show();
                  });
              }
          });

          $(document).on('keyup', '#mediaSearchInput', function(e){
            var req = $(this).val();
            var loadurl = "{{url('admin/media')}}";
            $.ajax({
               url: loadurl,
               data: {req: req}, // serializes the form's elements.
               success: function(data)
               {
                  $('#mediaList').html(data);
                  $('.bulk-select-delete').parent().hide();
                  $('.bulk-select').show();
               }
             });
          });

          $(document).on('click', '.media-delete', function(e){
              e.preventDefault();
              var id = $(this).attr('data-id');
              var req = $('#mediaSearchInput').val();
              var page = $('#currentPage').val();
              var loadurl = $(this).attr('href');
              $.confirm({
                title: 'Warning',
                content: "Are you sure?",
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'ok_button': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function(){
                            var obj = this;
                            obj.buttons.ok_button.setText('Processing..'); // setText for 'hello' button
                            obj.buttons.ok_button.disable();
                            $.post(loadurl, {req: req, page: page, id: id, action: 'delete', '_token':'{{csrf_token()}}' }).done(function(data){
                              obj.$$close_button.trigger('click');
                              $('#mediaList').html(data);
                              $('.bulk-select-delete').parent().hide();
                              $('.bulk-select').show();
                            });
                            return false;
                        }
                    },
                    close_button: {
                          text: 'Cancel',
                          action: function () {
                        }
                    },
                }
            });
          });

          $(document).on('click', '.bulk-select', function(){
              $('.parent .bulk-selet-media').each(function(){
                $(this).show();
                $(this).siblings('.media-delete').hide();
              });
              $(this).hide();
              $('.bulk-delete-action').show();
          });

          $(document).on('click', '.bulk-select-cancel', function(){
              $('.parent .bulk-selet-media').each(function(){
                $(this).hide();
                $(this).siblings('.media-delete').show();
              });
              $(this).parent().hide();
              $('.bulk-select').show();
          });

          $(document).on('click', '.bulk-select-delete', function(){
              var req = $('#mediaSearchInput').val();
              var page = $('#currentPage').val();
              var loadurl = "{{route($route.'.index.post')}}";
              var ids = [];
              $("input:checked").each(function () {
                  var id = $(this).val();
                  ids.push(id);
              });
              if(ids != '')
              {

                $.confirm({
                    title: 'Warning',
                    content: "Are you sure?",
                    closeAnimation: 'scale',
                    opacity: 0.5,
                    buttons: {
                        'ok_button': {
                            text: 'Proceed',
                            btnClass: 'btn-blue',
                            action: function(){
                                var obj = this;
                                obj.buttons.ok_button.setText('Processing..'); // setText for 'hello' button
                                obj.buttons.ok_button.disable();
                                $.post(loadurl, {req: req, page: page, ids: ids, action: 'bulk_delete', '_token':'{{csrf_token()}}' }).done(function(data){
                                  obj.$$close_button.trigger('click');
                                  $('#mediaList').html(data);
                                  $('.bulk-select-delete').parent().hide();
                                  $('.bulk-select').show();
                                });
                                return false;
                            }
                        },
                        close_button: {
                              text: 'Cancel',
                              action: function () {
                            }
                        },
                    }
                });
              }
              else{
                $.alert("Select an item to delete");
              }
          });
    });
    </script>
    @parent
@endsection