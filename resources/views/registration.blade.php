@extends('master')
@section('content')
<body>
<div class="container-fluid">
  <div class="row no-gutter">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login d-flex align-items-center py-5">
        <div class="container-fluid">
          <div class="row ml">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4">Register here!</h3>
               <form action="{{url('post-registration')}}" method="POST" id="regForm" autocomplete="off">
                 {{ csrf_field() }} 
                <div class="form-label-group">
                <label for="inputName">Name</label>
                  <input type="text" id="inputName" name="name" class="form-control" placeholder="Full name" autofocus>  

                  @if ($errors->has('name'))
                  <span class="error">{{ $errors->first('name') }}</span>
                  @endif       
 
                </div> 
                <label for="inputEmail">Email address</label>
                <div class="form-label-group">
                  <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" > 
 
                  @if ($errors->has('email'))
                  <span class="error">{{ $errors->first('email') }}</span>
                  @endif    
                </div> 
 
                <div class="form-label-group"> 
                 <label for="inputPassword">Password</label>
                  <input type="password" name="user_password" id="inputPassword" class="form-control" placeholder="Password"> 
                   
                  @if ($errors->has('password'))
                  <span class="error">{{ $errors->first('user_password') }}</span>
                  @endif  
                </div>
 
                <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Sign Up</button>
                <div class="text-center">If you have an account?
                  <a class="small" href="{{url('login')}}">Sign In</a></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 @endsection
