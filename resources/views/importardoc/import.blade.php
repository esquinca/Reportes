@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin')
  @section('htmlheader_title')
      {{ trans('message.importarfile') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.importarfile') }}
  @endsection

  @push('scripts')
  <script src="/js/import/config.js"></script>

  @endpush
  @section('main-content')

  <section class="content">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('message.importar') }}</h3>
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
            <!--<form class="form-inline">-->
              {!! Form::open(['action' => 'ImportController@SUBIR', 'url' => '/uploaddoc', 'method' => 'post', 'id' => 'formexcel', 'class' => 'form-inline' ]) !!}
                <div class="form-group">
                  <label class="btn btn-default btn-file">
                        Seleccione el Archivo: <input type="file" id="documento" name="documento" style="display: none;">
                  </label>
                </div>

                <button type="submit" class="btn bg-navy" id='update_file'><i class="fa fa-upload" style="margin-right: 4px;"></i>Subir</button>

            <!--</form>-->
            {!! Form::close() !!}
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

@if (Auth::user()->Privilegio != 'Programador' || Auth::user()->Privilegio != 'Admin')
  @section('htmlheader_title')
      {{ trans('message.pagenotfound') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.error') }}
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
