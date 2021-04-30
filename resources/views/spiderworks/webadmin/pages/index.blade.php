@extends('spiderworks.webadmin.app')

@section('content')
    <div class="container-fluid">
            <!-- START card -->
            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">All Pages</span>
                <div >
                    <div class="btn-group">
                        <a href="{{route($route.'.create', ['parent'=>$parent])}}" class="btn btn-success"><i class="fa fa-pencil"></i> Create new
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                
                <div class="card card-borderless padding-15">
                    <h6 class="box-title">@if($parent_data) Sub-page list of <b>{{$parent_data->name}}</b> &nbsp;&nbsp; <a href="{{ route($route.'.index', [$parent_data->parent_id]) }}" class="admin_sub_head_back">Back to Parent</a> @endif</h6>
                        <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                               data-datatable-ajax-url="{{ route($route.'.index', [$parent]) }}" >
                            <thead id="column-search">
                            <tr>
                                <th class="nodisplay"></th>
                                <th class="table-width-10">ID</th>
                                <th class="table-width-120">Name</th>
                                <th class="table-width-120">Title</th>
                                <th class="nosort nosearch table-width-10">Sub Pages</th>
                                <th class="nosort nosearch table-width-10">Status</th>
                                <th class="nosort nosearch table-width-10">Edit</th>
                                <th class="nosort nosearch table-width-10">Delete</th>
                            </tr>

                            <tr>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="table-width-10 nosort nosearch"></th>
                                <th class="table-width-10 searchable-input">Name</th>
                                <th class="table-width-120 searchable-input">Title</th>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="nosort nosearch table-width-10"></th>
                            </tr>

                            </thead>

                            <tbody>
                            </tbody>

                        </table>
                </div>
            </div>
            <!-- END card -->
    </div>
@endsection
@section('bottom')

    <script>
        var my_columns = [
            {data: 'updated_at', name: 'updated_at'},
            {data: null, name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'title', name: 'title'},
            {data: 'sub-pages', name: 'sub-pages'},
            {data: 'status', name: 'status'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete_category', name: 'action_delete_category'}
        ];
        var slno_i = 0;
        var order = [0, 'desc'];

        $(function(){
            $(document).on('click', '.delete_have_child', function(){
                $.alert('Sorry! You cannot delete this page, to delete it please delete all its sub pages.');
            })
        })
    </script>
    @parent
@endsection