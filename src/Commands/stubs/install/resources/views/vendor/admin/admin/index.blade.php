@extends('admin::layouts.app')

@section('content')
    <div id="content">
		<div class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="page-header">
						<h1>{{ trans('admin::admin.heading.index') }}</h1>
						<ul class="breadcrumb">
							<li><a href="{{ route('admin') }}">{{ trans('admin::home.heading.title') }}</a></li>
							<li><a href="{{ route('admin.admin.index') }}">{{ trans('admin::admin.heading.index') }}</a></li>
						</ul>
						<div class="pull-right">
							<a href="{{ route('admin.admin.create') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="{{ trans('admin::admin.heading.create') }}"><i class="fa fa-plus"></i></a>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td class="text-left">{{ trans('admin::admin.form.email') }}</td>
									<td class="text-left">{{ trans('admin::admin.form.name') }}</td>
									<td class="text-right">{{ trans('admin::app.text.action') }}</td>
								</tr>
							</thead>
							<tbody>
								@foreach ($admins as $value)
								<tr>
									<td class="text-left">{{ $value->email }}</td>
									<td class="text-left">{{ $value->name }}</td>
									<td class="text-right">
										{{-- <a href="{{ route('admin.admin.show',['id'=>$value->id]) }}" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="{{ trans('admin::app.button.show') }}"><i class="fa fa-eye"></i></a> --}}
										<a href="{{ route('admin.admin.edit',['id'=>$value->id]) }}" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="{{ trans('admin::app.button.edit') }}"><i class="fa fa-pencil"></i></a>
										<a href="{{ route('admin.admin.destroy',$value->id) }}" onclick="return confirm('@Lang('admin::app.confirm.delete')')?true:false"  data-toggle="tooltip" title="" class="btn btn-warning" data-original-title="{{ trans('admin::app.button.delete') }}"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="text-right">
						{{ $admins->links() }}
					</div>
				</div>
			</div>
	    </div>
	</div>
    
@endsection
