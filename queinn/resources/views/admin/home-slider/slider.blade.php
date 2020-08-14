@extends('layouts.adminapp')

@section('content')
	  
      <div class="row">
        <!-- left column -->
        
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
        	<div class="box box-info">
            <div class="box-header">
              <i class="fa fa-sliders"></i>
              <h3 class="box-title">Home Slider</h3>
            </div>
            
            <div class="box-body">
            	<a href="{{ url('admin/home-slider/add-slide')}}" class="btn btn-info pull-right"> Add New Slide </a>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
             <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="no-sort">Image</th>
                  <th class="no-sort">Visibility</th>
                  <th class="no-sort">Actions</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($slider as $slide)
                  
                    <tr>
                    	<td>
                         
                        	@if (file_exists(public_path($slide->image)) && $slide->image!='')
                        		<img src="{{URL::asset($slide->image)}}" width="100">
                            @else
                                <img src="{{ asset('assets/uploads/no_img.gif') }}" width="100">
                            @endif
                        </td>
                        <td>{{$slide->visibility == 1 ? 'Enable' : 'Disable'}}</td>
                        <td>
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Slide" href="{{ url('/admin/home-slider/edit-slide').'/'.$slide->id }}"> <i class="fa fa-edit"></i> </a>
                        	<a class="btn btn-danger btn-xs deleteSlide" href="javascript:;" data-id="{{ $slide->id }}" data-toggle="tooltip" title="Delete Slide"> <i class="fa fa-remove"></i> </a> 	
                        </td>
                    </tr>
                    
                  @endforeach 

                </tbody>
                <tfoot>
                <tr>
                  <th>Image</th>
                  <th>Visibility</th>
                  <th>&nbsp;</th>
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