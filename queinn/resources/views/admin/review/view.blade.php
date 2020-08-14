@extends('layouts.adminapp')

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-tasks"></i> Edit Review</h3>
                    <div class="pull-right">
                        <a href="{{ url('/admin/products/review') }}" class="btn btn-warning">Back</a>
                    </div>
                </div>

                <!-- /.box-header -->

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/products/review/edit/').'/'.$reviewData->id}}">
                    <div class="box-body">
                    {{ csrf_field() }}
                    <!-- text input -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">Reviewer Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $reviewData->name!='' ? $reviewData->name : old('name') }}" disabled>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">
                            <label for="product_id" class="col-sm-2 control-label">Product ID</label>
                            <div class="col-sm-10">
                                <input type="email" name="product_id" id="product_id"  class="form-control" value="{{ $reviewData->product_id !='' ? $reviewData->product_id : old('product_id') }}" disabled>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('stars') ? ' has-error' : '' }}">
                            <label for="stars" class="col-sm-2 control-label">Rating out of 5</label>
                            <div class="col-sm-10">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star" aria-hidden="true" style="color: @if($reviewData->stars >= $i)goldenrod @else @endif"></i>
                                @endfor
{{--                                <input type="number" name="stars" id="stars"  class="form-control" value="{{ $reviewData->stars!='' ? $reviewData->stars : old('stars') }}" disabled>--}}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }}">
                            <label for="avatar" class="col-sm-2 control-label">Review</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" disabled>{!! $reviewData->review !='' ? $reviewData->review : old('review') !!}</textarea>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-sm-2 control-label">Status <small>(1=>Disable, 2=>Enable)</small></label>
                            <div class="col-sm-10">
                                <input type="text" name="status" id="status"  class="form-control" value="@if($reviewData->status != '') @if($reviewData->status == 1) Disabled @else Enabled @endif @else  {{ old('status') }}@endif" disabled>
                                <br>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Disable</option>
                                    <option value="2">Enable</option>
                                </select>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Update</button>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </form>

            </div>
            <!-- /.box -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->

        <!--/.col (right) -->
    </div>
    <!-- /.row -->
@endsection