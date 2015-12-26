function revealPassword( username, base_url ){
	$( document ).ajaxStart(function() {
		$('#password-progress').removeClass('hide');	
	});

	var password = $("#password-input").val();
	$("#password-input").val("");
	var return_string;

	if( password != '' ){
		var request = $.ajax({
			headers: {
			  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
			},
			url: base_url+"/api/revealPassword",
			method: "POST",
			data: { 
				"username" : username,
				"password" : password
			},
			dataType: "json"
		});
		

		request.done(function( msg ) {
			$('#password-reveal').text( msg.password );
			$('#password-progress').addClass('hide');
		});
	}

}

function confirmDeletion( db_name, encrypted_db_name ){
	$('#the-pre-deleted-database').text( db_name );
	$('#delete-db-name').val( encrypted_db_name );
	$('#delete-database').openModal();
}
