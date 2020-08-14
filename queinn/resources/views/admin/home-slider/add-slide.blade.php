@extends('layouts.adminapp')

@section('content')

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-sliders"></i> Add Slide</h3>
            </div>
            <!-- /.box-header -->
            
              <form class="form-horizontal" role="form" method="POST" id="admin_login" action="{{ url('/admin/home-slider/add-slide') }}" enctype="multipart/form-data">
              <div class="box-body">
              {{ csrf_field() }}
                <!-- text input -->            
                <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Title</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Title">
                  </div>  
                </div>
                
                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                  <label for="exampleInputFile" class="col-sm-2 control-label">Image</label>
                  <div class="col-sm-10">
                  	<input type="file" id="exampleInputFile" name="image" accept="image/*">
                    <small class="text-danger">Upload image of dimension 1500 X 400 at least</small>
                  </div>
                </div>

                <div class="form-group">
                  <label for="visibility" class="col-sm-2 control-label">Visibility</label>
                  <div class="col-sm-10">
                  	<select class="form-control" name="visibility" id="visibility">
                        <option value="1" {{ old('visibility') == 1 ? 'selected="selected"' : '' }}>Enable</option>
                        <option value="2" {{ old('visibility') == 2 ? 'selected="selected"' : '' }}>Disable</option>
                    </select>
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