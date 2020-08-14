@extends('layouts.adminapp')

@section('content')
	  
      <div class="row">
        <!-- left column -->
       
        <!-- right column -->
        <div class="col-md-12">
        	<div class="box box-info">
            <div class="box-header">
              <i class="fa fa-file"></i>
              <h3 class="box-title">Pages</h3>
                
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
                  <th>Sno.</th>
                  <th>cart item</th>
                  <th>total price</th>
                  <th>payment method</th>
                  
                  <th class="no-sort">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                  
                   @foreach ($order as $order)
                    <tr>
          
                        <td>{{$loop->index+1 }}</td>
               
                <td> 
                  @php 
                      $newData = json_decode($order->cart_item); 
                      
                      if(is_object($newData)){
                        echo ' Title:'.$newData->title.'<br>'.' Quantity:'.$newData->quantity;
                      }
                      if(is_array($newData)){
                           echo ' Title:'.$newData[0]->title.'<br>'.' Quantity:'.$newData[0]->quantity;
                      } 
                      
                @endphp </td>
                          <td>{{$order->total_price}}</td>
                        <td>{{$order->payment_method}}</td>
                          
                        <td>
                        	
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit page" href="{{ url('/admin/order/edit').'/'.$order->id }}"> <i class="fa fa-edit"></i> </a>
                            <form action="{{ route('order-delete',$order->id)}}" method="POST">
                              {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                               <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Are You Sure? Want to Delete It.')";><i class="fa fa-remove"></i> </a></button>
                          </form>
                        </td>
                    </tr>
                    
                    @endforeach 

                
                </tbody>
                <tfoot>
                <tr>
                 <th>Sno.</th>
                  <th>cart item</th>
                  <th>total price</th>
                  <th>payment method</th>
                  
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