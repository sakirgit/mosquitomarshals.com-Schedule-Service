/**
 * Authors: Carlo Ariel Sandig
 * 
*/

(function($) {

	$(document).ready(function() {	
	
		
		$('.locationService001').submit(function(alucards){
			alucards.preventDefault()
			console.log('Location Zip')
			alucards.stopImmediatePropagation()
			
			var fmc = $(this)
			var er = 0;
			fmDatac = fmc.serialize()
			
			fmc.find('label').removeClass('rg_error_label')
			fmc.find('input').each(function(i){
				var vl = $(this).val()
				var id = $(this).attr('id')
				var lb = fmc.find('label[for='+id+']')
				$(this).removeClass('rg_error_field')
				if ( vl == '' ) {
					$(this).addClass('rg_error_field')
					lb.addClass('rg_error_label')
					er += 1
				}
			})
			if ( er > 0 ) {
				fmc.find('.some-messages').addClass('active').html('Some errors were found, please correct them then try again.')
				return false;
			}
          
            var acc = '&action='+lz.lc
			var noc = '&nonce='+lz.nonce
			
			$.ajax({
				type:'POST', dataType:'json', url:lz.ajax, data:fmDatac+acc+noc, 
				beforeSend: function() {
			
					fmc.find('.some-messages').removeClass('rg_error_field').html('')
					fmc.find('.some-messages').removeClass('rg_error_field').html('')
					
					fmc.find('.some-messages').addClass('rg_error_field').html('<strong>Info!</strong> sending.., please wait.')
				},
				error: function (err) {
					fmc.find('.some-messages').removeClass('rg_error_field').html('')

					fmc.find('.some-messages').addClass('rg_error_field').html('Please contact the owner.')
					
					console.log('~some 1 server error~')
				}
			}).done(function( data ) {
				fmc.find('.some-messages').addClass('alert alert-success').html(data.message)
				if ( data.status === 'error' ){
					console.log(data.message)
					console.log('~ status some server error~')
				} else if ( data.status === 'success' ) {
					// reset
					console.log(data.message)
					fmc.find('label').removeClass('rg_error_field')
					fmc.find('input').each(function(i){
						$(this).val('')
					})
					
				}
			})
			
		})
		
		$('.defaultlocation').submit(function(alucards){
			alucards.preventDefault()
			console.log('Location Zip')
			alucards.stopImmediatePropagation()
			
			var fmc = $(this)
			var er = 0;
			fmDatac = fmc.serialize()
			
			fmc.find('label').removeClass('rg_error_label')
			fmc.find('input').each(function(i){
				var vl = $(this).val()
				var id = $(this).attr('id')
				var lb = fmc.find('label[for='+id+']')
				$(this).removeClass('rg_error_field')
				if ( vl == '' ) {
					$(this).addClass('rg_error_field')
					lb.addClass('rg_error_label')
					er += 1
				}
			})
			if ( er > 0 ) {
				fmc.find('.some-messages').addClass('active').html('Some errors were found, please correct them then try again.')
				return false;
			}
          
            var acc = '&action='+dz.dc
			var noc = '&nonce='+dz.nonce
			
			$.ajax({
				type:'POST', dataType:'json', url:dz.ajax, data:fmDatac+acc+noc, 
				beforeSend: function() {
			
					fmc.find('.some-messages').removeClass('rg_error_field').html('')
					fmc.find('.some-messages').removeClass('rg_error_field').html('')
					
					fmc.find('.some-messages').addClass('rg_error_field').html('<strong>Info!</strong> sending.., please wait.')
				},
				error: function (err) {
					fmc.find('.some-messages').removeClass('rg_error_field').html('')

					fmc.find('.some-messages').addClass('rg_error_field').html('Please contact the owner.')
					
					console.log('~some 1 server error~')
				}
			}).done(function( data ) {
				fmc.find('.some-messages').addClass('alert alert-success').html(data.message)
				if ( data.status === 'error' ){
					console.log(data.message)
					console.log('~ status some server error~')
				} else if ( data.status === 'success' ) {
					// reset
					console.log(data.message)
					fmc.find('label').removeClass('rg_error_field')
					
					
				}
			})
			
		})
		
	
	})
	
	
	

})( jQuery )