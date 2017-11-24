$('#comprobarip').on('click', function() {
    var direc=$('#direccion_ip').val();
    var puert=$('#puerto_dir').val();
    var _token = $('input[name="_token"]').val();
    if (direccionip(direc) == '1') {
      var select=document.getElementById('puerto_dir').value.length;
      if( select == null || select == 0 ) {
        $.ajax({
          type: "POST",
          url: "./testzonedir",
          data: { num_dir : $('#direccion_ip').val() , num_port : 161 ,_token : _token },
          success: function (data){
            if (data === '0'){
              mensajetoast('Mensaje', '1', 'Ping successful!.', 1500);
              //alert ("Ping successful!");
            }
            else {
              var mens2='Timeout: No Response from'+direc+':'+puert;
              mensajetoast('Mensaje', '3', mens2, 1500);
              //alert(mens2);
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
      }
      else {
        $.ajax({
          type: "POST",
          url: "./testzonedir",
          data: { num_dir : $('#direccion_ip').val() , num_port : $('#puerto_dir').val() ,_token : _token },
          success: function (data){
            if (data === '0'){
              mensajetoast('Mensaje', '1', 'Ping successful!.', 1500);
              //alert ("Ping successful!");
            }
            else {
              var mens2='Timeout: No Response from '+direc+':'+puert;
              mensajetoast('Mensaje', '3', mens2, 1500);
              //alert(mens2);
            }
          },
          error: function (data) {
            console.log('Error:', data);
          }
        });
        //mensajetoast('Mensaje', '1', 'NO VACIO.', 1000);
      }
    //  mensajetoast('Mensaje', '1', 'Formato correcto.', 1000);
    }
    else {
      mensajetoast('Mensaje', '3', 'Formato incorrecto.', 1000);
    }
});

$('#resetcomprobarip').on('click', function() {

});

function direccionip(inputText){
   var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
   if(inputText.match(ipformat)){
     return '1';
   }
   else  {
     return '0';
   }
}

function mensajetoast(title, campoa, campob, tiempo){
  switch (campoa) {
    case '1':
      toastr.success(campob, title, {timeOut: tiempo});
      break;
    case '2':
      toastr.warning(campob, title, {timeOut: tiempo});
      break;
    case '3':
      toastr.error(campob, title , {timeOut: tiempo});
      break;
  }
}
