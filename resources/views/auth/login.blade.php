@extends('layouts.app')

@section('content')
<div class="nav-item" style="text-align:center">
    <a href="/home" class="navbar-brand"><img src="/storage/images/mail4.png" style="width:auto; height:40px;margin: 16px 0 17px;"></a>
    <a href="/home" class="navbar-brand"><img src="/storage/images/logo4.png" style="width:auto; height:20px;"></a>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header" style="font-size:20px">Пожалуйста войдите в систему</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf
                        <div class="form-group row" style="padding: 0px 30px; margin-bottom:0px;color:#005aac">
                          <label for="email" class="col-form-label">Email</label>
                        </div>
                        <div class="form-group row" style="padding: 0px 30px;">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group row" style="padding: 0px 30px; margin-bottom:0px;color:#005aac">
                          <label for="password" class="col-form-label">Пароль</label>
                        </div>
                        <div class="form-group row" style="padding: 0px 30px;">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group row" style="padding: 0px 30px;">
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                              <label class="form-check-label" for="remember">
                                  Запомнить меня
                              </label>
                          </div>
                        </div>
                        <div class="form-group row" style="padding: 0px 30px;">
                            <button style="margin-left: 10px;" type="submit" class="btn btn-primary">
                                Войти
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
