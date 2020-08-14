@extends('layouts.adminapp')

@section('content')

<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-plus-square-o"></i> Add Contact</h3>
                <a href="{{ url('admin/contact')}}" class="btn btn-warning pull-right">Back</a>
            </div>
            <!-- /.box-header -->

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/contact/add')}}" enctype="multipart/form-data">
                <div class="box-body">
                    {{ csrf_field() }}
                    <!-- text input -->
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-sm-2 control-label">Name<span style="color: red;"> *</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="col-sm-2 control-label">Phone<span style="color: red;"> *</span></label>
                        <div class="col-sm-10">
                            <input type="number" name="phone" id="phone"  class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-info pull-right">Save</button>
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