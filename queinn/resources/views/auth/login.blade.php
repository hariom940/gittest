@extends('layouts.app')

@section('content')
    <div class="wrapper">
        <section class="login-screen">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 bg-grey">
                        <div class="title">Sign in</div>
                        <small>Welcome back! Sign in to your account</small>
                        <form role="form" method="POST" action="{{ route('login') }}">

                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="name">Username or Email Address<span>*</span></label>
                                <input type="text" class="form-control" id="name" name="email" placeholder="Username or Email Address*" value="{{ old('email') }}" required autofocus />

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">Password<span>*</span></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password*"  />

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <div class="float-left">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="float-right">
                                <a href="javascript:void(0);" class="fr-psswrd" data-toggle="modal" data-target="#forgot-popup">Forgot Password?</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="buttons">
                                <button type="submit" class="btn btn-green btn-login hvr-wobble-horizontal">Sign In</button>
                                <a href="javascript:void(0);" class="login-with-otp" data-toggle="modal" data-target="#get-otp-popup">Use OTP instead?</a>
                            </div>
                        </form>
                    </div>
                    <div class="or">or</div>
                    <div class="col-md-6">
                        <div class="title">Sign in With</div>
                        <div class="social-login-buttons">
                            <a href="{{ url('login/facebook') }}" class="btn btn-fb hvr-wobble-horizontal"><i class="fab fa-facebook-f"></i> Sign in with Facebook</a>
                            <a href="{{ url('login/google') }}" class="btn btn-g hvr-wobble-horizontal"><i class="fab fa-google"></i> Sign in with Google</a>
                        </div>
                        <div class="title">Don't have an Account?</div>
                        <small>Create Your very own HappySTEMS Account</small>
                        <a href="{{ route('register') }}" class="btn btn-green btn-register hvr-wobble-horizontal">Sign Up</a>
                    </div>
                </div>
            </div>
        </section>
        <div class="flowerStrip"></div>
    </div>

    <div class="modal fade get-otp-popup" id="get-otp-popup" tabindex="-1" role="dialog" aria-labelledby="get-otp-popuplabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="img/otp-popup.svg" class="img-fluid">
                    <h3>Login with OTP</h3>
                    <p>Enter your 10 digit mobile number</p>
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="btnGroupAddon">+91</div>
                            </div>
                            <input type="tel" class="form-control" placeholder="Mobile Number" aria-label="Input group mobile" maxlength="10" minlength="10" />
                        </div>
                        <button type="submit" class="btn btn-green hvr-wobble-horizontal">Get OTP</button>
                        <p data-dismiss="modal" data-toggle="modal" data-target="#otp-popup">OTP Screen</p>
                    </form>
                </div>
                <a href="javascript:void(0);" data-dismiss="modal" class="login-email"><i class="fal fa-chevron-left"></i> Login with Email</a>
            </div>
        </div>
    </div>

    <div class="modal fade forgot-popup" id="forgot-popup" tabindex="-1" role="dialog" aria-labelledby="forgot-popuplabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3>Forgot Password?</h3>
                    <p>Enter your 10 digit mobile number to reset the password.</p>
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text" id="btnGroupAddon">+91</div>
                            </div>
                            <input type="tel" class="form-control" placeholder="Mobile Number" aria-label="Input group mobile" maxlength="10" minlength="10" required />
                        </div>
                        <button type="submit" class="btn btn-green hvr-wobble-horizontal">Get OTP</button>
                    </form>
                </div>
                <a href="javascript:void(0);" data-dismiss="modal" class="login-email"><i class="fal fa-times"></i> Close</a>
            </div>
        </div>
    </div>

    <div class="modal fade otp-popup" id="otp-popup" tabindex="-1" role="dialog" aria-labelledby="otp-popuplabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h3>OTP sent successfully.</h3>
                    <p>Please enter 4 digit OTP sent to<br /><span>xxxx-xxxx-93</span>.</p>
                    <form>
                        <input type="text" class="form-control" placeholder="4 digit code" required />
                        <button type="submit" class="btn btn-green">Verify OTP</button><br />
                        <a href="oops.html" class="resend"><i class="fa fa-redo-alt"></i> Resent OTP</a> 00:30
                    </form>
                </div>
                <a href="javascript:void(0);" data-dismiss="modal" class="login-email"><i class="fal fa-times"></i> Close</a>
            </div>
        </div>
    </div>
@endsection
