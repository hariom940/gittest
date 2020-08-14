@extends('layouts.adminapp')

@section('content')
	  
      <div class="row">
        <!-- left column -->
        
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
        	<div class="box box-info">
            <div class="box-header">
              <i class="fa fa fa-commenting"></i>
              <h3 class="box-title">Blogs</h3>
            </div>
            
            <div class="box-body">
            	<a href="{{ url('admin/blogs/add')}}" class="btn btn-info pull-right"> Add New Blog </a>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="no-sort">Image</th>
                  <th>Name</th>
                  <th>Visibility</th>
                  <th>Date</th>
                  <th class="no-sort"></th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($blogs as $blog)
                    <tr>
                    	<td>
                        	@if (file_exists(public_path($blog->featured_image)) && $blog->featured_image!='')
                        		<img src="{{URL::asset($blog->featured_image)}}" width="100">
                            @else
                                <img src="{{ asset('assets/uploads/no_img.gif') }}" width="100">
                            @endif
                        </td>
                        <td>{{$blog->title}}</td>
                        <td>{{ ($blog->visibility == 1) ? 'Enable' : 'Disable' }}</td>
                        <td>Published <br/> {{ time_elapsed_string($blog->created_at) }}</td>
                        <td>
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Blog" href="{{ url('/admin/blogs/edit').'/'.$blog->id }}"> <i class="fa fa-edit"></i> </a>
                        	<a class="btn btn-danger btn-xs deleteBlog" href="javascript:;" data-id="{{ $blog->id }}" data-toggle="tooltip" title="Delete Blog"> <i class="fa fa-remove"></i> </a> 	
                        </td>
                    </tr>
                    
                    @endforeach 

                
                </tbody>
                <tfoot>
                <tr>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Visibility</th>
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

