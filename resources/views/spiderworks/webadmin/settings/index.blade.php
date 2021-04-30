@extends('spiderworks.webadmin.fileupload')

@section('content')
    <div class="container-fluid">
            <div class="col-md-12 p-0"  align="right" style="margin-bottom: 20px; ">
              <span class="page-heading">Global Settings</span>
              <div >
                  <div class="btn-group">
                      <a href="{{route($route.'.create')}}" class="btn btn-success"><i class="fa fa-pencil"></i> Add new</a>
                  </div>
              </div>
            </div>
            <!-- START card -->
            <div class="card card-borderless padding-15">
                    <table class="table table-hover demo-table-search table-responsive-block" id="datatable"
                           data-datatable-ajax-url="{{ route($route.'.index') }}" >
                        <thead id="column-search">
                        <tr>
                            <th class="table-width-10">ID</th>
                            <th class="table-width-120">Type</th>
                            <th class="table-width-120">Key</th>
                            <th class="table-width-120">Value</th>
                            <th class="nosort nosearch table-width-10">Edit</th>
                        </tr>

                        <tr>
                            <th class="table-width-10 nosort nosearch"></th>
                            <th class="table-width-10 searchable-input">Type</th>
                            <th class="table-width-10 searchable-input">Key</th>
                            <th class="table-width-120 searchable-input">Value</th>
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
    <script type="text/javascript" src="{{asset('webadmin/js/fileinput.js')}}"></script>
    <script>
        var my_columns = [
            {data: null, name: 'id'},
            {data: 'type', name: 'type'},
            {data: 'code', name: 'code'},
            {data: 'value', name: 'value'},
            {data: 'action_ajax_edit', name: 'action_ajax_edit'},
        ];
        var slno_i = 0;
        var order = [3, 'desc'];

        function validate()
        {
            $('#SettingsFrm').validate({
                ignore: [],
                rules: {
                    value: "required",
                  },
                  messages: {
                    value: "Value cannot be blank",
                  },
            });
        }
    </script>
    @parent
@endsection