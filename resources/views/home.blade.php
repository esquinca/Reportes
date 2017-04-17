@extends('layouts.app')

@section('htmlheader_title')
	{{ trans('message.home') }}
@endsection

@section('breadcrumb_title')
{{ trans('breadcrumbRoute.home') }}
@endsection

@section('breadcrumb_route')
{{ trans('breadcrumbRoute.inicio') }}
@endsection

@section('contentheader_title')
			{{ trans('message.bienvenido') }} @if(Auth::check()){{ Auth::user()->name }} @endif
@endsection

@section('main-content')
	<div class="container spark-screen">
		<div class="row">
			<div class="col-md-8 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">{{ trans('message.bienvenido') }}</div>

					<div class="panel-body">
						{{ trans('message.logged') }}
					</div>
				</div>
			</div>
			<div class="col-md-4 col-md-offset-1"></div>
		</div>
	</div>
@endsection
