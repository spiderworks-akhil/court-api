@extends('spiderworks.webadmin.app')

@section('content')
    <div class="container-fluid">


            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">All Testimonials</span>
              <div >
                  <div class="btn-group">
                      <a href="{{route($route.'.create')}}" class="btn btn-success" title="Create new type"><i class="fa fa-pencil"></i> Create new</a>
                  </div>
              </div>
            </div>
            <!-- START card -->
            <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                               data-datatable-ajax-url="{{ route($route.'.index') }}" >
                            <thead id="column-search">
                            <tr>
                                <th class="nodisplay"></th>
                                <th class="table-width-10">ID</th>
                                <th class="table-width-120">Name</th>
                                <th class="table-width-120">Designation</th>
                                <th class="nosort nosearch table-width-10">Status</th>
                                <th class="nosort nosearch table-width-10">Edit</th>
                                <th class="nosort nosearch table-width-10">Delete</th>
                            </tr>

                            <tr>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="table-width-10 nosort nosearch"></th>
                                <th class="table-width-120 searchable-input">Name</th>
                                <th class="table-width-120 searchable-input">Designation</th>
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
            {data: 'updated_at', name: 'updated_at'},
            {data: null, name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'designation', name: 'designation'},
            {data: 'status', name: 'status'},
            {data: 'action_edit', name: 'action_edit'},
            {data: 'action_delete', name: 'action_delete'}
        ];
        var slno_i = 0;
        var order = [0, 'desc'];

    </script>
    @parent
@endsection