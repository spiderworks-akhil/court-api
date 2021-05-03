@extends('spiderworks.webadmin.app')

@section('content')
    <div class="container-fluid">
        <!-- START card -->
        <div class="col-lg-12">

            <h3>Please choose a court to see the slots</h3>
            <hr>
            <div class="row">
                @foreach($courts as $obj)
                    <div class="col-md-4">
                        <a href="{{url('admin/slot/'.encrypt($obj->id))}}">
                        <div class="card card-borderless padding-15">
                            {{$obj->name}} <br>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
        <!-- END card -->
    </div>
@endsection
@section('bottom')

    @parent
@endsection