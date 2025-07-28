jQuery(document).ready(function($) {
	
    $('#google_map_button').on('click', function() {
		 
        $('#map_btn_ajax_loading').show();
		 var zip_code_service = $("div").find(`[data-name='zip_code_service']`);
		 var address_service = $("div").find(`[data-name='address_service']`);
		 
		 
        var postData = {
            action: 'skr_save_location',
            zip_codes: $('#acf-'+ zip_code_service.attr('data-key')).val(),
            address: $('#acf-'+ zip_code_service.attr('data-key')).val(),
            nonce: skrAjax.nonce,
            post_id: $('#post_ID').val()
        };

		// console.log('postDatapostData: ', postData);
		 
        $.post(skrAjax.ajaxurl, postData, function(response) {
        
            var res = JSON.parse(response);
        //    console.log(res);
                
            $('#map_btn_ajax_loading').hide();
            $('#map_btn_ajax_msg').html('<p style="color: green;font-weight: bold;">' + res.message + ', Thanks...</p>');
        });
    });
});
