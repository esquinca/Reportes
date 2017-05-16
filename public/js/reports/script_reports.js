$('#select_one').on('change', function(e){
  var id= $(this).val();

  var _token = $('input[name="_token"]').val();
  if (id != ''){
      alert('exito');
      $.ajax({
        type: "POST",
        url: "./typereport",
        data: { numero : id , _token : _token },
        success: function (data){
          $('#select_two').empty();
          $('#select_two').append('<option value="" selected>Elije</option>');

          $.each(JSON.parse(data),function(index, objdata){
            $('#select_two').append('<option value="'+objdata.id+'">'+ objdata.nivel +'</option>');
          });
        },
        error: function (data) {
          console.log('Error:', data);
        }
      });
  }
  else {
      alert('error');
      $('#select_two').empty();
      $('#select_two').append('<option value="" selected>Elije</option>');
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
