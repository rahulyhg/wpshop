jQuery( document ).ready( function() {

	jQuery( '#wps_user_account_form' ).submit(function() {
		jQuery( this ).ajaxSubmit({
			dataType: 'json',
			beforeSubmit: function( formData, jqForm, options ) {

			},
			success: function( responseText, statusText, xhr, $form ) {

			}
		});

		return false;
	});

});
