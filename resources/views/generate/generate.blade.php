@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT')
  @section('htmlheader_title')
      {{ trans('message.generatereport') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.generatereport') }}
  @endsection

  @push('scripts')
  <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="/js/generate/generate.js"></script>
  @endpush

  @section('main-content')

  <section class="content">

  <!-- SELECT2 EXAMPLE -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Captura</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <!-- row -->
      <div class="row">
        <div class="col-sm-12">
           {{ csrf_field() }}
          <form class="form-inline">
            <div>
              <div class="form-group">
                <label for="select_one">Seleccione el Hotel: </label>
                <select class="form-control select2" id="select_one">
                  <option value="" selected>{{ trans('message.optionOne')}}</option>
                  @foreach ($selectDatahotel as $info)
                  <option value="{{ $info->id }}"> {{ $info->Nombre_hotel }} </option>
                  @endforeach
                </select>
              </div>
              <a id="generateInfo" class="btn btn-success"><i class="fa fa-bookmark-o"></i> Generar</a>
            </div>
          </form>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    </div>
  </div>
</section>
  @endsection
@endif

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin' || Auth::user()->Privilegio != 'IT')
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
