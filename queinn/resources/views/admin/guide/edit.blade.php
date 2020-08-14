@extends('layouts.adminapp')

@section('content')

    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-tasks"></i> Add Guide</h3>
                    <a href="{{ url('/admin/guide') }}" class="btn btn-warning pull-right">Cancel</a>
                </div>
                <!-- /.box-header -->

                <form class="form-horizontal" role="form" method="POST" id="admin_login" action="{{ url('/admin/guide/edit').'/'.$editGuide->id }}">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                            {{ csrf_field() }}
                            <!-- text input -->
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-sm-2 control-label">Name<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" value="@if($editGuide->name!= '') {{ $editGuide->name }}@else {{ old('name') }}@endif">
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label for="link" class="col-sm-2 control-label">Description<span style="color: red;"> *</span></label>
                                    <div class="col-sm-10">
                                     <textarea id="editor1" name="description" rows="10" cols="80">
                                          @if($editGuide->description!= '') {{ $editGuide->description }}@else {{ old('description') }}@endif
                                    </textarea>
                                    </div>
                                </div>

{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <hr />--}}
{{--                                    <div class="form-group">--}}
{{--                                        <label for="page_title" class="col-sm-2 control-label">Page Title</label>--}}
{{--                                        <div class="col-sm-10">--}}
{{--                                            <textarea class="form-control" rows="3" id="page_title" name="page_title" placeholder="Page Title.">{{ old('page_title') }}</textarea>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="form-group">--}}
{{--                                        <label for="page_keyword" class="col-sm-2 control-label">Page Keyword</label>--}}
{{--                                        <div class="col-sm-10">--}}
{{--                                            <textarea class="form-control" rows="3" id="page_keyword" name="page_keyword" placeholder="Page Keyword.">{{ old('page_keyword') }}</textarea>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="form-group">--}}
{{--                                        <label for="page_description" class="col-sm-2 control-label">Page Description</label>--}}
{{--                                        <div class="col-sm-10">--}}
{{--                                            <textarea class="form-control" rows="3" id="page_description" name="page_description" placeholder="Page Description.">{{ old('page_description') }}</textarea>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info pull-right">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </form>

            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
@endsection

@section('styles')
    <!-- CK Editor -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datepicker/datepicker3.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/select2.min.css') }}">
@stop

@section('scripts')
    <!-- CK Editor -->
    <script src="{{ asset('assets/admin/plugins/ckeditor/ckeditor.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

    <script src="{{ asset('assets/admin/plugins/select2/select2.full.min.js') }}"></script>
    <script>

        $(function () {
            $(".select2").select2();
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor1',{
                extraPlugins: 'uploadimage',

                filebrowserBrowseUrl: "{{ asset('assets/admin/plugins/ckfinder/ckfinder.html') }}",
                filebrowserImageBrowseUrl: "{{ asset('assets/admin/plugins/ckfinder/ckfinder.html?type=Images') }}",
                filebrowserUploadUrl: "{{ asset('assets/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",
                filebrowserImageUploadUrl: "{{ asset('assets/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}"
            });
        });

    </script>
@stop