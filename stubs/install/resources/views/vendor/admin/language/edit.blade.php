

@extends('admin::layouts.app')

@section('content')

    <div id="content">
		<div class="container-fluid">
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="page-header">
						<h1>{{ trans('admin::language.heading.edit') }}</h1>
						<ul class="breadcrumb">
							<li><a href="{{ route('admin') }}">{{ trans('admin::home.heading.title') }}</a></li>
							<li><a href="{{ route('admin.language.index') }}">{{ trans('admin::language.heading.index') }}</a></li>
							<li><a href="{{ route('admin.language.edit',['id'=>$language->id]) }}">{{ trans('admin::language.heading.edit') }}</a></li>
						</ul>
						<div class="pull-right">
							<button type="submit" form="form" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="{{ trans('admin::app.button.save') }}"><i class="fa fa-save"></i></button>
							<a href="{{ route('admin.language.index') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="{{ trans('admin::app.button.cancel') }}"><i class="fa fa-reply"></i></a>
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
					<form method="POST" action="{{ route('admin.language.edit',['id'=>$language->id]) }}" class="form-horizontal" id="form">
	            		{{ csrf_field() }}
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab-general" data-toggle="tab">{{ trans('admin::app.tab.general') }}</a></li>
						</ul>
						<div class="tab-content">
				            <div class="tab-pane active" id="tab-general">
				            	
				            	<div class="form-group ">
									<label class="col-sm-2 control-label">{{ trans('admin::language.form.code') }}</label>
									<div class="col-sm-10">
										<div class="form-control" >{{ $language->code }}</div>
									</div>
								</div>
								
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-title">{{ trans('admin::language.form.title') }}</label>
									<div class="col-sm-10">
										<input name="title" value="{{ old('title')?old('title'):$language->title }}" placeholder="{{ trans('admin::language.form.title') }}" id="input-title" class="form-control" type="text">
									</div>
								</div>
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-status">{{ trans('admin::language.form.status') }}</label>
									<div class="col-sm-10">
										<select name="status" id="input-status" class="form-control" >
											@if( old('status') )
												<option value="1" selected="selected">@Lang('admin::app.text.enabled')</option>
												<option value="0" >@Lang('admin::app.text.disabled')</option>
											@elseif( $language->status )
												<option value="1" selected="selected">@Lang('admin::app.text.enabled')</option>
												<option value="0" >@Lang('admin::app.text.disabled')</option>
											@else
												<option value="1" >@Lang('admin::app.text.enabled')</option>
												<option value="0" selected="selected">@Lang('admin::app.text.disabled')</option>
											@endif
										</select>
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
