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

              <h3 class="box-title">Users</h3>

            </div>

            

            <div class="box-body">

            	<a href="{{ url('admin/users/add')}}" class="btn btn-info pull-right"> Add New User </a>

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

                   @foreach ($users as $user)

                    <tr>

                    	<td>

                        	@if (file_exists(public_path($user->featured_image)) && $user->featured_image!='')

                        		<img src="{{URL::asset($user->featured_image)}}" width="100">

                            @else

                                <img src="{{ asset('assets/uploads/no_img.gif') }}" width="100">

                            @endif

                        </td>

                        <td>{{ucfirst($user->name).' '.ucfirst($user->last_name)}}</td>

                        <td>{{ $user->email }}</td>    

                        <td>Joined <br/> {{ time_elapsed_string($user->updated_at) }}</td>

                        <td>

                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit User" href="{{ url('/admin/users/edit').'/'.$user->id }}"> <i class="fa fa-edit"></i> </a>

                        	<a class="btn btn-danger btn-xs deleteUser" href="javascript:;" data-id="{{ $user->id }}" data-toggle="tooltip" title="Delete User"> <i class="fa fa-remove"></i> </a> 	

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



