$(document).ready(function() {
  // Instrucciones a ejecutar al terminar la carga
  $('#calendar_fecha').attr('readonly', true);
});

$('#select_one').on('change', function(e){
  var id= $(this).val();
  var _token = $('input[name="_token"]').val();

  $('#calendar_fecha').val('');
  $('#calendar_fecha').attr('readonly', true);

  if (id != ''){
      //alert('exito');
      $.ajax({
        type: "POST",
        url: "./typereport",
        data: { numero : id , _token : _token },
        success: function (data){
          $('#select_two').empty();
          $('#select_two').append('<option value="" selected>Elije</option>');

          $.each(JSON.parse(data),function(index, objdata){
            $('#select_two').append('<option value="'+objdata.id+'">'+ objdata.Nivel +'</option>');
          });
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
  }
  else {
      //alert('error');
      $('#select_two').empty();
      $('#select_two').append('<option value="" selected>Elije</option>');
  }
});

$('#select_two').on('change', function(e){
  var id= $(this).val();
  var hotel= $('#select_one').val();
  var _token = $('input[name="_token"]').val();
  $('#calendar_fecha').val('');

  if (id != ''){
    //Para consultar el mes y año del primer registro
    $.ajax({
      type: "POST",
      url: "./consultmes",
      data: { nhotel:hotel, tipo : id , _token : _token },
      success: function (data){
        if (data != '') {
          //alert(data);
          //$('#fecha_act').val(data);
          $('#calendar_fecha').val('');
          $('#calendar_fecha').attr('readonly', false);
          $('#calendar_fecha').datepicker({
              format: "mm-yyyy",
              viewMode: "months",
              minViewMode: "months",
              startDate: data,
              endDate: '+1m', //Esto indica que aparecera el mes hasta que termine el ultimo dia del mes.
              autoclose: true
          });

        };
      },
      error: function (data) {
        console.log('Error:', data);
      }
    });
  }
  else {
    //alert('error2');
    $('#calendar_fecha').val('');
    $('#calendar_fecha').attr('readonly', true);
  }
});

$(document).ready(function() {
  //Animated Number
  $.fn.animateNumbers = function(stop, commas, duration, ease) {
    return this.each(function() {
      var $this = $(this);
      var start = parseInt($this.text().replace(/,/g, ""));
      commas = (commas === undefined) ? true : commas;
      $({value: start}).animate({value: stop}, {
        duration: duration == undefined ? 1000 : duration,
        easing: ease == undefined ? "swing" : ease,
        step: function() {
          $this.text(Math.floor(this.value));
          if (commas) { $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); }
        },
        complete: function() {
          if (parseInt($this.text()) !== stop) {
            $this.text(stop);
            if (commas) { $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); }
          }
        }
      });
    });
  };

  $('.animated-number').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
    var $this = $(this);
    if (visible) {
      $this.animateNumbers($this.data('digit'), false, $this.data('duration'));
      $this.unbind('inview');
    }
  });
});
