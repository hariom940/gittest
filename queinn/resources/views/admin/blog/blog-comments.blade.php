@extends('layouts.adminapp')



@section('content')

	  

      <div class="row">

        <!-- left column -->

        

        <!--/.col (left) -->

        <!-- right column -->

        <div class="col-md-12">

        	<div class="box box-info">

            <div class="box-header">

              <i class="fa fa-comment"></i>

              <h3 class="box-title">Blog Comment List</h3>

            </div>

            

                     

            <!-- /.box-header -->

            <div class="box-body">

            <div class="table-responsive">

              <table id="example1" class="table table-bordered table-striped">

                <thead>

                <tr>

                  <th>Blog Title</th>

                  <th>Name</th>

                  <th>Comment</th>

                  <th>Date</th>

                  <th class="no-sort"></th>

                </tr>

                </thead>

                <tbody>

                   @foreach ($blogComments as $blog)

                    <tr>

                        <td>{{fieldtofield('blogs', 'id', $blog->blog_id, 'title')}}</td>

                        <td>{{ $blog->name }}</td>

                        <td>{{ $blog->comment }}</td>  

                        <td>Published <br/> {{ time_elapsed_string($blog->updated_at) }}</td>

                        <td>

                        	<a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Blog Comment" href="{{ url('/admin/blogs/comments-list/edit').'/'.$blog->id }}"> <i class="fa fa-edit"></i> </a>

                        	<a class="btn btn-danger btn-xs deleteBlogComment" href="javascript:;" data-id="{{ $blog->id }}" data-toggle="tooltip" title="Delete Blog Comment"> <i class="fa fa-remove"></i> </a> 	

                        </td>

                    </tr>

                    

                    @endforeach 



                

                </tbody>

                <tfoot>

                <tr>

                    <th>Blog Title</th>

                    <th>Name</th>

                    <th>Comment</th>

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



