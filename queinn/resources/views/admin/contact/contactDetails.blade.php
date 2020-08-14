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
                    <h3 class="box-title">Contact Details</h3>
                    <a href="{{ url('admin/contact/add')}}" class="btn btn-primary pull-right"> Add New Contact </a>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-responsive table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="no-sort">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($contact_details as $details)
                                <tr>

                                    <td>{{$details->name}}</td>
                                    <td>{{ $details->email }}</td>
                                    <td>{{$details->phone}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Contact" href="{{ url('/admin/contact/edit').'/'.$details->id }}"> <i class="fa fa-edit"></i> </a>
                                        <a class="btn btn-danger btn-xs deleteContact" href="javascript:;" data-id="{{ $details->id }}" data-toggle="tooltip" title="Delete Contact"> <i class="fa fa-remove"></i></a>
                                    </td>
                                </tr>

                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="no-sort">Action</th>
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
