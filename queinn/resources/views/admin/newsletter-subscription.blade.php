@extends('layouts.adminapp')

@section('content')
	  
      <div class="row">
        <!-- left column -->
        
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
        	<div class="box box-info">
            <div class="box-header">
              <i class="fa fa-newspaper-o"></i>
              <h3 class="box-title">Newsletter Subscription</h3>
            </div>
            
            <?php /*?><div class="box-body">
            	<a href="{{ url('admin/home-pager/add-page')}}" class="btn btn-info pull-right"> Add New page </a>
            </div><?php */?>
            
            <!-- /.box-header -->
            <div class="box-body">
             <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th class="no-sort">Actions</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($subscriptions as $subscription)

                    <tr>
                    	<td>
                         {{$subscription->email}}	
                        </td>
                        
                        <td>{{$subscription->status == 1 ? 'Subscribed' : 'Unsubscribed'}}</td>
                        <td>Subscribed <br/> {{ time_elapsed_string($subscription->updated_at) }}</td>
                          
                        <td>
                        	
                            <a class="btn btn-danger btn-xs deleteSubscription" href="javascript:;" data-id="{{ $subscription->id }}" data-toggle="tooltip" title="Delete Subscription"> <i class="fa fa-remove"></i> </a> 	
                        </td>
                    </tr>
                    
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Date</th>
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