@extends('layouts.adminapp')

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-plus-square-o"></i> Add Team Member</h3>
                    <a href="{{ url('admin/contact')}}" class="btn btn-warning pull-right">Back</a>
                </div>
                <!-- /.box-header -->

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/contact/edit/').'/'.$editContact->id}}" enctype="multipart/form-data">
                    <div class="box-body">
                    {{ csrf_field() }}
                    <!-- text input -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">Name<span style="color: red;"> *</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $editContact->name!='' ? $editContact->name : old('name') }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" value="{{ $editContact->email !='' ? $editContact->email : old('email') }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-sm-2 control-label">Phone<span style="color: red;"> *</span></label>
                            <div class="col-sm-10">
                                <input type="number" name="phone" id="phone"  class="form-control" value="{{ $editContact->phone!='' ? $editContact->phone : old('phone') }}">
                            </div>
                        </div>


                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Update</button>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </form>

            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->

        <!--/.col (right) -->
    </div>
    <!-- /.row -->
@endsection