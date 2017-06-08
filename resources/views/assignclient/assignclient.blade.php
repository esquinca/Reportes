@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin')
  @section('htmlheader_title')
      {{ trans('message.asigclient') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.asigclient') }}
  @endsection

  @push('scripts')
  <script src="/js/assigncl/assigncl.js"></script>

  @endpush
  @section('main-content')
  <section class="content">
    <!-- SELECT2 EXAMPLE -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Asignar</h3>


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
                  </select>
                </div>

                <div class="form-group">
                  <label for="select_one">Seleccione el cliente: </label>
                  <select class="form-control select2" id="select_two">
                    <option value="" selected>{{ trans('message.optionOne')}}</option>
                  </select>
                </div>

                <a id="capInfo" class="btn btn-primary"><i class="fa fa-bookmark-o"></i> Capturar</a>
                <a id="capClear" class="btn btn-danger"><i class="fa fa-ban"></i> Cancelar</a>

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

    <!-- Section table client -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table id="tableclient" name='tableclient' class="display nowrap table table-bordered table-hover" cellspacing="0" width="95%">
          <input type='hidden' id='_tokenb' name='_tokenb' value='{!! csrf_token() !!}'>
          <thead >
            <tr class="bg-primary" style="background: #3D4A5D;">
              <th>{{ trans('message.hotel') }}</th>
              <th>{{ trans('message.cliente') }}</th>
              <th  style="width:100px; ">{{ trans('message.operation') }}</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
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
