jQuery(document).ready(function(e){

	jQuery(document).on("click",".formulario_email_id",function(e) {
		e.preventDefault();
		//Conseguimos las variables para la acción
		var email = jQuery('.email_usuario').val();
		var url_admin = jQuery('.admin_ajax_url').val();
		var action = 'conseguir_id_usuario';
		var correo_valido = true;

		//Comprobamos que el correo sea válido
		var expresion = /^[a-z][\w.-]+@\w[\w.-]+\.[\w.-]*[a-z][a-z]$/i;
		//Si ya ha salido un error en la comprobación
		jQuery('.wordpress-ajax-form p').hide();

		if( email == null || email.length == 0 || !expresion.test(email) ) {
			//Si el correo no es válido modificamos estilos y no se hace llamada ajax           
            jQuery('.email_usuario').css('border', '3px solid #ff0000');
            jQuery('.wordpress-ajax-form').append('<p>El correo introducido es incorrecto</p>');
            correo_valido = false;
        }

        if ( correo_valido ) {
        	//Cambiamos el borde para que no sea rojo
        	jQuery('.email_usuario').css('border', '1px solid #000000');
        	//Llamada ajax
			jQuery.ajax({
					type: 'post',
					url: url_admin,							
					data: {
						action: action,
						email: email
					},
					success: function(data, textStatus, XMLHttpRequest) {						
						//Escondemos el resultados dado en función de data, si existe
						jQuery('.wordpress-ajax-form p').hide();
						
						if ( data != 'null' ) {
							jQuery('.wordpress-ajax-form').append('<p>La ID del usuario es ' + data + '</p>');
						}
						else {
							jQuery('.wordpress-ajax-form').append('<p>No existe ningún usuario registrado con ese correo</p>');
						}					
						
					},
					error: function(MLHttpRequest, textStatus, errorThrown) {
					//alert('Error: ' + textStatus);
					//alert('Error: ' + errorThrown);
					}
			});  //llamada ajax
		} //if comprueba es correo	
	});

});