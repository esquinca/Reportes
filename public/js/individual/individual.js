$(function() {
	$(".select2").select2();
});
$('#fecha_ngb').datepicker({ format: "yyyy-mm-dd", autoclose: true /*startDate: '0m', endDate: '0m',*/ });
$('#fecha_nuser').datepicker({ format: "yyyy-mm-dd", autoclose: true /*startDate: '0m', endDate: '0m',*/ });
$('#fecha_aps').datepicker({ format: "yyyy-mm-dd", autoclose: true /*startDate: '0m', endDate: '0m',*/ });
$('#fecha_nwlan').datepicker({ format: "yyyy-mm-dd", autoclose: true /*startDate: '0m', endDate: '0m',*/ });

function validarSelect(campo) {
  if (campo != '') {
    select=document.getElementById(campo).selectedIndex;
    if( select == null || select == 0 ) {
      $('#'+campo).parent().parent().attr("class", "form-group has-error");
      return false;
    }
    else {
      $("#"+campo).parent().parent().attr("class","form-group has-default");
      return true;
    }
  };
};

function validarInput(campo) {
  if (campo != '') {
    select=document.getElementById(campo).value;
    if( select == null || select == 0 ) {
      $('#'+campo).parent().parent().attr("class", "form-group has-error");
      return false;
    }
    else {
      $("#"+campo).parent().parent().attr("class","form-group has-default");
      return true;
    }
  };
}

$('#generateGbInfo').on('click', function(){
  var a0=validarSelect('select_one');
	var a1=validarInput('fecha_ngb');
  var a2=validarInput('valorgb_trans');

  var _token = $('input[name="_token"]').val();
  var id_hotel_one= $('#select_one').val();
	var cap_date= $('#fecha_ngb').val();
  var cap_value= $('#valorgb_trans').val();

	if (a0 == false || a1 == false || a2 == false) {
		 toastr.error('Datos Requeridos. !!', 'Error', {timeOut: 1000});
	}

  if (a0 === true && a1 === true && a2 === true) {

	  $.ajax({
         type: "POST",
         url: './transgb',
         data: { ident : id_hotel_one, date: cap_date, vgb: cap_value, _token : _token },
         success: function (data) {
					 //console.log('v:', data);
					 if (data == '0') {
						 toastr.success('Dia capturado con exito.!!', 'Mensaje', {timeOut: 1000});
					 }
					 if (data == '1') {
						 toastr.error('Este dia si estaba registrado. !!', 'Mensaje', {timeOut: 1000});
           }
         },
         error: function (data) {
           console.log('Error:', data);
         }
     });

  }
});

$('#generateUserInfo').on('click', function(){
  var b0=validarSelect('select_two');
	var b1=validarInput('fecha_nuser');
  var b2=validarInput('val_user');

  var _token = $('input[name="_token"]').val();
  var id_hotel_two= $('#select_two').val();
	var cap_date_two= $('#fecha_nuser').val();
  var cap_value_two= $('#val_user').val();

	if (b0 == false && b1 == false && b2 == false) {
     toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
  }
  if (b0 == true && b1 == true && b2 == true) {

	  $.ajax({
         type: "POST",
         url: './transuser',
         data: { ident : id_hotel_two, date: cap_date_two, vur: cap_value_two, _token : _token },
         success: function (data) {
					 //console.log('v:', data);
					 if (data == '0') {
						 toastr.success('Dia capturado con exito.!!', 'Mensaje', {timeOut: 1000});
					 }
					 if (data == '1') {
						 toastr.error('Este dia si estaba registrado. !!', 'Mensaje', {timeOut: 1000});
           }
         },
         error: function (data) {
           console.log('Error:', data);
         }
     });

  }
});

$('#generateapsInfo').on('click', function(){
  var c0=validarSelect('select_three');
	var c1=validarInput('fecha_aps');

  var c11=validarInput('mac1');  var c12=validarInput('modelo1');  var c13=validarInput('cliente1');
  var c21=validarInput('mac2');  var c22=validarInput('modelo2');  var c23=validarInput('cliente2');
  var c31=validarInput('mac3');  var c32=validarInput('modelo3');  var c33=validarInput('cliente3');
  var c41=validarInput('mac4');  var c42=validarInput('modelo4');  var c43=validarInput('cliente4');
  var c51=validarInput('mac5');  var c52=validarInput('modelo5');  var c53=validarInput('cliente5');

  var _token = $('input[name="_token"]').val();

  var id_hotel_three= $('#select_three').val();
	var cap_date_three= $('#fecha_aps').val();

  var c1_1 = $('#mac1').val();  var c1_2 = $('#modelo1').val();  var c1_3 = $('#cliente1').val();
  var c2_1 = $('#mac2').val();  var c2_2 = $('#modelo2').val();  var c2_3 = $('#cliente2').val();
  var c3_1 = $('#mac3').val();  var c3_2 = $('#modelo3').val();  var c3_3 = $('#cliente3').val();
  var c4_1 = $('#mac4').val();  var c4_2 = $('#modelo4').val();  var c4_3 = $('#cliente4').val();
  var c5_1 = $('#mac5').val();  var c5_2 = $('#modelo5').val();  var c5_3 = $('#cliente5').val();

	if (c0 == false && c1 == false &&
      c11 == false  && c12 == false && c13 == false &&
      c21 == false  && c22 == false && c23 == false &&
      c31 == false  && c32 == false && c33 == false &&
      c41 == false  && c42 == false && c43 == false &&
      c51 == false  && c52 == false && c53 == false ) {
     toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
  }
  if (c0 == true && c1 == true &&
      c11 == true  && c12 == true && c13 == true &&
      c21 == true  && c22 == true && c23 == true &&
      c31 == true  && c32 == true && c33 == true &&
      c41 == true  && c42 == true && c43 == true &&
      c51 == true  && c52 == true && c53 == true ) {

	  $.ajax({
         type: "POST",
         url: './transaps',
         data: { ident : id_hotel_three, date: cap_date_three,
                 af1_1: c1_1 , af1_2: c1_2, af1_3: c1_3,
                 af2_1: c2_1 , af2_2: c2_2, af2_3: c2_3,
                 af3_1: c3_1 , af3_2: c3_2, af3_3: c3_3,
                 af4_1: c4_1 , af4_2: c4_2, af4_3: c4_3,
                 af5_1: c5_1 , af5_2: c5_2, af5_3: c5_3,
                 _token : _token
               },
         success: function (data) {
					 //console.log('Error:', data);
					 if (data == '0') {
						toastr.success('Dia capturado con exito.!!', 'Mensaje', {timeOut: 1000});
					}
					if (data == '1') {
						toastr.error('Este dia si estaba registrado. !!', 'Mensaje', {timeOut: 1000});
					 }
         },
         error: function (data) {
           console.log('Error:', data);
         }
     });

  }
});

$('#generatewlanInfo').on('click', function(){
  var d0=validarSelect('select_four');
	var d1=validarInput('fecha_nwlan');

  var d11=validarInput('nombrew1');  var d12=validarInput('clientew1');

  var _token = $('input[name="_token"]').val();

  var id_hotel_four= $('#select_four').val();
	var cap_date_four= $('#fecha_nwlan').val();

  var d1_1 = $('#nombrew1').val();  var d1_2 = $('#clientew1').val();
  var d2_1 = $('#nombrew2').val();  var d2_2 = $('#clientew2').val();
  var d3_1 = $('#nombrew3').val();  var d3_2 = $('#clientew3').val();
  var d4_1 = $('#nombrew4').val();  var d4_2 = $('#clientew4').val();
  var d5_1 = $('#nombrew5').val();  var d5_2 = $('#clientew5').val();

	if (d0 == false && d1 == false &&  d11 == false  && d12 == false ) {
     toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
  }
  if (d0 == true && d1 == true &&  d11 == true  && d12 == true ) {
	  $.ajax({
         type: "POST",
         url: './transwlan',
         data: { ident : id_hotel_four, date: cap_date_four,
                 bf1_1: d1_1 , bf1_2: d1_2,
                 bf2_1: d2_1 , bf2_2: d2_2,
                 bf3_1: d3_1 , bf3_2: d3_2,
                 bf4_1: d4_1 , bf4_2: d4_2,
                 bf5_1: d5_1 , bf5_2: d5_2,
                 _token : _token
               },
         success: function (data) {
					 console.log('v:', data);
					 if (data == '0') {
						toastr.success('Dia capturado con exito.!!', 'Mensaje', {timeOut: 1000});
					}
					if (data == '1') {
						toastr.error('Este dia si estaba registrado. !!', 'Mensaje', {timeOut: 1000});
					 }
         },
         error: function (data) {
           console.log('Error:', data);
         }
     });

  }
});


$('#generateGbClear').on('click', function(){

});
