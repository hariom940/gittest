@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <section class="login-screen register-screen">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 bg-grey">
                        <div class="title">Create Account</div>
                        <small>Create Your very own HappyStems Account</small>
                        <form role="form" method="POST" action="{{ route('register') }}">

                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label for="fname">First Name<span>*</span></label>
                                        <input type="text" class="form-control" id="fname" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required />

                                            @if ($errors->has('first_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label for="lname">Last Name<span>*</span></label>
                                        <input type="text" class="form-control" id="lname" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required />

                                            @if ($errors->has('last_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email">Email Address<span>*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required />

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label for="mobile">Mobile Number<span>*</span></label>
                                        <input type="number" class="form-control" id="mobile" name="phone" placeholder="Mobile Number" value="{{ old('phone') }}" required />
                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password">Password<span>*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="cpassword">Confirm Password<span>*</span></label>
                                        <input type="password" class="form-control" id="cpassword" name="password_confirmation" placeholder=" Confirm Password" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="privacy" class="form-check-input" value="" required> I have read and agree to the <a href="404.html"/>Privacy Policy</a>
                                </label>
                            </div>
                            <div class="clearfix"></div>
                            <div class="buttons">
                                <button type="submit" class="btn btn-green btn-register hvr-wobble-horizontal">Sign up</button>
                            </div>
                        </form>
                    </div>
                    <div class="or">or</div>
                    <div class="col-md-6">
                        <h5>Sign up today and you will be able to:</h5>
                        <ul>
                            <li><i class="far fa-check"></i> Speed your way through the checkout</li>
                            <li><i class="far fa-check"></i> Track your orders easily</li>
                            <li><i class="far fa-check"></i> Keep a record of all your purchases</li>
                        </ul>
                        <div class="title">Sign up With</div>
                        <div class="social-login-buttons">
                            <a href="{{ url('login/facebook') }}" class="btn btn-fb hvr-wobble-horizontal"><i class="fab fa-facebook-f"></i> Sign in with Facebook</a>
                            <a href="{{ url('/login/google') }}" class="btn btn-g hvr-wobble-horizontal"><i class="fab fa-google"></i> Sign in with Google</a>
                        </div>
                        <div class="title">Already have an Account?</div>
                        <small>If you already have an account with us, please click the below buton</small>
                        <a href="{{ route('login') }}" class="btn btn-green btn-login hvr-wobble-horizontal">Sign In</a>
                    </div>
                </div>
            </div>
        </section>
        <div class="clearfix"></div>
        <div class="flowerStrip"></div>
    </div>
@endsection
