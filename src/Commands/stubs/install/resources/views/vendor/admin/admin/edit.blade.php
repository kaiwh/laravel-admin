@extends('admin::layouts.app')

@section('content')

    <div id="content">
		<div class="container-fluid">
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="page-header">
						<h1>{{ trans('admin::admin.heading.edit') }}</h1>
						<ul class="breadcrumb">
							<li><a href="{{ route('admin') }}">{{ trans('admin::home.heading.title') }}</a></li>
							<li><a href="{{ route('admin.admin.index') }}">{{ trans('admin::admin.heading.index') }}</a></li>
							<li><a href="{{ route('admin.admin.edit',['id'=>$admin->id]) }}">{{ trans('admin::admin.heading.edit') }}</a></li>
						</ul>
						<div class="pull-right">
							<button type="submit" form="form" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="{{ trans('admin::app.button.save') }}"><i class="fa fa-save"></i></button>
							<a href="{{ route('admin.admin.index') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="{{ trans('admin::app.button.cancel') }}"><i class="fa fa-reply"></i></a>
						</div>
					</div>
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
					<form method="POST" action="{{ route('admin.admin.edit',['id'=>$admin->id]) }}" class="form-horizontal" id="form">
	            		{{ csrf_field() }}
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab-general" data-toggle="tab">{{ trans('admin::app.tab.general') }}</a></li>
							<li><a href="#tab-permission" data-toggle="tab">{{ trans('admin::app.tab.permission') }}</a></li>
						</ul>
						<div class="tab-content">
				            <div class="tab-pane active" id="tab-general">
				            	<div class="form-group required">
									<label class="col-sm-2 control-label">{{ trans('admin::admin.form.email') }}</label>
									<div class="col-sm-10">
										<div class="form-control" >{{ $admin->email }}</div>
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-name">{{ trans('admin::admin.form.name') }}</label>
									<div class="col-sm-10">
										<input name="name" value="{{ old('name')?old('name'):$admin->name }}" placeholder="{{ trans('admin::admin.form.name') }}" id="input-name" class="form-control" type="text">
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-password">{{ trans('admin::admin.form.password') }}</label>
									<div class="col-sm-10">
										<input name="password" value="{{ old('password') }}" placeholder="{{ trans('admin::admin.form.password') }}" id="input-password" class="form-control" type="password">
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-password_confirmation">{{ trans('admin::admin.form.password_confirmation') }}</label>
									<div class="col-sm-10">
										<input name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="{{ trans('admin::admin.form.password_confirmation') }}" id="input-password_confirmation" class="form-control" type="password">
									</div>
								</div>
				            </div>
				            <div class="tab-pane" id="tab-permission">
				            	@php 
				            		$permission = [];
				            		if(old('permission')){
				            			$permission = old('permission');
				            		}
				            		elseif($admin->permission){
				            			$permission = $admin->permission();
				            		}
				            	@endphp
				            	<div class="form-group">
									<label class="col-sm-2 control-label">{{ trans('admin::admin.permission.index') }}：</label>
									<div class="col-sm-6">
										<div class="well well-sm" style="height: 300px; overflow: auto;">
											@foreach($authorizes as $value)
											<div class="checkbox">
												<label>
													<input name="permission[]" value="{{ $value['value'] }}" type="checkbox" {{ in_array($value['value'],$permission)?'checked':'' }} >
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
