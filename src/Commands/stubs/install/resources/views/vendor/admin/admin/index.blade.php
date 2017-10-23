@extends('admin::layouts.app')

@section('content')
    <div id="content">
    	<div class="page-header">
    		<div class="container-fluid">
				<h1>@Lang('admin::admin.heading.index')</h1>
				<ul class="breadcrumb">
					<li><a href="{{ route('admin') }}">@Lang('admin::home.heading.index')</a></li>
					<li><a href="{{ route('admin.admin.index') }}">@Lang('admin::admin.heading.index')</a></li>
				</ul>
				<div class="pull-right">
					<a href="{{ route('admin.admin.create') }}" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="@Lang('admin::admin.heading.create')"><i class="fa fa-plus"></i></a>
				</div>
			</div>
		</div>	
		<div class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-list"></i> @Lang('admin::admin.heading.index')</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<td class="text-left">@Lang('admin::admin.form.email')</td>
									<td class="text-left">@Lang('admin::admin.form.name')</td>
									<td class="text-right">@Lang('admin::app.text.action')</td>
								</tr>
							</thead>
							<tbody>
								@foreach ($admins as $value)
								<tr>
									<td class="text-left">{{ $value->email }}</td>
									<td class="text-left">{{ $value->name }}</td>
									<td class="text-right">
										<a href="{{ route('admin.admin.edit',['id'=>$value->id]) }}" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="@Lang('admin::app.button.edit')"><i class="fa fa-pencil"></i></a>
										<a href="{{ route('admin.admin.destroy',$value->id) }}" onclick="return confirm('@Lang('admin::app.confirm.delete')')?true:false"  data-toggle="tooltip" title="" class="btn btn-warning" data-original-title="@Lang('admin::app.button.delete')"><i class="fa fa-trash"></i></a>
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
