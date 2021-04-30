<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>{{config('app.name')}} - Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    @include('spiderworks.webadmin._partials.styles')
    <link href="{{asset('webadmin/assets/pages/css/pages-icons.css')}}" rel="stylesheet" type="text/css">
    @section('head')
    @show
    <link href="{{asset('webadmin/datatables/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link  href="{{asset('webadmin/assets/pages/css/themes/modern.css')}}" rel="stylesheet" type="text/css" />
    <link  href="{{asset('webadmin/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('webadmin/css/styles.css')}}" rel="stylesheet" type="text/css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap');
        body{
            font-family: 'Roboto', sans-serif;
        }
        .table thead tr th{
            color: #2c2d2f;
        }
        textarea.form-control{
            min-height: 75px !important;
        }
        .dropzone-wrapper {
            margin: 20px 50px;
            border: 2px #d9d9d9 dotted;
            padding: 40px;
            text-align: center;
            background: azure;
            display: block;
        }
        .delete-btn{
            background: red;
            padding: 0px 5px;
            color: white;
            display: block;
            top: 0px;
            right: unset;
        }

        .edit-btn{
            padding: 0px 5px;
            background: green;
            position: absolute;
            color: white;
            display: block;
            left: 20px;
            top:0px;
            right: unset;
        }
        .media-preview-wrap img, .thumbnail img {
            width: 100%;
            height: 100px;
            object-fit: contain;
            border: 1px solid #ddd;
        }
        .attachment-preview {
            width: 150px !important;
            height: 100px !important;
        }

        .table tbody tr td {
            background: #fff;
            border-bottom: 1px solid rgba(225, 225, 226, 0.7);
            border-top: 0px;
            padding: 5px 0px;
            font-size: 13.5px;
        }

        .dataTables_info{
            float: left;
            position: absolute;
            left: 0px;
        }

        @media only screen and (min-width: 768px){
            form .row [class*='col-']:first-child {
                padding-left: 7px;
            }
        }


    </style>
</head>
<body class="fixed-header menu-pin">
<!-- BEGIN SIDEBPANEL-->
@include('spiderworks.webadmin._partials.nav')
<!-- END SIDEBAR -->
<!-- END SIDEBPANEL-->
<!-- START PAGE-CONTAINER -->
<div class="page-container ">
    <!-- START HEADER -->
    <div class="header ">
        <!-- START MOBILE SIDEBAR TOGGLE -->
        <a href="#" class="btn-link toggle-sidebar d-lg-none pg pg-menu" data-toggle="sidebar">
        </a>
        <!-- END MOBILE SIDEBAR TOGGLE -->
        <div class="">
            <div class="brand inline">
                {{config('app.name')}}
            </div>

        </div>
        <div class="d-flex align-items-center">
            <!-- START User Info-->
            <div class="pull-left p-r-10 fs-14 font-heading d-lg-block d-none">
                @auth
                    <span class="semi-bold font-weight-bold">{{Auth::user()->username}}</span>
                    <span class="text-master font-italic">({{Auth::user()->email}})</span>
                @endauth
            </div>
            <div class="dropdown pull-right d-lg-block d-none">
                <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" style="cursor: pointer">
              <span class="thumbnail-wrapper d32  inline">
              <img src="https://img.icons8.com/office/32/000000/user-menu-male--v2.png" alt=""
                   data-src="https://img.icons8.com/office/32/000000/user-menu-male--v2.png"
                   data-src-retina="https://img.icons8.com/office/32/000000/user-menu-male--v2.png" width="32" height="32">
              </span>
                </button>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
                    <a href="{{route('spiderworks.webadmin.change-password')}}" class="dropdown-item"><i class="pg-settings_small"></i> Change Password</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="clearfix bg-master-lighter dropdown-item">
                        <span class="pull-left">Logout</span>
                        <span class="pull-right"><i class="pg-power"></i></span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                       @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END HEADER -->
    <!-- START PAGE CONTENT WRAPPER -->
    <div class="page-content-wrapper ">
        <!-- START PAGE CONTENT -->
        <div class="content ">
            <!-- START JUMBOTRON -->
            <div class="jumbotron page-wrapper" data-pages="parallax">
                @section('spiderworks.webadmin._partials.breadcrumb')
                    @show
            </div>
            <!-- END JUMBOTRON -->
            <!-- START CONTAINER FLUID -->
            <div class=" container-fluid   container-fixed-lg">
                @include('spiderworks.webadmin._partials.notifications')
                @section('content')
                    @show
            </div>
            <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <!-- START CONTAINER FLUID -->
        <div class=" container-fluid  container-fixed-lg footer">
            <div class="copyright sm-text-center">
                <p class="small no-margin pull-left sm-pull-reset">
                    <span class="hint-text">Copyright &copy; {{date('Y')}}, Version 2.0.0 | </span>
                    <span class="font-montserrat">SpiderWorks</span>.
                    <span class="hint-text">All rights reserved. </span>
                </p>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- END COPYRIGHT -->
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTAINER -->
<!--START QUICKVIEW -->

<!-- END QUICKVIEW-->
<!-- START OVERLAY -->

<!-- END OVERLAY -->
<!-- BEGIN VENDOR JS -->
@include('spiderworks.webadmin._partials.scripts')
@stack('scripts')
<script type="text/javascript">
    var image_upload_url = "{{ url('summernote/image') }}";
    var _token = "{{csrf_token()}}";
    var base_url = "{{url('/')}}";
    var media_popup_url = "{{route('spiderworks.webadmin.media.popup')}}"
    var columnDefs = [{}];
</script>
@section('bottom')
@show
<script src="{{asset('webadmin/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('webadmin/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- END PAGE LEVEL JS -->
<script src="{{asset('webadmin/js/jquery.imgcheckbox.js')}}"></script>
<script src="{{asset('webadmin/js/scripts.js')}}"></script>
<script>
    $(document).ready(function () {
        $('table').attr('width','100%');
        $('#datatable_wrapper').parent().removeClass('padding-15').addClass('padding-5');
        $('#datatable').parent().addClass('table-responsive');
    });

</script>

 <script>
        if($('#datatable').length)
        {
            var $table = $('#datatable');
            var ajaxUrl = $table.data('datatable-ajax-url');
            console.log(ajaxUrl)
            //var order = '';
            dt_table = $table.DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                "processing": true,
                "serverSide": true,
                responsive: true,
                ajax: {
                    url: ajaxUrl,
                    data: function(d) {
                        var advanced_search = {};
                        $('.datatable-advanced-search').each(function(i, obj) {
                                advanced_search[$(this).attr('name')] = $(this).val();
                        });
                        d.data = advanced_search;
                    }
                },
                columns: my_columns,
                "stateSave": true,
                'aoColumnDefs': [
                    { 'bSortable': false, 'sClass': "text-center table-width-10", 'aTargets': ['nosort'] },
                    { "bSearchable": false, "aTargets": [ 'nosearch' ] },
                    { "bVisible": false, 'sClass': "d-none", "aTargets": ['nodisplay'] }
                ],
                errMode: 'throw',
                "order": [order],
                "language": {
                    "search": "",
                    'searchPlaceholder': 'Search...'
                },
                initComplete: function(settings, json) {
                    $(this).trigger('initComplete', [this]);
                    $(window).trigger('resize');
                    this.api().columns().every( function () {

                    });
                    if($('.ratings').length)
                    {
                        $(".ratings").starRating({
                            starSize: 25,
                            readOnly: true
                        });
                    }
                },
                fnRowCallback : function(nRow, aData, iDisplayIndex, iDisplayIndexFull){
                    updateDtSlno(this, slno_i);
                }
            });

            $('#datatable #column-search tr th').each( function () {
                var title = $(this).text();
                var columnClass = $(this).attr('class');
                if($(this).hasClass('searchable-input')){
                    if($(this).hasClass('date'))
                    {
                        var id = $(this).attr('data-id');
                        $(this).html( '<input type="text" placeholder="Search '+title+'" class="form-control input-sm daterange" name="updated_at" id="'+id+'" />' );
                        $('.daterange').daterangepicker({
                            timePicker: true,
                            autoUpdateInput: false,
                            drops: "up",
                            locale: {
                                cancelLabel: 'Clear',
                                format: 'MM/DD/YYYY HH:mm'
                            }
                        });
                    }
                    else if($(this).hasClass('date_time'))
                    {
                        var id = $(this).attr('data-id');
                        $(this).html( '<input type="text" placeholder="Search '+title+'" class="form-control input-sm daterange" name="date_time" id="'+id+'" />' );
                        $('#'+id).daterangepicker({
                            timePicker: true,
                            autoUpdateInput: false,
                            drops: "up",
                            locale: {
                                cancelLabel: 'Clear',
                                format: 'MM/DD/YYYY HH:mm'
                            }
                        });
                    }
                    else
                        $(this).html(  '<input type="text" placeholder="Search '+title+'" class="form-control input-sm search-input" />' );
                }
            });

            $( '#datatable thead').on( 'keyup change', ".search-input",function () {
   
                dt_table
                    .column( $(this).parent().index() )
                    .search( this.value )
                    .draw();
            });

            $( '#datatable thead').on( 'change', ".select-box-input",function () {
   
                dt_table
                    .column( $(this).parent().index() )
                    .search( this.value )
                    .draw();
            });

        }

        $(function(){
            $(".copy-name").keyup(function () {
                var name = $(this).val();
                $("input[name='slug']").val(slugify(name));
                $("input[name='title']").val(name);
                $("input[name='browser_title']").val(name);
            });
        });


        function updateDtSlno(dt, slno_i) {
            if (typeof dt != "undefined") {
                if(typeof slno_i == 'undefined')
                    slno_i = 0;
                table_rows = dt.fnGetNodes();
                var oSettings = dt.fnSettings();
                $.each(table_rows, function(index){
                    $("td:eq(" + slno_i + ")", this).html(oSettings._iDisplayStart+index+1);
                });
            }
        }

        function dt(){
            dt_table.ajax.reload();
        }

        function slugify(string) {
            const a = 'Ã Ã¡Ã¢Ã¤Ã¦Ã£Ã¥ÄÄƒÄ…Ã§Ä‡ÄÄ‘ÄÃ¨Ã©ÃªÃ«Ä“Ä—Ä™Ä›ÄŸÇµá¸§Ã®Ã¯Ã­Ä«Ä¯Ã¬Å‚á¸¿Ã±Å„Ç¹ÅˆÃ´Ã¶Ã²Ã³Å“Ã¸ÅÃµá¹•Å•Å™ÃŸÅ›Å¡ÅŸÈ™Å¥È›Ã»Ã¼Ã¹ÃºÅ«Ç˜Å¯Å±Å³áºƒáºÃ¿Ã½Å¾ÅºÅ¼Â·/_,:;'
            const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiilmnnnnooooooooprrsssssttuuuuuuuuuwxyyzzz------'
            const p = new RegExp(a.split('').join('|'), 'g')

            return string.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
                .replace(/&/g, '-and-') // Replace & with 'and'
                .replace(/[^\w\-]+/g, '') // Remove all non-word characters
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, '') // Trim - from end of text
        }
        

    </script>

</body>
</html>