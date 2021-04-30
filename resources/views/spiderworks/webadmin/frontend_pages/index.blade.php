@extends('spiderworks.webadmin.app')

@section('content')
    <div class="container-fluid">
            <!-- START card -->
            <div class="col-md-12" style="margin-bottom: 20px;" align="right">
                <span class="page-heading">All Static Pages</span>
            </div>

            <div class="col-lg-12">
                <div class="card card-borderless padding-15">
                        <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                               data-datatable-ajax-url="{{ route($route.'.index') }}" >
                            <thead id="column-search">
                            <tr>
                                <th class="nodisplay"></th>
                                <th class="table-width-10">ID</th>
                                <th class="table-width-120">Slug</th>
                                <th class="table-width-120">Name</th>
                                <th class="table-width-120">Title</th>
                                <th class="nosort nosearch table-width-10">Edit</th>
                            </tr>

                            <tr>
                                <th class="nosort nosearch table-width-10"></th>
                                <th class="table-width-10 nosort nosearch"></th>
                                <th class="table-width-10 searchable-input">Slug</th>
                                <th class="table-width-120 searchable-input">Name</th>
                                <th class="table-width-120 searchable-input">Title</th>
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
            {data: 'slug', name: 'slug'},
            {data: 'name', name: 'name'},
            {data: 'title', name: 'title'},
            {data: 'action_edit', name: 'action_edit'},
        ];
        var slno_i = 0;
        var order = [0, 'desc'];
    </script>
    @parent
@endsection