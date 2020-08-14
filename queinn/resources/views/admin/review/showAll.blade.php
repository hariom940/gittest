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

                    <h3 class="box-title">Reviews</h3>

                </div>


                <!-- /.box-header -->

                <div class="box-body">

                    <div class="table-responsive">

                        <table id="example1" class="table table-bordered table-striped">

                            <thead>

                            <tr>

                                <th>Product ID</th>

                                <th>Reviewer Name</th>

                                <th>Stars</th>

                                <th class="no-sort">Reviews</th>

                                <th>Status</th>

                                <th>Date</th>

                                <th class="no-sort">Actions</th>

                            </tr>

                            </thead>

                            <tbody>

                            @foreach ($reviews as $review)

                                <tr>

                                    <td>
                                        @foreach($productDetail as $detail)
                                            @if($detail->id == $review->product_id)
                                                {{ $detail->name }}
                                            @endif
                                        @endforeach
                                    </td>

                                    <td>{{ $review->name }}</td>

                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star" aria-hidden="true" style="color: @if($review->stars >= $i)goldenrod @else @endif"></i>
                                        @endfor
                                    </td>

                                    <td>
                                        {{ $review->review }}
                                    </td>

                                    <td>
                                        {{ $review->status == 1 ? 'Disable' : 'Enable' }}
                                    </td>

                                    <td>
                                        Published <br/> {{ time_elapsed_string( $review->created_at) }}
                                    </td>

                                    <td>

                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit Review" href="{{ url('/admin/products/review/edit').'/'.$review->id }}"> <i class="fa fa-edit"></i> </a>

                                        <a class="btn btn-danger btn-xs deleteReview" href="javascript:;" data-id="{{ $review->id }}" data-toggle="tooltip" title="Delete Review"> <i class="fa fa-remove"></i> </a>

                                    </td>

                                </tr>

                            @endforeach


                            </tbody>

                            <tfoot>

                            <tr>

                                <th>Product Name</th>

                                <th>Reviewer Name</th>

                                <th>Stars</th>

                                <th class="no-sort">Reviews</th>

                                <th>Status</th>

                                <th>Date</th>

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
