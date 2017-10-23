@extends('admin::layouts.app')

@section('content')
<div id="content">
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-body">
                <a class="img-thumbnail" data-toggle="image" href="#" id="thumb-image">
                    <img alt="" data-placeholder="{{ Image::placeholder(100,100) }}" src="{{ Image::placeholder(100,100) }}" title=""/>
                </a>
                <input id="input-image" name="image" type="hidden" value=""/>
            </div>
        </div>
    </div>
</div>
@endsection
