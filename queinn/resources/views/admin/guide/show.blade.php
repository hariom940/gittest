@extends('layouts.adminapp')

@section('content')

    <div class="row">

        <!-- left column -->

        <!--/.col (left) -->

        <!-- right column -->

        <div class="col-md-12">

            <div class="box box-info">

                <div class="box-header">

                    <i class="fa fa-ticket"></i>

                    <h3 class="box-title">Coupon Guide</h3>
                    <a href="{{ url('admin/guide/add')}}" class="btn btn-info pull-right"> Add Guide </a>

                </div>

                <!-- /.box-header -->

                <div class="box-body">

                    <div class="table-responsive">

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th>Name</th>

                                    <th class="no-sort">Description</th>

                                    <th class="no-sort">Actions</th>

                                </tr>

                            </thead>

                            <tbody>

                            @foreach ($guides as $guide)

                                <tr>


                                    <td>{{$guide->name}}</td>

                                    <td>
                                        {!! words($guide->description, 10, '...') !!}
                                    </td>


                                    <td>

                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Guide" href="{{ url('/admin/guide/edit').'/'.$guide->id }}"> <i class="fa fa-edit"></i> </a>

                                        <a class="btn btn-danger btn-xs deleteGuide" href="javascript:;" data-id="{{ $guide->id }}" data-toggle="tooltip" title="Delete Guide"> <i class="fa fa-remove"></i> </a>

                                    </td>

                                </tr>

                            @endforeach


                            </tbody>

                            <tfoot>

                                <tr>

                                    <th>Name</th>

                                    <th class="no-sort">Description</th>

                                    <th class="no-sort">Actions</th>

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

