@extends('layouts.adminapp')



@section('content')



      <div class="row">

        <!-- left column -->

        <div class="col-md-12">

          <!-- Horizontal Form -->

          <div class="box box-info">

            <div class="box-header with-border">

              <h3 class="box-title"><i class="fa fa-plus-square-o"></i> Edit User</h3>

            </div>

            <!-- /.box-header -->

            

              <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/users/edit').'/'.$editUser->id}}" enctype="multipart/form-data">

              <div class="box-body">

              {{ csrf_field() }}

                <!-- text input -->            

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                  <label for="link" class="col-sm-2 control-label">Fisrt Name</label>

                  <div class="col-sm-10">

                  	<input type="text" class="form-control" id="name" name="name" value="{{ $editUser->name!='' ? $editUser->name : old('name') }}">

                  </div>  

                </div>

                <div class="form-group">

                  <label for="link" class="col-sm-2 control-label">Last Name</label>

                  <div class="col-sm-10">

                    <input class="form-control" readonly value="{{ $editUser->last_name }}">

                  </div>  

                </div>

                

               <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                  <label for="email" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">

                  		 <input type="email" class="form-control" id="email" name="email" value="{{ $editUser->email!='' ? $editUser->email : old('email') }}">

                  </div>

               </div>

                 

                 

               <div class="form-group">

                  <label for="image" class="col-sm-2 control-label">Featured Image</label>

                  <div class="col-sm-10">

                  	 @if(file_exists(public_path($editUser->featured_image)) &&  $editUser->featured_image!='')

                  		<img src="{{URL::asset($editUser->featured_image)}}" width="200"><br/>

                  	@endif

                  	<input type="file" id="exampleInputFile" name="featured_image" accept="image/*">

                  </div> 

               </div>

               

                

               <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                  <label for="password" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-10">

                  	<input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}"/>

                  </div> 

               </div>

               <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Address</label>
                  <div class="col-sm-10">
                    <input class="form-control" readonly value="{{ $editUser->address }}"/>
                  </div> 
               </div>

               <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Apartment</label>
                  <div class="col-sm-10">
                    <input class="form-control" readonly value="{{ $editUser->apartment }}"/>
                  </div> 
               </div>

               <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Town / City</label>
                  <div class="col-sm-10">
                    <input class="form-control" readonly value="{{ $editUser->city }}"/>
                  </div> 
               </div>

               <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">State / County / Province</label>
                  <div class="col-sm-10">
                    <input class="form-control" readonly value="{{ $editUser->state }}"/>
                  </div> 
               </div>

               <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Country</label>
                  <div class="col-sm-10">
                    <input class="form-control" readonly value="{{ $editUser->country }}"/>
                  </div> 
               </div>

               <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Postcode</label>
                  <div class="col-sm-10">
                    <input class="form-control" readonly value="{{ $editUser->postcode }}"/>
                  </div> 
               </div>

               <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Phone</label>
                  <div class="col-sm-10">
                    <input class="form-control" readonly value="{{ $editUser->phone }}"/>
                  </div> 
               </div>
        <hr/>

        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-file-text-o"></i>
              <h3 class="box-title">Order List</h3>
            </div>
            
                        
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Order</th>
                  <th>Status</th>
                  <th>Order Total</th>
                  <th>Date</th>
                  <th class="no-sort"></th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($allOrders as $order)
                    <tr>
                      <td> <a data-toggle="tooltip" title="View Order" href="{{ url('/admin/orders/edit').'/'.$order->id }}">{{ '#'.$order->id.' '.ucfirst($order->first_name).' '.ucfirst($order->last_name)  }} </a> </td>
                        <td>{{ showOrderStatus($order->order_status) }}</td> 
                        <td>{{'$'.number_format($order->order_total,2) }}</td>
                        <td>Last updated  <br/> {{ time_elapsed_string($order->updated_at) }}</td>
                        <td>
                          <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Order" href="{{ url('/admin/orders/edit').'/'.$order->id }}"> <i class="fa fa-edit"></i> </a>
                          <a class="btn btn-danger btn-xs deleteOrder" href="javascript:;" data-id="{{ $order->id }}" data-toggle="tooltip" title="Delete Order"> <i class="fa fa-remove"></i> </a>   
                        </td>
                    </tr>
                    
                    @endforeach 

                
                </tbody>
                <tfoot>
                <tr>
                  <th>Order</th>
                  <th>Status</th>
                  <th>Order Total</th>
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