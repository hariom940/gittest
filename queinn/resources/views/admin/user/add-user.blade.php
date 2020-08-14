@extends('layouts.adminapp')

@section('content')

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-plus-square-o"></i> Add User</h3>
            </div>
            <!-- /.box-header -->
            
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/users/add')}}" enctype="multipart/form-data">
              <div class="box-body">
              {{ csrf_field() }}
                <!-- text input -->            
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                  </div>  
                </div>
                
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="email" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                  		 <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                  </div>
                 </div>
               
               <div class="form-group">
                  <label for="image" class="col-sm-2 control-label">Featured Image</label>
                  <div class="col-sm-10">
                  	<input type="file" id="exampleInputFile" name="featured_image" accept="image/*">
                  </div> 
               </div> 
               
               <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label for="password" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-10">
                  	<input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}"/>
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
