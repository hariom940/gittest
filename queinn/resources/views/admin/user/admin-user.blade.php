@extends('layouts.adminapp')



@section('content')



      <div class="row">

        <!-- left column -->

        <div class="col-md-12">

          <!-- Horizontal Form -->

          <div class="box box-info">

            <div class="box-header with-border">

              <h3 class="box-title"><i class="fa fa-plus-square-o"></i> Edit Your Profile</h3>

            </div>

            <!-- /.box-header -->

            

              <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/users/profile')}}" enctype="multipart/form-data">

              <div class="box-body">

              {{ csrf_field() }}

                <!-- text input -->            

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                  <label for="link" class="col-sm-2 control-label">Name</label>

                  <div class="col-sm-10">

                  	<input type="text" class="form-control" id="name" name="name" value="{{ $adminUser->name!='' ? $adminUser->name : old('name') }}">

                  </div>  

                </div>

                

               <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                  <label for="email" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">
                      
                  		 <input readonly type="email" class="form-control" id="email" name="email" value="{{ $adminUser->email!='' ? $adminUser->email : old('email') }}">

                  </div>

               </div>

                 

                 

               <div class="form-group">

                  <label for="image" class="col-sm-2 control-label">Featured Image</label>

                  <div class="col-sm-10">

                  	 @if(file_exists(public_path($adminUser->featured_image)) &&  $adminUser->featured_image!='')

                  		<img src="{{URL::asset($adminUser->featured_image)}}" width="200"><br/>

                  	 @endif

                  	<input type="file" id="exampleInputFile" name="featured_image" accept="image/*">

                  </div> 

               </div>

               

                

               <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                  <label for="password" class="col-sm-2 control-label">New Password</label>

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

@section('scripts')



<!-- CK Editor -->

<script src="{{ asset('assets/admin/plugins/ckeditor/ckeditor.js') }}"></script>



<script>

  $(function () {

    // Replace the <textarea id="editor1"> with a CKEditor

    // instance, using default configuration.

    CKEDITOR.replace('editor1',{

					extraPlugins: 'uploadimage',

					

					filebrowserBrowseUrl: "{{ asset('assets/admin/plugins/ckfinder/ckfinder.html') }}",

					filebrowserImageBrowseUrl: "{{ asset('assets/admin/plugins/ckfinder/ckfinder.html?type=Images') }}",

					filebrowserUploadUrl: "{{ asset('assets/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",

					filebrowserImageUploadUrl: "{{ asset('assets/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}"

	});

  });

  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({

      checkboxClass: 'icheckbox_minimal-blue',

      radioClass: 'iradio_minimal-blue'

  });

  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({

      checkboxClass: 'icheckbox_flat-green',

      radioClass: 'iradio_flat-green'

  });

</script>



@stop