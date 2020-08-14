<!DOCTYPE html>
<html>
<head>
  <?php $settings = settings(); ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $settings->site_title != '' ? $settings->site_title : 'Admin Panel' }} | Dashboard</title>
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset($settings->favicon) }}" />
  <link rel="icon" type="image/x-icon" href="{{ asset($settings->favicon) }}" sizes="16x16"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('assets/admin/bootstrap/css/bootstrap.min.css') }}">

   <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/iCheck/all.css') }}">
  @yield('styles')
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.css') }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/skins/_all-skins.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <style type="text/css">
        a#cke_Upload_131,a#cke_Upload_133 {display:none !important; }
    </style>
  <!-- jQuery 2.2.3 -->
<script src="{{ asset('assets/admin/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script> var base_url = "{{ URL::to('/') }}"</script>
<script src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/admin') }}" class="logo bg-green">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini bg-green">{{ $settings->short_title != '' ? $settings->short_title : "<b>A</b>P" }}</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg bg-green">{{ $settings->site_title != '' ? $settings->site_title : "<b>Admin</b>Panel" }}</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top bg-green">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <img src="{{ URL::asset(user_avatar()) }}" alt="user_avatar" width="50" height="50" class="pull-left img-circle" style=" border: 2px solid #fff; ">
            <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->

          <!-- Notifications: style can be found in dropdown.less -->

          <!-- Tasks: style can be found in dropdown.less -->

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">{{ $settings->site_title != '' ? $settings->site_title : "<b>Admin</b>Panel" }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                    @if(file_exists(public_path($settings->logo)) &&  $settings->logo!='')
                        <img src="{{URL::asset($settings->logo)}}" alt="{{ $settings->site_title != '' ? $settings->site_title : 'Admin Panel' }}" >
                    @endif

                <p>{{ $settings->site_title != '' ? $settings->site_title : 'Admin Panel' }}</p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ url('admin/users/profile') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ url('admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                  <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->

        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- search form -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">

        <li class="active">
          <a href="{{ url('/') }}" target="_blank">
            <i class="fa fa-eye"></i> <span>Go to Homepage</span>
          </a>
        </li>

        <li class="active">
          <a href="{{ url('/admin/home') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

{{--        <li class="active">--}}
{{--          <a href="{{ url('/admin/notification') }}">--}}
{{--            <i class="fa fa-bell"></i> <span>Notification</span>--}}
{{--          </a>--}}
{{--        </li>--}}

        <li class="active">
          <a href="{{ url('/admin/web-settings') }}">
            <i class="fa fa-cog"></i> <span>Web Settings</span>
          </a>
        </li>
        
        {{--
        <li class="active">
          <a href="{{ url('/admin/home-slider') }}">
            <i class="fa fa-sliders"></i> <span>Home Slider</span>
          </a>
        </li>
        --}}

        <li class="treeview">
            <a href="javascript:;">
            <i class="fa fa-briefcase"></i>
            <span>Business</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/admin/pages') }}"><i class="fa fa-table"></i> All Business</a></li>
            <li><a href="{{ url('/admin/pages/add') }}"><i class="fa fa-plus-square-o"></i> Add New</a></li>
          </ul>
        </li>



         <li class="treeview">
            <a href="javascript:;">
            <i class="fa fa-list"></i>
            <span>users listing</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/admin/user') }}"><i class="fa fa-table"></i>all users</a></li>
            <li><a href="{{ url('/admin/user/add') }}"><i class="fa fa-plus-square-o"></i> Add New</a></li>
          </ul>
        </li>

	    
         <li class="treeview">
            <a href="javascript:;">
            <i class="fa fa-list"></i>
            <span>Daily Special Running</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/admin/daily_special')}}"><i class="fa fa-table"></i>All</a></li>
            <li><a href="{{url('admin/daily_special/add')}}"><i class="fa fa-plus-square-o"></i> Add New</a></li>
          </ul>
        </li>
      

       <li class="treeview">
            <a href="javascript:;">
            <i class="fa fa-briefcase"></i>
            <span>Appointment</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/admin/appointment') }}"><i class="fa fa-table"></i> All </a></li>
            <li><a href="{{ url('/admin/appointment/add') }}"><i class="fa fa-plus-square-o"></i> Add New</a></li>
          </ul>
        </li>
       
          <li class="treeview">
            <a href="javascript:;">
            <i class="fa fa-first-order"></i>
            <span>order</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('/admin/order') }}"><i class="fa fa-table"></i> All </a></li>
          
          </ul>
        </li>
           <li class="treeview">
            <a href="#">
              <i class="fa fa fa-commenting"></i> <span>Notification</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
          
          </li>
           <li class="treeview">
            <a href="#">
              <i class="fa fa fa-commenting"></i> <span>Chat data</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
          
          </li>
          <li class="treeview">
              <a href="#">
                  <i class="fa fa-bullhorn"></i> <span>Announcements</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
             
          </li>
           <li class="treeview">
            <a href="#">
              <i class="fa fa fa-commenting"></i> <span>Business Stats</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
          
          </li>


        <li class="active">
            <a href="{{ url('/admin/general-settings') }}"><i class="fa fa-cog"></i> <span>Settings</span> </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content">
    @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
     @if (Session::has('message'))
     <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ Session::get('message') }}
              </div>
     @endif

      @if (Session::has('error'))
     <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                {{ Session::get('error') }}
              </div>
     @endif

        @yield('content')

      </section>
        </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <!--<b>Version</b> 2.3.8-->
    </div>
    <strong>Copyright &copy; <?php echo date("Y",strtotime("-1 year")).'-'.date('Y');?> <a target="_blank" href="{{ $settings->website != '' ? $settings->website : '#' }}">{{ $settings->site_title != '' ? $settings->site_title : 'Admin Panel' }}</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>



<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('assets/admin/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/admin/bootbox.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
     $("#example1").DataTable({
         "order": [],
         "columnDefs": [ {
          "targets": 'no-sort',
          "orderable": false,
            }]
         });

     $('#example1').on( 'page.dt', function () {
        $('html, body').animate({
            scrollTop: 0
        }, 300);
    });

    $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<!-- FastClick -->
<script src="{{ asset('assets/admin/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/iCheck/icheck.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/admin/dist/js/app.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/admin/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
@yield('scripts')
<script>
    $(function(){
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
       // alert(maxDate);
        $('#valid_till').attr('min', maxDate);
    });
</script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/admin/dist/js/demo.js') }}"></script>

<script src="{{ asset('assets/admin/admin.js') }}"></script>



<!-- push notification-->


<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.17.2/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyDsVywia-S2mcyKDp6ZxZQAGtkvovh-yvA",
    authDomain: "my-tutorials-3754a.firebaseapp.com",
    databaseURL: "https://my-tutorials-3754a.firebaseio.com",
    projectId: "my-tutorials-3754a",
    storageBucket: "my-tutorials-3754a.appspot.com",
    messagingSenderId: "1000022360340",
    appId: "1:1000022360340:web:1b6378fd418412a52c4201"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>


</body>
</html>
