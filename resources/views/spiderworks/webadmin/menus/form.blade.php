@extends('spiderworks.webadmin.fileupload')

@section('head')
@endsection

@section('content')
    <div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            @if($obj->id)
                <span class="page-heading">EDIT MENU</span>
            @else
                <span class="page-heading">Create NEW MENU</span>
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
                    <form method="POST" action="{{ route($route.'.update') }}" class="p-t-15" id="MenuFrm" data-validate=true>
                @else
                    <form method="POST" action="{{ route($route.'.store') }}" class="p-t-15" id="MenuFrm" data-validate=true>
                @endif
                @csrf
                <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row column-seperation padding-5">
                                <div class="form-group form-group-default required">
                                    <label>Menu name</label>
                                    <input type="text" name="name" class="form-control" value="{{$obj->name}}" required="">
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row column-seperation padding-5">
                                <div class="form-group form-group-default form-group-default-select2 required">
                                  <label>Menu Position</label>
                                  <select name="position" class="full-width webadmin-select2-input">
                                    <option value="Header" @if($obj->position == 'Header') selected="selected" @endif>Header</option>
                                    <option value="Side Menu" @if($obj->position == 'Side Menu') selected="selected" @endif>Side Menu</option>
                                    <option value="Side Menu Footer" @if($obj->position == 'Side Menu Footer') selected="selected" @endif>Side Menu Footer</option>
                                    <option value="Footer" @if($obj->position == 'Footer') selected="selected" @endif>Footer</option>
                                    <option value="Footer2" @if($obj->position == 'Footer2') selected="selected" @endif>Footer2</option>
                                    <option value="Mobile Header" @if($obj->position == 'Mobile Header') selected="selected" @endif>Mobile Header</option>
                                    <option value="Mobile Footer" @if($obj->position == 'Mobile Footer') selected="selected" @endif>Mobile Footer</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row column-seperation padding-5">
                                <div class="form-group form-group-default">
                                    <label>Menu Title</label>
                                    <input type="text" name="title" class="form-control" value="{{$obj->title}}" >
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                        <p class="col-md-12">Menu Settings ( Select and add menus to right )  </p> 
                            <div class="col-md-4"> 
                              <div class="custom-accordion">
                                <div class="accord-header">Pages<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content accord-on">
                                  @if($pages)
                                      {!! $pages !!}
                                    <p class="text-right">
                                      <button type="button" id="add-page-links" class="btn btn-primary btn-sm add-links">Add to Menu</button>
                                    </p>
                                  @endif
                                </div>
                                <div class="accord-header">Internal Links<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content">
                                  @if($front_pages)
                                        {!! $front_pages !!}
                                      <p class="text-right">
                                        <button type="button" id="add-internal-links" class="btn btn-primary btn-sm add-links">Add to Menu</button>
                                      </p>
                                  @endif
                                </div>
                                <div class="accord-header">Categories<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content">
                                  @if($categories)
                                        {!! $categories !!}
                                      <p class="text-right">
                                        <button type="button" id="add-category-links" class="btn btn-primary btn-sm add-links">Add to Menu</button>
                                      </p>
                                  @endif
                                </div>
                                <div class="accord-header">Custom Links<span class="pull-right fa fa-angle-down toggle-arraow"></span></div>
                                <div class="accord-content">
                                  <div class="row column-seperation padding-5">
                                      <div class="form-group form-group-default required">
                                          <label>Link Text</label>
                                          <input type="text" name="custom_link_text" class="form-control" id="inputCustomLinkText">
                                      </div>
                                  </div>
                                  <div class="row column-seperation padding-5">
                                      <div class="form-group form-group-default required">
                                          <label>Url</label>
                                          <input type="text" name="custom_url" class="form-control" id="inputCustomUrl">
                                      </div>
                                  </div>
                                  <div class="row column-seperation padding-5">
                                    <div class="checkbox">
                                      <input type="checkbox" id="inputTarget"><label for="inputTarget"> New Window</label>
                                    </div>
                                  </div>
                                  <div class="row column-seperation padding-5 text-right">
                                      <button type="button" id="add-custom-links" class="btn btn-primary btn-sm">Add to Menu</button>
                                  </div>
                                </div>
                              </div> 
                            </div>
                            <div class="col-md-8">
                              <div class="dd">
                                  <ol class="dd-list custom-accordion-menu">
                                    @if($obj->id && $obj->menu_items)
                                      @include('spiderworks.webadmin._partials.menu_items', ['items'=>$obj->menu_items])
                                    @endif
                                  </ol>
                              </div>
                              <input type="hidden" name="menu_settings" id="inputMenuSettings">
                              <span class="error"></span>
                            </div>
                            <div class="col-md-12">
                              <div class="btn-holder text-right">
                                  <button type="button" class="btn btn-primary m-2" id="save-btn">Save</button>
                              </div>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('bottom')
    <script src="{{ asset('webadmin/js/jquery.nestable.js')}}"></script> 
    <script type="text/javascript">
        $(document).ready(function(){
            $('.dd').nestable({ 
                expandBtnHTML: '',
                collapseBtnHTML: ''
              });
            var validator = $("#MenuFrm").validate({
                ignore: [],
                errorPlacement: function(error, element){
                    $(element).each(function (){
                        $(this).parent('div').find('span.error').html(error);
                    });
                },
                rules: {
                  name: "required",
                  menu_settings: "required",
                },
                messages: {
                  name: "Enter menu name",
                  menu_settings: "Setup a menu using menu settings",
                },
              });

            $(document).on('click', '#save-btn', function(){
              if($('.dd').nestable('serialize') != '')
                $('#inputMenuSettings').val(JSON.stringify($('.dd').nestable('serialize')));
              if($("#MenuFrm").valid())
              {
                $('#MenuFrm').submit();
              }
            })

            $(document).on('click', '#add-custom-links', function(){
                var name = $('#inputCustomLinkText').val();
                var url = $('#inputCustomUrl').val();
                if(name != '' && url != '')
                {
                    $('#inputCustomLinkText').removeClass('errorBox');
                    $('#inputCustomUrl').removeClass('errorBox');
                    var id = 'custom_link-'+name;
                    var target_blank = 0;
                    var checked = "";
                    if($("#inputTarget").is(":checked"))
                    {
                      target_blank = 1
                      checked = "checked";
                    }
                    var inner_html = '<div class="dd-handle accord-header"><span class="menu-title">'+name+'</span><span class="pull-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div><div class="accord-content"><div class="form-group required"><label class="control-label" for="inputCode">Navigation Label</label><input type="text" name="menu['+id+'][text]" class="form-control menu-title-input" value="'+name+'"/></div><div class="form-group required"><label class="control-label" for="inputCode">Url</label><input type="text" name="menu['+id+'][url]" class="form-control" value="'+url+'"/></div><div class="form-group required"><div class="checkbox"><input type="checkbox" name="menu['+id+'][target_blank]" '+checked+' id="target-'+id+'"/><label for="target-'+id+'"> New Window</label></div></div><input type="hidden" name="menu['+id+'][menu_nextable_id]" value="'+id+'"/><input type="hidden" name="menu['+id+'][original_title]" value="'+name+'"/><p class="menu-original-text"> Original: '+name+'</p><p><a href="javascript:void(0)" class="remove-menu">Remove</a></p></div>';
                    var html = '<li class="dd-item" data-id="'+id+'">'+inner_html+'</li>';
                    $('.dd > .dd-list').append(html);
                    $('input').iCheck({
                      checkboxClass: 'icheckbox_square-blue',
                      radioClass: 'iradio_square-blue',
                      increaseArea: '20%' // optional
                    });
                    $('.dd').nestable();
                    $('#inputCustomLinkText').val('');
                    $('#inputCustomUrl').val('');
                    $("#inputTarget").iCheck('uncheck');
                }
                else{
                  if(name == "")
                    $('#inputCustomLinkText').addClass('errorBox');
                  else
                    $('#inputCustomLinkText').removeClass('errorBox');

                  if(url == "")
                    $('#inputCustomUrl').addClass('errorBox');
                  else
                    $('#inputCustomUrl').removeClass('errorBox');
                }
            });

            $(document).on('click', '.add-links', function(){
                var id = $(this).attr('id');
                var link_class = ''
                if(id == 'add-page-links')
                  link_class = 'page_links';
                else if(id == 'add-internal-links')
                  link_class = 'frontpage_links';
                else if(id == 'add-category-links')
                  link_class = 'category_links';


                $("."+link_class+":checked").each(function () {
                    var id = $(this).val();
                    var name = $(this).attr('data-name');
                    var inner_html = '<div class="dd-handle accord-header"><span class="menu-title">'+name+'</span><span class="pull-right fa fa-angle-down toggle-arraow dd-nodrag"></span></div><div class="accord-content"><div class="form-group required"><label class="control-label" for="inputCode">Navigation Label</label><input type="text" name="menu['+id+'][text]" class="form-control menu-title-input" value="'+name+'"/><input type="hidden" name="menu['+id+'][id]" value="'+$(this).attr('data-id')+'"/><input type="hidden" name="menu['+id+'][menu_nextable_id]" value="'+id+'"/></div><p class="menu-original-text"> Original: '+name+'</p><p><a href="javascript:void(0)" class="remove-menu">Remove</a></p></div>';
                    var html = '<li class="dd-item" data-id="'+id+'">'+inner_html+'</li>';
                    $('.dd > .dd-list').append(html);
                    $('.dd').nestable();
                    $(this).prop('checked', false);
                });
            });

            $(document).on('click', '.custom-accordion .accord-header', function(){
                if($(this).next("div").is(":visible")){
                  $(this).next("div").slideUp("slow");
                  $(this).find('.toggle-arraow').removeClass('fa-angle-up').addClass('fa-angle-down');
                } else {
                  $(".custom-accordion .accord-content").slideUp("slow");
                  $('.toggle-arraow').each(function(i, e) {
                    $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
                  });
                  $(this).next("div").slideToggle("slow");
                  $(this).find('.toggle-arraow').addClass('fa-angle-up').removeClass('fa-angle-down');
                }
            });

            $(document).on('click', '.custom-accordion-menu .accord-header', function(){
                if($(this).next("div").is(":visible")){
                  $(this).next("div").slideUp("slow");
                  $(this).find('.toggle-arraow').removeClass('fa-angle-up').addClass('fa-angle-down');
                } else {
                  $(".custom-accordion-menu .accord-content").slideUp("slow");
                  $('.toggle-arraow').each(function(i, e) {
                    $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
                  });
                  $(this).next("div").slideToggle("slow");
                  $(this).find('.toggle-arraow').addClass('fa-angle-up').removeClass('fa-angle-down');
                }
            });

            $(document).on('click', '.remove-menu', function(){
              $(this).parents('.accord-content').parent().remove();
              $('.dd').nestable();
            });

            $(document).on('keyup', '.menu-title-input', function(){
              $(this).parents('.accord-content').siblings('.accord-header').find('.menu-title').html($(this).val());
            })
        
          });
    </script>
@parent
@endsection