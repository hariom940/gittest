@extends('layouts.adminapp')



@section('content')



      <div class="row">

        <!-- left column -->

        <div class="col-md-12">

          <!-- Horizontal Form -->

          <div class="box box-info">

            <div class="box-header with-border">

              <h3 class="box-title"><i class="fa fa-comment"></i> Edit Blog Comment</h3>

            </div>

            <!-- /.box-header -->

            

              <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/blogs/comments-list/edit').'/'.$editblogComment->id }}" enctype="multipart/form-data">

              <div class="box-body">

              {{ csrf_field() }}

                <!-- text input -->            

                <div class="form-group">

                  <label for="link" class="col-sm-2 control-label">Blog</label>

                  <div class="col-sm-10">

                  	{{fieldtofield('blogs', 'id', $editblogComment->blog_id, 'title')}}

                  </div>  

                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                  <label for="name" class="col-sm-2 control-label">Name</label>

                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" placeholder="Name." value="{{ $editblogComment->name!='' ? $editblogComment->name : old('name') }}"/>
                  </div>

                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                  <label for="email" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" placeholder="Email." value="{{ $editblogComment->email!='' ? $editblogComment->email : old('email') }}"/>
                  </div>

                </div>

{{--                <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">--}}

{{--                  <label for="website" class="col-sm-2 control-label">Website</label>--}}

{{--                  <div class="col-sm-10">--}}
{{--                      <input class="form-control" name="website" placeholder="Website." value="{{ $editblogComment->website!='' ? $editblogComment->website : old('website') }}"/>--}}
{{--                  </div>--}}

{{--                </div>--}}

{{--                <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">--}}

{{--                   <label for="mobile" class="col-sm-2 control-label">Mobile</label>--}}

{{--                   <div class="col-sm-10">--}}
{{--                       <input class="form-control" id="mobile" name="mobile" placeholder="Mobile" value="{{ $editblogComment->mobile!='' ? $editblogComment->mobile : old('mobile') }}"/>--}}
{{--                   </div>--}}

{{--                 </div>--}}

                <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">

                  <label for="comment" class="col-sm-2 control-label">Comment</label>

                  <div class="col-sm-10">

                  		<textarea class="form-control" rows="3" name="comment" placeholder="Comment.">{{ $editblogComment->comment!='' ? $editblogComment->comment : old('comment') }}</textarea>
                  </div>

                </div>

                <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">

                  <label for="comment" class="col-sm-2 control-label">Display Status</label>

                  <div class="col-sm-10">

                      <select name="status" class="form-control">
                            <option value="1" {{ $editblogComment->status == 1 ? 'selected="selected"' : '' }} >Show</option>
                            <option value="2" {{ $editblogComment->status == 2 ? 'selected="selected"' : '' }}>Hide</option>
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