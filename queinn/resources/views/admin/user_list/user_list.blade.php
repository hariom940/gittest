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
                <a href="{{ url('admin/user/add') }}" class="btn btn-primary pull-right">Add New Page</a>
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
                   <th>Name</th>
                  <th>Email</th>
                  <th>address</th>
                  <th class="no-sort">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($user_list as $user_list)
                    <tr>
          
                        <td>{{$loop->index+1 }}</td>
                          <td>{{$user_list->name}}</td>
                         <td>{{$user_list->email}}</td>
                        <td>{{$user_list->address}}</td>
                        
                          
                        <td>
                        
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit page" href="{{ url('/admin/user/edit').'/'.$user_list->id }}"> <i class="fa fa-edit"></i> </a>
                          <form action="{{ route('user-delete',$user_list->id)}}" method="POST">
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
                  <th>Name</th>
                  <th>Email</th>
                  <th>address</th>
                  
                  
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