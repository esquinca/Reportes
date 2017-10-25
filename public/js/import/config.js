function control(f){
        var ext=['xlsx'];
        var v=f.value.split('.').pop().toLowerCase();
        for(var i=0,n;n=ext[i];i++){
            if(n.toLowerCase()==v)
                return
        }
        var t=f.cloneNode(true);
        t.value='';
        f.parentNode.replaceChild(t,f);
				toastr.error('Extensión no válida solo valida xlsx!', 'Error', {timeOut: 3000});
    }


  $('#update_file').on('click', function(){
    if ( $('#documento').val() != "" ){
      $( "#formexcel" ).submit();
    }
    else {
      toastr.error('No has cargado el documento xlsx!', 'Error', {timeOut: 3000});
    }
  });
