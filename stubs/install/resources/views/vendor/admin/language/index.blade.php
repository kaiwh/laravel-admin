@extends('admin::layouts.app')

@section('content')
    <div id="content">
		<div class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="page-header">
						<h1>{{ trans('admin::language.heading.index') }}</h1>
						<ul class="breadcrumb">
							<li><a href="{{ route('admin') }}">{{ trans('admin::home.heading.title') }}</a></li>
							<li><a href="{{ route('admin.language.index') }}">{{ trans('admin::language.heading.index') }}</a></li>
						</ul>
						<div class="pull-right">
							<a href="{{ route('admin.language.create') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="{{ trans('admin::app.button.create') }}"><i class="fa fa-plus"></i></a>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td class="text-left">{{ trans('admin::language.form.title') }}</td>
									<td class="text-left">{{ trans('admin::language.form.code') }}</td>
									<td class="text-left">{{ trans('admin::language.form.status') }}</td>
									<td class="text-right">{{ trans('admin::app.text.action') }}</td>
								</tr>
							</thead>
							<tbody>
								@foreach ($languages as $value)
								<tr>
									<td class="text-left">
										{{ $value->title }}
										@if(App::getLocale()==$value->code)
										<span class="badge">@Lang('admin::language.text.locale')</span>
										@endif
									</td>
									<td class="text-left">{{ $value->code }}</td>
									<td class="text-left">
										@if($value->status)
											@Lang('admin::app.text.enabled')
										@else
											@Lang('admin::app.text.disabled')
										@endif
									</td>
									<td class="text-right">
										{{-- <a href="{{ route('admin.language.setLocale',['code'=>$value->code]) }}" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="{{ trans('admin::language.text.setLocale') }}"><i class="fa fa-language"></i></a> --}}
										<a href="{{ route('admin.language.edit',['id'=>$value->id]) }}" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="{{ trans('admin::app.button.edit') }}"><i class="fa fa-pencil"></i></a>
										<a href="{{ route('admin.language.destroy',$value->id) }}" onclick="return confirm('@Lang('admin::app.confirm.delete')')?true:false"  data-toggle="tooltip" title="" class="btn btn-warning" data-original-title="{{ trans('admin::app.button.delete') }}"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="text-right">
						{{ $languages->links() }}
					</div>
				</div>
			</div>
	    </div>
	</div>
    
@endsection
