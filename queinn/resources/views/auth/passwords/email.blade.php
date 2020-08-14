@extends('layouts.app')

@section('content')
<div class="login-page">
<div class="overlay">
<div class="container">
    <div class="row">	
	<div class="col-md-6 col-sm-6 col-xs-12 left">
	{!! $page->description !!}
	</div>
		
        <div class="col-md-6 col-sm-6 col-xs-12 right">
            <div class="panel panel-default register-page">
                <div class="panel-heading">{!! $page->title !!}</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (Session::has('message'))
                        {!! successMesaage(Session::get('message')) !!}   
                    @endif
                        {!! validationError($errors) !!} 
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
