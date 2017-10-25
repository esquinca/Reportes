@extends('layouts.app')

@section('htmlheader_title')
    {{ trans('message.pagenotfound') }}
@endsection

@section('contentheader_title')
    {{ trans('message.404error') }}
@endsection

@section('$contentheader_description')
@endsection

@section('main-content')

<div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>
    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> {{ trans('message.emotionOps') }}! {{ trans('message.pagenotfound') }}.</h3>
        <p>
            {{ trans('message.notfindpage') }}
            {{ trans('message.mainwhile') }} <a href='{{ url('/home') }}'>{{ trans('message.returndashboard') }}</a>
        </p>
    </div><!-- /.error-content -->
</div><!-- /.error-page -->
@endsection
