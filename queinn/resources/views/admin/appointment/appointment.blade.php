@extends('layouts.adminapp')

@section('content')
	  
      <div class="row">
        <!-- left column -->
        
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
        	<div class="box box-info">
            <div class="box-header">
              <i class="fa fa-file"></i>
              <h3 class="box-title">Pages</h3>
                <a href="{{ url('admin/appointment/add') }}" class="btn btn-primary pull-right">Add New Page</a>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
             <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sno.</th>
                  <th>order no</th>
                  <th>date</th>
                  <th>notes</th>
                  <th class="no-sort">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($appointments as $appointments)
                    <tr>
          
                        <td>{{$loop->index+1 }}</td>
                         <td>{{$appointments->order_no}}</td>
                          <td>{{$appointments->date}}</td>
                        <td>{{$appointments->notes}}</td>
                          
                        <td>
                        	
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit page" href="{{ url('/admin/appointment/edit').'/'.$appointments->id }}"> <i class="fa fa-edit"></i> </a>
                             <form action="{{ route('appointment-delete',$appointments->id)}}" method="POST">
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
                  <th>order no</th>
                  <th>date</th>
                  <th>notes</th>
                </tr>
                </tfoot>
              </table>
             </div> 
            </div>
           
          </div>
        </div>
        
      </div>
     
@endsection