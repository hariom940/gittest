@extends('layouts.adminapp')
@section('content')
  <div class="row">
    <!-- left column -->
    <!--/.col (left) -->
    <!-- right column -->
    <div class="col-md-12">
    	<div class="box box-info">
        <div class="box-header">
          <i class="fa fa-thumbs-o-up"></i>
          <h3 class="box-title">Admins</h3>
        </div>           
        <div class="box-body">
        	<a href="{{ url('admin/admin/add')}}" class="btn btn-info pull-right"> Add New User </a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th class="no-sort">Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date</th>
                <th class="no-sort"></th>
              </tr>
              </thead>
              <tbody>
                @foreach ($admins as $admin)
                  <tr>
                  	<td>
                    	@if (file_exists(public_path($admin->featured_image)) && $admin->featured_image!='')
                    		<img src="{{URL::asset($admin->featured_image)}}" width="100">
                      @else
                        <img src="{{ asset('assets/uploads/no_img.gif') }}" width="100">
                      @endif
                    </td>
                    <td>{{ucfirst($admin->name).' '.ucfirst($admin->last_name)}}</td>
                    <td>{{ $admin->email }}</td>
                    <td>Joined <br/> {{ time_elapsed_string($admin->created_at) }}</td>
                    <td>
                    	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Admin" href="{{ url('/admin/admins/edit').'/'.$admin->id }}"> <i class="fa fa-edit"></i> </a>
                    	<a class="btn btn-danger btn-xs deleteAdmin" href="javascript:;" data-id="{{ $admin->id }}" data-toggle="tooltip" title="Delete Admin"> <i class="fa fa-remove"></i> </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date</th>
                <th></th>
              </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!--/.col (right) -->
  </div>
  <!-- /.row -->
@endsection