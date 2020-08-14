@extends('layouts.adminapp')

@section('content')

<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <!-- Horizontal Form -->
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Web Settings</h3>
      </div>
      <!-- /.box-header -->

      <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/web-settings') }}"
        enctype="multipart/form-data">
        <div class="box-body">
          {{ csrf_field() }}
          <!-- text input -->

          <div class="form-group">
            <label for="facebook_url" class="col-sm-2 control-label">Facebook URL</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" id="facebook_url" name="facebook_url"
                value="{{ $websettings->facebook_url != '' ? $websettings->facebook_url : old('facebook_url') }}"
                placeholder="Facebook URL.">
            </div>
          </div>

          <div class="form-group">
            <label for="twitter_url" class="col-sm-2 control-label">Twitter URL</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" id="twitter_url" name="twitter_url"
                value="{{ $websettings->twitter_url != '' ? $websettings->twitter_url : old('twitter_url') }}"
                placeholder="Twitter URL.">
            </div>
          </div>

          <div class="form-group">
            <label for="linkedin_url" class="col-sm-2 control-label">Linkedin URL</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" id="linkedin_url" name="linkedin_url"
                     value="{{ $websettings->linkedin_url != '' ? $websettings->linkedin_url : old('linkedin_url') }}"
                     placeholder="Linkedin URL.">
            </div>
          </div>


            <div class="form-group">
            <label for="youtube_url" class="col-sm-2 control-label">Youtube URL</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" id="youtube_url" name="youtube_url"
                value="{{ $websettings->youtube_url != '' ? $websettings->youtube_url : old('youtube_url') }}"
                placeholder="Youtube URL.">
            </div>
          </div>

          <div class="form-group">
            <label for="insta_url" class="col-sm-2 control-label">Instagram URL</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" id="insta_url" name="insta_url"
                value="{{ $websettings->instagram_url != '' ? $websettings->instagram_url : old('instagram_url') }}"
                placeholder="Instagram URL.">
            </div>
          </div>

          <div class="form-group">
            <label for="gplus_url" class="col-sm-2 control-label">Google Plus URL</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" id="gplus_url" name="gplus_url"
                value="{{ $websettings->google_plus_url != '' ? $websettings->google_plus_url : old('google_plus_url') }}"
                placeholder="Google Plus URL.">
            </div>
          </div>

          <div class="form-group">
            <label for="tumblr_url" class="col-sm-2 control-label">Tumblr URL</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" id="tumblr_url" name="tumblr_url"
                value="{{ $websettings->tumblr_url != '' ? $websettings->tumblr_url : old('tumblr_url') }}"
                placeholder="Tumblr URL.">
            </div>
          </div>

          <div class="box-footer">
            <button type="submit" class="btn btn-info pull-right">Save Settings</button>
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
@section('scripts')
<!-- CK Editor -->
<script src="{{ asset('assets/admin/plugins/ckeditor/ckeditor.js') }}"></script>

<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1', {
      extraPlugins: 'uploadimage',

      filebrowserBrowseUrl: "{{ asset('assets/admin/plugins/ckfinder/ckfinder.html') }}",
      filebrowserImageBrowseUrl: "{{ asset('assets/admin/plugins/ckfinder/ckfinder.html?type=Images') }}",
      filebrowserUploadUrl: "{{ asset('assets/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}",
      filebrowserImageUploadUrl: "{{ asset('assets/admin/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}"
    });
  });
</script>

@stop