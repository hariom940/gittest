<!DOCTYPE html>

<html>

<head>
<?php $settings = settings(); ?>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>{{ $settings->site_title != '' ? $settings->site_title : 'Admin Panel' }} | Admin Log in</title>

  <!-- Tell the browser to be responsive to screen width -->

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.6 -->

  <link rel="stylesheet" href="{{ asset('assets/admin/bootstrap/css/bootstrap.min.css') }} ">

  <!-- Font Awesome -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

  <!-- Ionicons -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="{{ asset('assets/admin//dist/css/AdminLTE.min.css') }}">

  <!-- iCheck -->

  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/iCheck/square/blue.css') }}">



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

  <!--[if lt IE 9]>

  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->

</head>

<body class="hold-transition login-page" style="background: url({{ asset('assets/cgfront/img/bannerImg.jpg') }})">
<div class="col-md-8 overlay">
    {{--    <h1 style="position: absolute; top: 40%; left: 20%; color: #fff;">{{ $settings->site_title }}</h1>--}}
</div>

<div class="col-md-4 login-box">

<div class="login-logo">

    <img src ="{{URL::asset($settings->logo)}}" width="230" class="img-circle" style="width: 100px; border: 1px solid #cccbcb;" />

  </div>

  <!-- /.login-logo -->

  <div class="login-box-body">

        

        <p class="login-box-msg">Forgot Password</p>

           <form role="form" method="POST" id="admin_login" action="{{ url('/admin/forgot-password') }}">

                        {{ csrf_field() }}

            @if (Session::has('message'))

        <div class="alert alert-success">

         {{ Session::get('message') }}

        </div>

        @endif

        

        @if ($errors->any()) 

        <div class="alert alert-danger">

            <ul>

                {!! implode('', $errors->all('

                <li class="error">:message</li>

                ')) !!}

            </ul>

        </div>

       @endif    

                   

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">

            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))

                <span class="help-block">

                    <strong>{{ $errors->first('email') }}</strong>

                </span>

            @endif

            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

          </div>

          <div class="row">

            <div class="col-xs-8">

            </div><!-- /.col -->

            <div class="col-xs-12">

			<a href="{{url('admin/login')}}">Back to Login</a>

             <button type="submit" class="btn btn-primary" style="float: right;">

                                    Send

                                </button>

            </div><!-- /.col -->

          </div>

                   </form>



        <div class="overlay" style="display:none;">

                  <i class="fa fa-refresh fa-spin"></i>

        </div>

        

      </div>

  <!-- /.login-box-body -->

</div>

<!-- /.login-box -->



<!-- jQuery 2.2.3 -->

<script src="{{ asset('assets/admin/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

<!-- Bootstrap 3.3.6 -->

<script src="{{ asset('assets/admin/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- iCheck -->

<script src="{{ asset('assets/admin/plugins/iCheck/icheck.min.js') }}"></script>

<script>

  $(function () {

    $('input').iCheck({

      checkboxClass: 'icheckbox_square-blue',

      radioClass: 'iradio_square-blue',

      increaseArea: '20%' // optional

    });

  });

  var base_url = "{{ url('/')}}";

</script>

</body>

</html>

