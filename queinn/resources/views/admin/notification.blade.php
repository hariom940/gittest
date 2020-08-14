@extends('layouts.adminapp')

@section('content')

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Notification</h3>
            </div>
            <!-- /.box-header -->
            
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/notification') }}" enctype="multipart/form-data">
              <div class="box-body">
              {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                  <label for="head_title" class="col-sm-2 control-label">Content</label>
                  <div class="col-sm-10">
                  	<textarea class="form-control" rows="3" id="content" name="content" placeholder="Content.">{{ $notification->content != '' ? $notification->content : old('content') }}</textarea>
                  </div>
                </div>
                
                <hr /> 
                <div class="form-group">
                  <label for="contact_detail" class="col-sm-2 control-label">Background Color</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control my-colorpicker1" id="color" name="color" value="{{ $notification->color != '' ? $notification->color : old('color') }}" placeholder="Background Color.">
                  </div>  
                </div>
                
                
                <hr />
                
                <div class="form-group">
                  <label for="status" class="col-sm-2 control-label">Visibility</label>
                   <div class="col-sm-10">
                      <select class="form-control" name="visible">
                        <option value="1" {{ (old('visible') == 1 || $notification->visible == 1) ? 'selected="selected"' : '' }}>Enable</option>
                        <option value="2" {{ (old('visible') == 2 || $notification->visible == 2) ? 'selected="selected"' : '' }}>Disable</option>
                      </select>
                  </div>
               </div>
                
				        <div class="box-footer">
                	<button type="submit" class="btn btn-info pull-right">Save Notification</button>
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
<!-- bootstrap color picker -->
<script src="{{ asset('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script>
  $(function () {
    $('.my-colorpicker1').colorpicker()
  });
</script>

@stop