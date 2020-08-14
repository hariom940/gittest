@extends('layouts.adminapp')

@section('content')

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-plus-square-o"></i> Edit FAQ</h3>
                <a href="{{ url('admin/faq') }}" class="btn btn-warning pull-right">Cancel</a>
            </div>
            <!-- /.box-header -->
            
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/faq/edit').'/'.$editFaq->id}}" enctype="multipart/form-data">
              <div class="box-body">
              {{ csrf_field() }}
                <!-- text input -->            
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                  <label for="link" class="col-sm-2 control-label">Title<span style="color: red;"> *</span></label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="title" name="title" value="{{ $editFaq->title!='' ? $editFaq->title : old('title') }}">
                  </div>  
                </div>
                
                <div class="form-group">
                  <label for="link" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-10">
                  		 <textarea id="editor1" name="description" rows="10" cols="80">
                                          {{ $editFaq->description!='' ? $editFaq->description : old('description') }}
                    	</textarea>
                  </div>
                 </div>
               
               
               
              <hr /> 
                  
               <div class="form-group">
                  <label for="status" class="col-sm-2 control-label">Visibility</label>
                   <div class="col-sm-10">
                   		<select class="form-control" name="status">
                  			<option value="1" {{ (old('status') == 1 || $editFaq->visibility == 1) ? 'selected="selected"' : '' }}>Enable</option>
                            <option value="2" {{ (old('status') == 2 || $editFaq->visibility == 2) ? 'selected="selected"' : '' }}>Disable</option>
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