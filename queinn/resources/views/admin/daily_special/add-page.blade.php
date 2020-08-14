@extends('layouts.adminapp')

@section('content')

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-plus-square-o"></i> Add Page</h3>
              <a href="{{ url('/admin/daily_special') }}" class="btn btn-warning pull-right">Cancel</a>
            </div>
            <!-- /.box-header -->
            
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/daily_special/add')}}">
              <div class="box-body">
              {{ csrf_field() }}
                <!-- text input -->            
                <div class="form-group">
                  <label for="tagline" class="col-sm-2 control-label">tagline</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="tagline" name="tagline" value="">
                  </div>  
                </div>
                
                <div class="form-group">
                  <label for="body" class="col-sm-2 control-label">body</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="body" name="body" value="">
                  </div>  
                 </div>

                <div class="form-group">
                  <label for="date" class="col-sm-2 control-label"> date</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="date" name="date" value="">
                  </div>
                </div>
             
                <hr/>
                
                
                
				<div class="box-footer">
                	<button type="submit" class="btn btn-info pull-right">Save</button>
              	</div>
                
			</div>
           
         </form>
           
          </div>
         
        </div>
      
      </div>
      <!-- /.row -->
@endsection
@section('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/select2.min.css') }}">
@stop
@section('scripts')
<!-- CK Editor -->
<script src="{{ asset('assets/admin/plugins/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/select2/select2.full.min.js') }}"></script>
<script>
  /*$(function () {
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
  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
  });*/
</script>

<script>
$(document).ready(function(){

  $( "#date" ).datepicker({
    dateFormat: "yy-mm-dd",
    
  });
  
});
   
</script>

@stop