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
                <a href="{{ url('admin/daily_special/add') }}" class="btn btn-primary pull-right">Add New Page</a>
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
                  <th>tagline</th>
                  <th>body</th>
                  <th>date</th>
                  
                  <th class="no-sort">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($daily_special as $daily_special)
                    <tr>
          
                        <td>{{$loop->index+1 }}</td>
                         <td>{{$daily_special->tagline}}</td>
                          <td>{{$daily_special->body}}</td>
                        <td>{{$daily_special->date}}</td>
                         
                          
                        <td>
                        	
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit page" href="{{ url('/admin/daily_special/edit').'/'.$daily_special->id }}"> <i class="fa fa-edit"></i> </a>
                             <form action="{{ route('daily_special-delete',$daily_special->id)}}" method="POST">
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
                  <th>tagline</th>
                  <th>body</th>
                  <th>date</th>
                  
                  
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