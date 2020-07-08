<html lang="en">
<head>
  <title>Task Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
     <a class="navbar-brand" href="#">TaskSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="{{route('user_login')}}">User</a></li>
      <li><a href="{{route('login')}}">Admin</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Link</a></li>
      <li><a href="#">contact</a></li>
      <li><a href="#">policy</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  
    @yield('content')
  
  <div class="footer navbar-bottom text-center">
<h6> this is copyright@:2020 </h6>
  </div>
</div>
</body>
</html>