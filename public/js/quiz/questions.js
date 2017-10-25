$("#reload_quiz").click(function(event) {
  if ($('input[name="radio"]').is(':checked')) {
      if($('input:radio[name=radio]:checked').val() == "100") {
        var a0=validarInput('comment_c');
        if (a0 == false) {
          toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
        }
        else{
          var objData = $("#delta").find("select,textarea, input").serialize();
          $.ajax({
               url: "/survey_form",
               type: "POST",
               data: objData,
               success: function (data) {
                 console.log('success:', data);
               },
               error: function (data) {
                 console.log('Error:', data);
               }
           });
          // toastr.success('Datos completados. !!', 'Mensaje', {timeOut: 1000});
        }
      }
      if($('input:radio[name=radio]:checked').val() == "0"){
        var a2= validarcheck('radiob2');
        var a3= validarcheck('radiob3');
        var a1= validarcheck('radiob1');

        if (a1 == false && a2 == false &&  a3 == false ) {
          toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
        }
        else {
          if (a1 == true && a2 == false &&  a3 == false ) {
            if ($.trim($("#comment_c").val())) {
              var count_c = $("#comment_c").val().length;
              if (count_c >=4) {
                /*
                  Enviar por ajax aqui.... xD
                */
                var objData = $("#delta").find("select,textarea, input").serialize();
                $.ajax({
                     url: "/survey_form",
                     type: "POST",
                     data: objData,
                     success: function (data) {
                       console.log('success:', data);
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
                // toastr.success('Contiene igual o mas de 4 letras !!', 'Mensaje', {timeOut: 1000});
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de Soporte Tecnico. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
            }
            $("#radiob2").parent().parent().attr("class","form-group has-default");
            $("#radiob3").parent().parent().attr("class","form-group has-default");
            // toastr.success('Condicion uno true a1. !!', 'Mensaje', {timeOut: 1000});
          }
          if (a1 == false && a2 == true &&  a3 == false ) {
            if ($.trim($("#comment_a").val())) {
              var count_a = $("#comment_a").val().length;
              if (count_a >=4) {
                /*
                  Enviar por ajax aqui.... xD
                */
                var objData = $("#delta").find("select,textarea, input").serialize();
                $.ajax({
                     url: "/survey_form",
                     type: "POST",
                     data: objData,
                     success: function (data) {
                       console.log('success:', data);
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
                // toastr.success('Contiene igual o mas de 4 letras !!', 'Mensaje', {timeOut: 1000});
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de Comercial. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
            }

            $("#radiob1").parent().parent().attr("class","form-group has-default");
            $("#radiob3").parent().parent().attr("class","form-group has-default");
            // toastr.success('Condicion uno true a2!!', 'Mensaje', {timeOut: 1000});
          }
          if (a1 == false && a2 == false &&  a3 == true ) {
            if ($.trim($("#comment_b").val())) {
              var count_a = $("#comment_b").val().length;
              if (count_a >=4) {
                /*
                  Enviar por ajax aqui.... xD
                */
                var objData = $("#delta").find("select,textarea, input").serialize();
                $.ajax({
                     url: "/survey_form",
                     type: "POST",
                     data: objData,
                     success: function (data) {
                       console.log('success:', data);
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
                //toastr.success('Contiene igual o mas de 4 letras !!', 'Mensaje', {timeOut: 1000});
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de Proyectos e instalaciones. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
            }

            $("#radiob1").parent().parent().attr("class","form-group has-default");
            $("#radiob2").parent().parent().attr("class","form-group has-default");
            // toastr.success('Condicion uno true a3. !!', 'Mensaje', {timeOut: 1000});
          }
          // ---------------------------------------------------------------- //
          if (a1 == true && a2 == true &&  a3 == false ) {
            var val_a1 = false;
            var val_a2 = false;
            if ($.trim($("#comment_c").val())) {
              var count_ac1 = $("#comment_c").val().length;
              if (count_ac1 >=4) {
                val_a1=true;
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de Soporte Tecnico. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              val_a1 = false;
            }
            if ($.trim($("#comment_a").val())) {
              var count_aa1 = $("#comment_a").val().length;
              if (count_aa1 >=4) {
                val_a2=true;
              }
              else {
                toastr.error('Son 4 letras minimo  para el comentario de Comercial. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              val_a2 = false;
            }
            if (val_a1 == false || val_a2== false) {
              toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
            }
            if (val_a1 == true && val_a2== true) {
              /*
                Enviar por ajax aqui.... xD
              */
              var objData = $("#delta").find("select,textarea, input").serialize();
              $.ajax({
                   url: "/survey_form",
                   type: "POST",
                   data: objData,
                   success: function (data) {
                     console.log('success:', data);
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
               });
              // toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
            }
            $("#radiob1").parent().parent().attr("class","form-group has-default");
            $("#radiob2").parent().parent().attr("class","form-group has-default");
            //toastr.success('Condicion uno true a1 con a2. !!', 'Mensaje', {timeOut: 1000});
          }
          if (a1 == true && a2 == false &&  a3 == true ) {
            var val_b1 = false;
            var val_b2 = false;
            if ($.trim($("#comment_c").val())) {
              var count_bc1 = $("#comment_c").val().length;
              if (count_bc1 >=4) {
                val_b1=true;
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de Soporte Tecnico. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              val_b1 = false;
            }
            if ($.trim($("#comment_b").val())) {
              var count_ba1 = $("#comment_b").val().length;
              if (count_ba1 >=4) {
                val_b2=true;
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de Proyectos e instalaciones. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              val_b2 = false;
            }
            if (val_b1 == false || val_b2== false) {
              toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
            }
            if (val_b1 == true && val_b2== true) {
              /*
                Enviar por ajax aqui.... xD
              */
              var objData = $("#delta").find("select,textarea, input").serialize();
              $.ajax({
                   url: "/survey_form",
                   type: "POST",
                   data: objData,
                   success: function (data) {
                     console.log('success:', data);
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
              });
              // toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
            }
            $("#radiob1").parent().parent().attr("class","form-group has-default");
            $("#radiob2").parent().parent().attr("class","form-group has-default");
            //toastr.success('Condicion uno true a1 con a3. !!', 'Mensaje', {timeOut: 1000});
          }
          if (a1 == false && a2 == true &&  a3 == true ) {
            var val_c1 = false;
            var val_c2 = false;
            if ($.trim($("#comment_a").val())) {
              var count_cc1 = $("#comment_a").val().length;
              if (count_cc1 >=4) {
                val_c1=true;
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de comercial. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              val_c1 = false;
            }
            if ($.trim($("#comment_b").val())) {
              var count_ca1 = $("#comment_b").val().length;
              if (count_ca1 >=4) {
                val_c2=true;
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de Proyectos e instalaciones. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              val_c2 = false;
            }
            if (val_c1 == false || val_c2== false) {
              toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
            }
            if (val_c1 == true && val_c2== true) {
              /*
                Enviar por ajax aqui.... xD
              */
              var objData = $("#delta").find("select,textarea, input").serialize();
              $.ajax({
                   url: "/survey_form",
                   type: "POST",
                   data: objData,
                   success: function (data) {
                     console.log('success:', data);
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
              });
              // toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
            }
            $("#radiob1").parent().parent().attr("class","form-group has-default");
            $("#radiob2").parent().parent().attr("class","form-group has-default");
            //toastr.success('Condicion uno true a2 con a3. !!', 'Mensaje', {timeOut: 1000});
          }
          // ---------------------------------------------------------------- //
          if (a1 == true && a2 == true &&  a3 == true ) {
            var val_com_sop= false;
            var val_com_com= false;
            var val_com_pro= false;
            //soporte
            if ($.trim($("#comment_c").val())) {
              var count_comsop1 = $("#comment_c").val().length;
              if (count_comsop1 >=4) {
                val_com_sop=true;
              }
              else {
                val_com_sop = false;
                toastr.error('Son 4 letras minimo  para el comentario de Soporte Tecnico. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              val_com_sop = false;
            }
            //comercial
            if ($.trim($("#comment_a").val())) {
              var count_comcomercial = $("#comment_a").val().length;
              if (count_comcomercial >=4) {
                val_com_com=true;
              }
              else {
                val_com_com = false;
                toastr.error('Son 4 letras minimo  para el comentario de Comercial. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              val_com_com = false;
            }
            //proyectos e instalaciones
            if ($.trim($("#comment_b").val())) {
              var count_comproyect = $("#comment_b").val().length;
              if (count_comproyect >=4) {
                val_com_pro=true;
              }
              else {
                val_com_pro = false;
                toastr.error('Son 4 letras minimo para el comentario de Proyectos e instalaciones. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              val_com_pro = false;
            }
            // validar si alguno no concuerda.
            if (val_com_sop == false || val_com_com== false || val_com_pro== false) {
              toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
            }
            if (val_com_sop == true && val_com_com== true && val_com_pro== true) {
              /*
                Enviar por ajax aqui.... xD
              */
              var objData = $("#delta").find("select,textarea, input").serialize();
              $.ajax({
                   url: "/survey_form",
                   type: "POST",
                   data: objData,
                   success: function (data) {
                     console.log('success:', data);
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
              });
              //toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
            }
            $("#radiob1").parent().parent().attr("class","form-group has-default");
            $("#radiob2").parent().parent().attr("class","form-group has-default");
            //toastr.success('Condicion uno true a1,a2 con a3. !!', 'Mensaje', {timeOut: 1000});
          }
        }
      }
      if($('input:radio[name=radio]:checked').val() == "ninguna"){
        var ning_1= validarcheck('radioc1');
        var ning_2= validarcheck('radioc2');
        var ning_3= validarcheck('radioc3');
        if (ning_1 == false && ning_2 == false &&  ning_3 == false ) {
          toastr.error('Datos Requeridos. !!', 'Mensaje', {timeOut: 1000});
        }
        else{
          if (ning_1 == true && ning_2 == false &&  ning_3 == false ) {
            if ($.trim($("#comment_c").val())) {
              var count_sop_one = $("#comment_c").val().length;
              if (count_sop_one >=4) {
                /*
                  Enviar por ajax aqui.... xD
                */
                var objData = $("#delta").find("select,textarea, input").serialize();
                $.ajax({
                     url: "/survey_form",
                     type: "POST",
                     data: objData,
                     success: function (data) {
                       console.log('success:', data);
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
                //toastr.success('Contiene igual o mas de 4 letras !!', 'Mensaje', {timeOut: 1000});
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de Soporte Tecnico . !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
            }
            $("#radioc2").parent().parent().attr("class","form-group has-default");
            $("#radioc3").parent().parent().attr("class","form-group has-default");
          }
          if (ning_1 == false && ning_2 == true &&  ning_3 == false ) {
            if ($.trim($("#comment_a").val())) {
              var count_com_one = $("#comment_a").val().length;
              if (count_com_one >=4) {
                /*
                  Enviar por ajax aqui.... xD
                */
                var objData = $("#delta").find("select,textarea, input").serialize();
                $.ajax({
                     url: "/survey_form",
                     type: "POST",
                     data: objData,
                     success: function (data) {
                       console.log('success:', data);
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
                //toastr.success('Contiene igual o mas de 4 letras !!', 'Mensaje', {timeOut: 1000});
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de Comercial. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
            }
            $("#radioc1").parent().parent().attr("class","form-group has-default");
            $("#radioc3").parent().parent().attr("class","form-group has-default");
          }
          if (ning_1 == false && ning_2 == false &&  ning_3 == true ) {
            if ($.trim($("#comment_b").val())) {
              var count_proy_one = $("#comment_b").val().length;
              if (count_proy_one >=4) {
                /*
                  Enviar por ajax aqui.... xD
                */
                var objData = $("#delta").find("select,textarea, input").serialize();
                $.ajax({
                     url: "/survey_form",
                     type: "POST",
                     data: objData,
                     success: function (data) {
                       console.log('success:', data);
                     },
                     error: function (data) {
                       console.log('Error:', data);
                     }
                 });
                // toastr.success('Contiene igual o mas de 4 letras !!', 'Mensaje', {timeOut: 1000});
              }
              else {
                toastr.error('Son 4 letras minimo para el comentario de Proyectos e instalaciones. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
            }
            $("#radioc1").parent().parent().attr("class","form-group has-default");
            $("#radioc2").parent().parent().attr("class","form-group has-default");
          }
          // -----------------------------------------------------------------//
          if (ning_1 == true && ning_2 == true &&  ning_3 == false ) {
            var ninguna_vala_a= false;
            var ninguna_vala_b= false;
            /*Soporte*/
            if ($.trim($("#comment_c").val())) {
              var count_ning_one = $("#comment_c").val().length;
              if (count_ning_one >=4) {
                ninguna_vala_a= true;
              }
              else {
                ninguna_vala_a= false;
                toastr.error('Son 4 letras minimo para el comentario de Soporte Tecnico. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              ninguna_vala_a= false;
              //toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
            }
            /*Comercial*/
            if ($.trim($("#comment_a").val())) {
              var count_ning_two = $("#comment_a").val().length;
              if (count_ning_two >=4) {
                ninguna_vala_b= true;
              }
              else {
                ninguna_vala_b= false;
                toastr.error('Son 4 letras minimo para el comentario de Comercial. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              ninguna_vala_b= false;
              //toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
            }
            /**********/
            if (ninguna_vala_a == false || ninguna_vala_b== false){
              toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
            }
            if (ninguna_vala_a == true && ninguna_vala_b== true) {
              /*
                Enviar por ajax aqui.... xD
              */
              var objData = $("#delta").find("select,textarea, input").serialize();
              $.ajax({
                   url: "/survey_form",
                   type: "POST",
                   data: objData,
                   success: function (data) {
                     console.log('success:', data);
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
               });
              // toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
            }
            $("#radioc3").parent().parent().attr("class","form-group has-default");
          }
          if (ning_1 == true && ning_2 == false &&  ning_3 == true ) {
            var ninguna_valb_a= false;
            var ninguna_valb_b= false;
            /*Soporte*/
            if ($.trim($("#comment_c").val())) {
              var count_ning_sop_two = $("#comment_c").val().length;
              if (count_ning_sop_two >=4) {
                ninguna_valb_a= true;
              }
              else {
                ninguna_valb_a= false;
                toastr.error('Son 4 letras minimo para el comentario de Soporte Tecnico. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              ninguna_valb_a= false;
              //toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
            }
            /*Proyectos*/
            if ($.trim($("#comment_b").val())) {
              var count_ning_proyec_two = $("#comment_b").val().length;
              if (count_ning_proyec_two >=4) {
                ninguna_valb_b= true;
              }
              else {
                ninguna_valb_b= false;
                toastr.error('Son 4 letras minimo para el comentario de Proyectos e Instalaciones. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              ninguna_valb_b= false;
              //toastr.warning('Introducir un texto valido en el comentario!!', 'Mensaje', {timeOut: 1000});
            }
            /*****************/
            if (ninguna_valb_a == false || ninguna_valb_b== false){
              toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
            }
            if (ninguna_valb_a == true && ninguna_valb_b== true) {
              /*
                Enviar por ajax aqui.... xD
              */
              var objData = $("#delta").find("select,textarea, input").serialize();
              $.ajax({
                   url: "/survey_form",
                   type: "POST",
                   data: objData,
                   success: function (data) {
                     console.log('success:', data);
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
               });
              // toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
            }
          }
          if (ning_1 == false && ning_2 == true &&  ning_3 == true ) {
            var ninguna_valc_a= false;
            var ninguna_valc_b= false;
            /*Comercial*/
            if ($.trim($("#comment_a").val())) {
              var count_ning_com_two = $("#comment_a").val().length;
              if (count_ning_com_two >=4) {
                ninguna_valc_a= true;
              }
              else {
                ninguna_valc_a= false;
                toastr.error('Son 4 letras minimo para el comentario de Comercial. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              ninguna_valc_a= false;
            }
            /*Proyectos*/
            if ($.trim($("#comment_b").val())) {
              var count_ning_proyec_three = $("#comment_b").val().length;
              if (count_ning_proyec_three >=4) {
                ninguna_valc_b= true;
              }
              else {
                ninguna_valc_b= false;
                toastr.error('Son 4 letras minimo para el comentario de Proyectos e Instalaciones. !!', 'Mensaje', {timeOut: 1000});

              }
            }
            else {
              ninguna_valc_b= false;
            }
            /*****************/
            if (ninguna_valc_a == false || ninguna_valc_b== false){
              toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
            }
            if (ninguna_valc_a == true && ninguna_valc_b== true) {
              /*
                Enviar por ajax aqui.... xD
              */
              var objData = $("#delta").find("select,textarea, input").serialize();
              $.ajax({
                   url: "/survey_form",
                   type: "POST",
                   data: objData,
                   success: function (data) {
                     console.log('success:', data);
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
               });
              toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
            }
          }
          /////////////////---------------------------------------//////////////
          if (ning_1 == true && ning_2 == true &&  ning_3 == true ) {
            var ninguna_val_all_a= false;
            var ninguna_val_all_b= false;
            var ninguna_val_all_c= false;
            //soporte
            if ($.trim($("#comment_c").val())) {
              var count_coment_c = $("#comment_c").val().length;
              if (count_coment_c >=4) {
                ninguna_val_all_a=true;
              }
              else {
                ninguna_val_all_a = false;
                toastr.error('Son 4 letras minimo en el comentario de soporte tecnico. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              ninguna_val_all_a = false;
            }
            //comercial
            if ($.trim($("#comment_a").val())) {
              var count_coment_a = $("#comment_a").val().length;
              if (count_coment_a >=4) {
                ninguna_val_all_b = true;
              }
              else {
                ninguna_val_all_b = false;
                toastr.error('Son 4 letras minimo en el comentario de comercial. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              ninguna_val_all_b = false;
            }
            //proyectos e instalaciones
            if ($.trim($("#comment_b").val())) {
              var count_coment_b = $("#comment_b").val().length;
              if (count_coment_b >=4) {
                ninguna_val_all_c=true;
              }
              else {
                ninguna_val_all_c = false;
                toastr.error('Son 4 letras minimo en el comentario de Proyectos e instalaciones. !!', 'Mensaje', {timeOut: 1000});
              }
            }
            else {
              ninguna_val_all_c = false;
            }
            // validar si alguno no concuerda.
            if (ninguna_val_all_a == false || ninguna_val_all_b== false || ninguna_val_all_c== false) {
              toastr.error('Por favor llena los comentarios!!', 'Mensaje', {timeOut: 1000});
            }
            if (ninguna_val_all_a == true && ninguna_val_all_b== true && ninguna_val_all_c== true) {
              /*
                Enviar por ajax aqui.... xD
              */
              var objData = $("#delta").find("select,textarea, input").serialize();
              $.ajax({
                   url: "/survey_form",
                   type: "POST",
                   data: objData,
                   success: function (data) {
                     console.log('success:', data);
                   },
                   error: function (data) {
                     console.log('Error:', data);
                   }
              });
              toastr.success('Enviar ajax. !!', 'Mensaje', {timeOut: 1000});
            }
          }
        }
      }
   }
   else {
     toastr.error('Responde la primera pregunta. !!', 'Mensaje', {timeOut: 2000});
   }
});
function validarcheck(campo) {
  if($('input[name='+campo+']').is(':checked')){
    $("#"+campo).parent().parent().attr("class","form-group has-default");
    return true;
  }
  else {
    $('#'+campo).parent().parent().attr("class", "form-group has-error");
    return false;
  }
}
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


// $("#reload_quiz").click(function(event) {
//   $('#delta')[0].reset();
//
// });
