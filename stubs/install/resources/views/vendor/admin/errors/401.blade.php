@extends('admin::layouts.app')

@section('content')
    <div id="content">
		<div class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="page-header">
						<h1>@Lang('admin::error.text.401')</h1>
						<ul class="breadcrumb">
							<li><a href="{{ route('admin') }}">{{ trans('admin::home.heading.title') }}</a></li>
							<li><a >@Lang('admin::error.text.401')</a></li>
						</ul>
					</div>
				</div>
				<div class="panel-body">
					<h1 class="text-center">@Lang('admin::error.text.401')</h1>
				</div>
			</div>
		</div>
   	</div>
@endsection
