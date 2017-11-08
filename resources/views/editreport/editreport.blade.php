@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT' || Auth::user()->Privilegio == 'Cliente' || Auth::user()->Privilegio == 'Encuestador')

  @section('htmlheader_title')
      {{ trans('message.editreport') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.editreport') }}
  @endsection

  @push('scripts')
  @endpush

  @section('main-content')

  @endsection
@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin' || Auth::user()->Privilegio != 'IT' || Auth::user()->Privilegio != 'Encuestador')
@section('htmlheader_title')
    {{ trans('message.pagenotfound') }}
@endsection
@section('contentheader_title')
    {{ trans('message.404error') }}
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
        </div>
    </div>
@endsection
@endif
