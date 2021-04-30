@extends('spiderworks.webadmin.app')

@section('content')
<div class="container-fluid">

        <div class="col-md-12" style="margin-bottom: 20px;" align="right">
            <span class="page-heading">Change Password</span>
        </div>

        <div class="col-lg-12">
            <div class="card card-borderless">

                <form method="POST" action="{{ route('spiderworks.webadmin.update-password') }}" style="border:1px solid #ddd; padding: 40px;">

                        @csrf

  

                        <div class="form-group row">

                            <label for="password" class="col-md-4 col-form-label text-md-right">Current Password</label>

  

                            <div class="col-md-6">

                                <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">

                            </div>

                        </div>

  

                        <div class="form-group row">

                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

  

                            <div class="col-md-6">

                                <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">

                            </div>

                        </div>

  

                        <div class="form-group row">

                            <label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label>

    

                            <div class="col-md-6">

                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">

                            </div>

                        </div>

   

                        <div class="form-group row mb-0">

                            <div class="col-md-8 offset-md-4">

                                <button type="submit" class="btn btn-sec">

                                    Update Password

                                </button>

                            </div>

                        </div>

                    </form>
            </div>
        </div>
    </div>
@endsection