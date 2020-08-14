@extends('layouts.adminapp')

@section('content')

    <div class="row">
        <!-- left column -->

        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-tags"></i>
                    <h3 class="box-title">Blog Tags</h3>
                </div>

                <div class="box-body">
                    <a href="{{ url('admin/blogs/tags/add')}}" class="btn btn-info pull-right"> Add New Tag</a>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="no-sort"></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($tags as $tag)
                                <tr>
                                    <td>{{$tag->name}}</td>
                                    <td>{{ ($tag->status == 1) ? 'Enable' : 'Disable' }}</td>
                                    <td>Published <br/> {{ time_elapsed_string($tag->updated_at) }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Tag" href="{{ url('admin/blogs/tags/edit').'/'.$tag->id }}"> <i class="fa fa-edit"></i> </a>
                                        <a class="btn btn-danger btn-xs deleteBlogTag" href="javascript:;" data-id="{{ $tag->id }}" data-toggle="tooltip" title="Delete Tag"> <i class="fa fa-remove"></i> </a>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
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

