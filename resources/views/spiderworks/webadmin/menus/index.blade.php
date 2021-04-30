@extends('spiderworks.webadmin.app')

@section('content')
    <div class="container-fluid">

            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">All Menus</span>
              <div >
                  <div class="btn-group">
                      <a href="{{route($route.'.create')}}" class="btn btn-success" title="Create new menu"><i class="fa fa-pencil"></i> Create new</a>
                  </div>
              </div>
            </div>
            <!-- START card -->
            <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="{{ route($route.'.index') }}" >
                        <thead id="column-search">
                        <tr>
                            <th class="table-width-10 text-center">ID</th>
                            <th class="table-width-120">Name</th>
                            <th class="table-width-120">Position</th>
                            <th class="nosort nosearch table-width-10 text-center">Status</th>
                            <th class="nosort nosearch table-width-10 text-center">Edit</th>
                            <th class="nosort nosearch table-width-10 text-center">Delete</th>
                        </tr>

                        <tr>
                            <th class="table-width-10 nosort nosearch"></th>
                            <th class="searchable-input">Name</th>
                            <th class="searchable-input">Position</th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                            <th class="nosort nosearch table-width-10"></th>
                        </tr>

                        </thead>

                        <tbody>
                        </tbody>

                    </table>
            </div>
            <!-- END card -->
    </div>
@endsection
@section('bottom')

    <script>
        var my_columns = [
            {data: null, name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'position', name: 'position'},
            {data: 'status', name: 'status'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [0, 'desc'];

    </script>
    @parent
@endsection