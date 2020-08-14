@extends('layouts.adminapp')

@section('content')
	  
      <div class="row">
        <!-- left column -->
        
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
        	<div class="box box-info">
            <div class="box-header">
              <i class="fa fa-question"></i>
              <h3 class="box-title">FAQS</h3>
            </div>
            
            <div class="box-body">
            	<a href="{{ url('admin/faq/add')}}" class="btn btn-info pull-right"> Add New Faq </a>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Visibility</th>
                  <th>Date</th>
                  <th class="no-sort"></th>
                </tr>
                </thead>
                <tbody>
                   @foreach ($faqs as $faq)
                    <tr>
                    	
                        <td>{{$faq->title}}</td>
                        <td>{!! $faq->description !!}</td> 
                        <td>{{ ($faq->visibility == 1) ? 'Enable' : 'Disable' }}</td>   
                        <td>Published <br/> {{ time_elapsed_string($faq->updated_at) }}</td>
                        <td>
                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Faq" href="{{ url('/admin/faq/edit').'/'.$faq->id }}"> <i class="fa fa-edit"></i> </a>
                        	<a class="btn btn-danger btn-xs deleteFaq" href="javascript:;" data-id="{{ $faq->id }}" data-toggle="tooltip" title="Delete faq"> <i class="fa fa-remove"></i> </a> 	
                        </td>
                    </tr>
                    
                    @endforeach 

                
                </tbody>
                <tfoot>
                <tr>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Visibility</th>
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
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
@endsection

