@extends('layouts.adminapp')

@section('content')
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/admin/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
      </div>
      <!-- /.row -->


      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
                 
          
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- Info Boxes Style 2 -->
          
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection  
  
@section('scripts')
<!-- jvectormap -->
<script src="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll 1.3.0 -->
<script src="{{ asset('assets/admin/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- ChartJS 1.0.1 -->
<script src="{{ asset('assets/admin/plugins/chartjs/Chart.min.js') }}"></script>
<script>
	$(document).ready(function () {
 
		var form = $('#quick_email');
		form.submit(function(e) {
		    $('.processing-icon').show();
		    $('.send-icon').hide();

			e.preventDefault();
			$.ajax({
				url     : form.attr('action'),
				type    : form.attr('method'),
				data    : form.serialize(),
				dataType: 'json',
				success : function ( data )
				{
					if(data.errors) {
						$.each(data.errors, function (key, value) {
							$('.'+key+'-error').html(value);
							$('.'+key+'-error').closest('div.form-group').addClass('has-error');
						});
                        $('.processing-icon').hide();
                        $('.send-icon').show();
                	}
					if(data.success == 1){
                        form.prepend('<div class="msg-component"><div class="alert alert-success alert-fill alert-close alert-dismissable show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true" aria-label="Close">×</button><strong>Email Sent Succesfully!</strong></div></div>');
						form[0].reset();
                        $('.processing-icon').hide();
                        $('.send-icon').show();
            setTimeout(function(){ $('div.msg-component').remove(); }, 5000);
					}
				},
				error: function( json )
				{
					if(json.status === 422) {
						$.each(json.responseJSON, function (key, value) {
							$('.'+key+'-error').html(value);
							$('.'+key+'-error').closest('div.form-group').addClass('has-error');
						});
					} else {
						// Error
                    	
                    	// alert('Incorrect credentials. Please try again.')
					}
				}
			});
		});
	 
	});
</script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('assets/admin/dist/js/pages/dashboard2.js') }}"></script>

@stop
