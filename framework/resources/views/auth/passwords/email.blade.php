@extends('layouts.app')

@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><img src="{{ asset('assets/1x/login-logo.png') }}"></a>
  </div>
  <!-- /.login-logo -->
        <div class="login-box-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf

                        <div class="form-group has-feedback">
                            <label for="email" class="col-form-label text-md-right">@lang('equicare.email_add')</label>


                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-flat">
                                    @lang('equicare.send_reset_link')
                                </button>
                        </div>
                    </form>
                </div>
            </div>

@endsection
