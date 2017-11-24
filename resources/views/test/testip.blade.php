@extends('layouts.app')

@if (Auth::user()->Privilegio == 'Programador' || Auth::user()->Privilegio == 'Admin' || Auth::user()->Privilegio == 'IT')
  @section('htmlheader_title')
      {{ trans('message.testzd') }}
  @endsection
  @section('contentheader_title')
      {{ trans('message.testzd') }}
  @endsection

  @push('scripts')
    <script src="/js/test/testip.js"></script>
  @endpush
  @section('main-content')
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">{{ trans('message.required_view')}}.</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <!-- row -->
            <div class="row">
              <div class="col-sm-12">
                <form class="form-inline">
                  <div>
                    <div class="form-group">
                      <label for="direccion_ip"  class="control-label">{{ trans('message.direccionip')}}</label>
                      <div class="">
                        <input type="text" class="form-control" id="direccion_ip" name="direccion_ip" placeholder="xxx.xxx.xxx.xxx" maxlength="15" title="{{ trans('message.dir_ip_format')}}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="puerto_dir"  class="control-label">{{ trans('message.puerto')}}</label>
                      <div class="">
                        <input type="text" class="form-control" onkeyup="this.value=this.value.replace(/[^\d]/,'')" id="puerto_dir" name="puerto_dir" placeholder="xxxx" maxlength="4" title="{{ trans('message.maxfourcaract')}}">
                      </div>
                    </div>

                    <div class="form-group">
                      <a id="comprobarip" class="btn bg-navy"><i class="fa fa-bookmark-o"></i> {{ trans('message.comprobar')}}</a>
                      <a id="resetcomprobarip" class="btn btn-warning"><i class="fa fa-ban"></i> {{ trans('message.cancelar')}}</a>
                    </div>

                  </div>
                </form>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <strong>Nota: Si no inserta puerto se tomara como si seleccionara el puerto por defecto '161'.</strong>
          </div>
        </div>
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
