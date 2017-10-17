@extends('admin::layouts.app')

@section('content')<br><br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title"><i class="fa fa-lock"></i>
                        {{ trans('admin::login.heading.title') }}
                    </h1>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('admin.login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user">
                                    </i>
                                </span>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('admin::login.form.email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-lock">
                                    </i>
                                </span>
                                <input id="password" type="password" class="form-control" name="password" placeholder="{{ trans('admin::login.form.password') }}" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-key"></i>
                                {{ trans('admin::app.button.login') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
