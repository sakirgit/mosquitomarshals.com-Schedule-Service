(function($) {
    $(document).ready(function(){
        
       $('.addAttri').click(function(){
				var acr = $(this).attr('data-num');
				acr++;
				$(this).before('<div class="form-group"><label for="titleZip-'+acr+'">Zip Code</label><input type="text" class="form-control" name="itempest[][zipcode]" id="titleZip-'+acr+'" data-num="'+acr+'"><label for="priceZip-'+acr+'">Price</label><input type="text" class="form-control" name="itempest[][price]" id="priceZip-'+acr+'" data-num="'+acr+'"></div>')
				$(this).attr('data-num', acr )
				console.log(acr)
		})
        
			$('.addUpdate').click(function(){
				 var acx = $(this).attr('data-num');
				console.log(acx)
				
			  var dlp = $('#zipcode_'+acx+' :input')
			  fmData = dlp.serialize()
			  
			  var uv = '&serviceType='+$('#serviceUpdate_'+acx).val()
			  var ac = '&action='+du.dl
				var no = '&nonce='+du.nonce
				$.ajax({
					type:'POST', dataType:'json', url:du.ajax, data:fmData+uv+ac+no, 
					beforeSend: function() {
						$('.message_delete_'+acx).addClass('active').html('Updating.., please wait.')
					},
					error: function (err) {
						$('.message_delete_'+acx).addClass('active').html('Please contact the owner.')
						console.log('~some server error~')
					}
				}).done(function( data ) {
					if ( data.status === 'error' ){
						console.log('~some server error~')
						$('.message_delete_'+acx).addClass('active').html(data.message)
					} else if ( data.status === 'success' ) {
						// reset
						console.log(data.message)
						$('.message_delete_'+acx).addClass('active').html(data.message)
					}
				})
				
			})
		
          $('.addDelete').click(function(){
			  var acp = $(this).attr('data-num');
			  console.log(acp)
			  
			  var dm = $('#zipcode_'+acp+' :input')
			  fmData = dm.serialize()
			  
			  var ac = '&action='+dp.de
				var no = '&nonce='+dp.nonce
				$.ajax({
					type:'POST', dataType:'json', url:dp.ajax, data:fmData+ac+no, 
					beforeSend: function() {
						$('.message_delete_'+acp).addClass('active').html('Deleting code, please wait.')
					},
					error: function (err) {
						$('.message_delete_'+acp).addClass('active').html('Please contact the owner.')
						console.log('~some server error~')
					}
				}).done(function( data ) {
					if ( data.status === 'error' ){
						console.log('~some server error~')
						$('.message_delete_'+acp).addClass('active').html(data.message)
					} else if ( data.status === 'success' ) {
						// reset
						console.log(data.message)
						$('.message_delete_'+acp).addClass('active').html(data.message)
						$('#zipcode_'+acp).remove()
					}
				})
		  })
        
        $('#pestSave').click(function(){
			//var acr = $(this).attr('data-num');
			console.log('submit')
			
			
			//check this
			var fm = $('.itemzattributes :input')
			var fd = $('.itemzattributes')
			var er = 0;
			fmData = fm.serialize()
			
			
			fm.find('label').removeClass('rg_error_field')
			fm.find('.some-messages').removeClass('active').html('')

			var fv = '&serviceType='+$('#serviceType').val()
			var ac = '&action='+ps.pe
			var no = '&nonce='+ps.nonce
			$.ajax({
				type:'POST', dataType:'json', url:ps.ajax, data:fmData+fv+ac+no, 
				beforeSend: function() {
					$('.some-messages').addClass('active').html('Saving zip code, please wait.')
					$('#pestSave').addClass('hide_button')
				},
				error: function (err) {
					$('.some-messages').addClass('active').html('Please contact the owner.')
					$('#pestSave').removeRemove('hide_button')
					console.log('~some server error~')
				}
			}).done(function( data ) {
				fd.find('.some-messages').addClass('active').html(data.message)
				if ( data.status === 'error' ){
					console.log('~some server error~')
					$('#pestSave').removeRemove('hide_button')
				} else if ( data.status === 'success' ) {
					// reset
					$('#pestSave').addClass('hide_button')
					fm.find('input').each(function(i){
						$(this).val('')
					})
					$('.some-messages').addClass('active').html(data.message)
					location.assign(window.location.href);
				}
			})
			
			
			
		})
		
		
		
		$('.settings-location-carlo').submit(function(alucards){
			alucards.preventDefault()
			console.log('Location Zip')
			alucards.stopImmediatePropagation()
			
			var fmc = $(this)
			var er = 0;
			fmDatac = fmc.serialize()
			
			fmc.find('label').removeClass('rg_error_label')
			fmc.find('input, textarea').each(function(i){
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
          
		
            var acc = '&action='+sp.sv
			var noc = '&nonce='+sp.nonce
			
			$.ajax({
				type:'POST', dataType:'json', url:sp.ajax, data:fmDatac+acc+noc, 
				beforeSend: function() {
			
					fmc.find('.some-messages').removeClass('rg_error_field').html('')
					fmc.find('.some-messages').removeClass('rg_error_field').html('')
					
					fmc.find('.some-messages').addClass('rg_error_field').html('<strong>Info!</strong> Saving.., please wait.')
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
		
		
		
		
		
    });
})( jQuery )