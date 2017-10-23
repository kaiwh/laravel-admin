@extends('admin::layouts.app')

@section('content')
    <div id="content">
    	<div class="page-header">
    		<div class="container-fluid">
				<h1>@Lang('admin::admin.heading.create')</h1>
				<ul class="breadcrumb">
					<li><a href="{{ route('admin') }}">@Lang('admin::home.heading.index')</a></li>
					<li><a href="{{ route('admin.admin.index') }}">@Lang('admin::admin.heading.index')</a></li>
					<li><a href="{{ route('admin.admin.create') }}">@Lang('admin::admin.heading.create')</a></li>
				</ul>
				<div class="pull-right">
					<button type="submit" form="form" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="@Lang('admin::app.button.save')"><i class="fa fa-save"></i></button>
					<a href="{{ route('admin.admin.index') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="@Lang('admin::app.button.cancel')"><i class="fa fa-reply"></i></a>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-pencil"></i> @Lang('admin::admin.heading.create')</h3>
				</div>
				<div class="panel-body">
					@if (count($errors) > 0)
					    <div class="alert alert-danger"  role="alert">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					<form method="POST" action="{{ route('admin.admin.create') }}" class="form-horizontal" id="form">
	            		{{ csrf_field() }}
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab-general" data-toggle="tab">@Lang('admin::app.tab.general')</a></li>
							<li><a href="#tab-permission" data-toggle="tab">@Lang('admin::app.tab.permission')</a></li>
						</ul>
						<div class="tab-content">
				            <div class="tab-pane active" id="tab-general">
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-name">@Lang('admin::admin.form.name')</label>
									<div class="col-sm-10">
										<input name="name" value="{{ old('name') }}" placeholder="@Lang('admin::admin.form.name')" id="input-name" class="form-control" type="text">

									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-email">@Lang('admin::admin.form.email')</label>
									<div class="col-sm-10">
										<input name="email" value="{{ old('email') }}" placeholder="@Lang('admin::admin.form.email')" id="input-email" class="form-control" type="email">
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-password">@Lang('admin::admin.form.password')</label>
									<div class="col-sm-10">
										<input name="password" value="{{ old('password') }}" placeholder="@Lang('admin::admin.form.password')" id="input-password" class="form-control" type="password">
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-password_confirmation">@Lang('admin::admin.form.password_confirmation')</label>
									<div class="col-sm-10">
										<input name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="@Lang('admin::admin.form.password_confirmation')" id="input-password_confirmation" class="form-control" type="password">
									</div>
								</div>
				            </div>
							<div class="tab-pane" id="tab-permission">
								<div class="form-group">
									<label class="col-sm-2 control-label">@Lang('admin::admin.form.permission')</label>
									<div class="col-sm-6">
										<div class="well well-sm" style="height: 300px; overflow: auto;">
											@foreach($authorizes as $value)
											<div class="checkbox">
												<label>
													<input name="permission[]" value="{{ $value['value'] }}" type="checkbox">
													{{ $value['title'] }}
												</label>
											</div>
											@endforeach
		                              	</div>
	              					</div>
	              					<div class="col-sm-4">
	              						<a href="javascript:;" onclick="$(this).parents('.form-group').find(':checkbox').prop('checked', true);">全选</a>
	              						 / 
	              						<a href="javascript:;" onclick="$(this).parents('.form-group').find(':checkbox').prop('checked', false);">取消选择</a>
	              					</div>	
	          					</div>
						

							</div>
	       				</div>
	       			</form>
				</div>			
			</div>
			
	    </div>
	</div>
    
@endsection
