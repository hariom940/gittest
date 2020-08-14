@extends('layouts.adminapp')

@section('content')

      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">General Settings</h3>
            </div>
            <!-- /.box-header -->
            
              <form class="form-horizontal" role="form" method="POST" id="admin_login" action="{{ url('/admin/general-settings') }}" enctype="multipart/form-data">
              <div class="box-body">
              {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group{{ $errors->has('site_title') ? ' has-error' : '' }}">
                  <label for="site_title" class="col-sm-2 control-label">Admin Panel Title</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="site_title" name="site_title" value="{{ $settings->site_title != '' ? $settings->site_title : old('site_title') }}" placeholder="Site Title.">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="short_title" class="col-sm-2 control-label">Admin Panel Short Title</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="short_title" name="short_title" value="{{ $settings->short_title != '' ? $settings->short_title : old('short_title') }}" placeholder="Short Title.">
                  </div>
                </div>

                <div class="form-group">
                  <label for="tagline" class="col-sm-2 control-label">Website</label>
                  <div class="col-sm-10">
                  	<input type="url" class="form-control" id="website" name="website" value="{{ $settings->website != '' ? $settings->website : old('website') }}" placeholder="Website Address.">
                  </div>  
                </div>
                
                <div class="form-group">
                  <label for="exampleInputFile" class="col-sm-2 control-label">Logo</label>
                  <div class="col-sm-10">
                  @if(file_exists(public_path($settings->logo)) &&  $settings->logo!='')
                  	<img src="{{URL::asset($settings->logo)}}" width="100"><br/>
                  @endif  
                  	<input type="file" id="exampleInputFile" name="logo" accept="image/*">
                  </div>  
                </div>
                
                <div class="form-group">
                  <label for="examplefaviconFile" class="col-sm-2 control-label">Favicon(16 * 16) </label>
                  <div class="col-sm-10">
                  @if(file_exists(public_path($settings->favicon)) &&  $settings->favicon!='')
                  	<img src="{{URL::asset($settings->favicon) }}" width="16"><br/>
                  @else
                  	 <img src="{{URL::asset('assets/uploads/favicon.png')}}" width="16"><br/>
                  @endif  
                  	<input type="file" id="examplefaviconFile" name="favicon" accept="image/*">
                  </div>  
                </div>
                <hr />
                <div class="form-group">
                  <label for="from_name" class="col-sm-2 control-label">Google Verification Code</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="google_verification" name="google_verification" placeholder="Google Verification Code">{{ $settings->google_verification != '' ? $settings->google_verification : old('google_verification') }}</textarea>
                  </div>  
                </div>
                <hr />
                <div class="form-group">
                  <label for="from_name" class="col-sm-2 control-label">Mailchimp API KEY</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="mailchimp_api_key" name="mailchimp_api_key" value="{{ $settings->mailchimp_api_key != '' ? $settings->mailchimp_api_key : old('mailchimp_api_key') }}" placeholder="Mailchimp API KEY">
                  </div>  
                </div>

                <div class="form-group">
                  <label for="mailchimp_list_id" class="col-sm-2 control-label">Mailchimp LIST ID</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="mailchimp_list_id" name="mailchimp_list_id" value="{{ $settings->mailchimp_list_id != '' ? $settings->mailchimp_list_id : old('mailchimp_list_id') }}" placeholder="Mailchimp LIST ID">
                  </div>  
                </div>
                <hr />
                
                <div class="form-group">
                  <label for="from_name" class="col-sm-2 control-label">From Name</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="from_name" name="from_name" value="{{ $settings->from_name != '' ? $settings->from_name : old('from_name') }}" placeholder="From Name.">
                  </div>  
                </div>
                
                <div class="form-group">
                  <label for="from_email" class="col-sm-2 control-label">From Email</label>
                  <div class="col-sm-10">
                  	<input type="email" class="form-control" id="from_email" name="from_email" value="{{ $settings->from_email != '' ? $settings->from_email : old('from_email') }}" placeholder="From Email Address.">
                  </div>  
                </div>
                
                <div class="form-group">
                  <label for="smtp_host" class="col-sm-2 control-label">SMTP Host</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="smtp_host" name="smtp_host" value="{{ $settings->smtp_host != '' ? $settings->smtp_host : old('smtp_host') }}" placeholder="SMTP Host.">
                  </div>  
                </div>
                
                               
                <div class="form-group">
                  <label for="smtp_port" class="col-sm-2 control-label">SMTP Port</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="smtp_port" name="smtp_port" value="{{ $settings->smtp_port != '' ? $settings->smtp_port : old('smtp_port') }}" placeholder="SMTP Port.">
                  </div>  
                </div>
                
                <div class="form-group">
                  <label for="smtp_driver" class="col-sm-2 control-label">SMTP Driver</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="smtp_driver" name="smtp_driver" value="{{ $settings->smtp_driver != '' ? $settings->smtp_driver : old('smtp_driver') }}" placeholder="SMTP Driver.">
                  </div>  
                </div>
                
                <div class="form-group">
                  <label for="smtp_username" class="col-sm-2 control-label">SMTP Username</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="smtp_username" name="smtp_username" value="{{ $settings->smtp_username != '' ? $settings->smtp_username : old('smtp_username') }}" placeholder="SMTP Username.">
                  </div>  
                </div>
                
                 <div class="form-group">
                  <label for="smtp_password" class="col-sm-2 control-label">SMTP Password</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="smtp_password" name="smtp_password" value="{{ $settings->smtp_password != '' ? $settings->smtp_password : old('smtp_password') }}" placeholder="SMTP Password.">
                  </div>  
                </div>
                
                
                <div class="form-group">
                  <label for="smtp_encryption" class="col-sm-2 control-label">SMTP Encryption</label>
                  <div class="col-sm-10">
                  	<input type="text" class="form-control" id="smtp_encryption" name="smtp_encryption" value="{{ $settings->smtp_encryption != '' ? $settings->smtp_encryption : old('smtp_encryption') }}" placeholder="SMTP Encryption.">
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