<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>
<!-- Mas usados -->
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>

<script type="application/javascript">
$(document).ready(function() {
    function pendientesactivos(){
      var _token = $('input[name="_token"]').val();
      $.ajax({
        type: "POST",
        url: "./showpendient",
        data: { _token : _token },
        success: function (data){
          $("#siderbarpendientes").text(data);
          $("#desplegablependientes").text(data);
        },
        error: function (data) {
          console.error('Error:', data);
        }
      });
    }
    setInterval(pendientesactivos, 3000);
});
</script>

@stack('scripts')
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
