


jQuery(document).ready(function() { 
	 jQuery("#phoneNumber").keydown(function(){
			var c = jQuery(this).val();
			jQuery(this).val( c.replace(/\D/g, '') );
	  });
	   jQuery("#phoneNumber").keyup(function(){
			var c = jQuery(this).val();
			jQuery(this).val( c.replace(/\D/g, '') );
	  });
});

function myRequest() {
  var checkBox = document.getElementById("request_information");
  var text = document.getElementById("moreInfo");
  if (checkBox.checked == true){
    text.style.display = "none";
  } else {
	    text.style.display = "block";
   
  }
}

function phonenumber(inputtxt)
{
  var phoneno = /^\d{10}$/;
	  if(!phoneno.test(inputtxt)) {
		return false;
	  }else{
		return true;
	  }
	
}
function validnumber(inputtxt)
{
	var pattern = /[0-9]/;	
	  if(!pattern.test(inputtxt)) {
		return false;
	  }else{
		return true;
	  }
	
}

function pestSubmition( n ) {
	
	// check fields
	const divElem = document.querySelector("#firstInformation");
	const inputElements = divElem.querySelectorAll("input");
	var er = 0;
	
	for (var i = 0; i < inputElements.length; i++) {
		
		if ( document.getElementById(inputElements[i].id).value == '' ) {
			document.querySelector('span[for="'+inputElements[i].id+'"]').classList.add("pest_error_field");
			document.querySelector('span[for="'+inputElements[i].id+'"]').innerText = 'Required';
			er += 1;
		} else  {
			document.querySelector('span[for="'+inputElements[i].id+'"]').classList.remove("pest_error_field");
			document.querySelector('span[for="'+inputElements[i].id+'"]').innerText = '';
			
			if(inputElements[i].id == 'phoneNumber') {
				if(document.getElementById(inputElements[i].id).value.length != 10) {
					document.querySelector('span[for="'+inputElements[i].id+'"]').classList.add("pest_error_field");
					document.querySelector('span[for="'+inputElements[i].id+'"]').innerText = 'Invalid Phone number!';
					er += 1;
				}
			}
			if(inputElements[i].id == 'zipInput') {
				if(document.getElementById(inputElements[i].id).value.length != 5) {
					document.querySelector('span[for="'+inputElements[i].id+'"]').classList.add("pest_error_field");
					document.querySelector('span[for="'+inputElements[i].id+'"]').innerText = 'Invalid Zip Code!';
					er += 1;
				}
				
			}
		}
		
	}
	
	if ( er > 0 ) {
		console.log('required')
		return;
	}
	
	var ct_none_fname = document.getElementById('firstname');	
	var ct_none_lname = document.getElementById('lastname');	
	var streetAddress = document.getElementById('streetAddress');
	var ct_none_email = document.getElementById('emailAddress');	
	var ct_none_phone = document.getElementById('phoneNumber');	
	var ct_none_city = document.getElementById('cityInput');
	var ct_none_state = document.getElementById('stateInput');		
	var ct_none_zipcode = document.getElementById('zipInput');
	var element = document.getElementById("next-progress-2");
	var firstInformation = document.getElementById("firstInformation");
	var secondInformation = document.getElementById("secondInformation");
	var yournName = document.getElementById("your-name");
	var yourLocation = document.getElementById("your-location");
	var yourPhone = document.getElementById("your-phone");
	var yourEmail = document.getElementById("your-email");
	var confirmName = document.getElementById("confirm-name");
	var confirmLocation = document.getElementById("confirm-location");
	var confirmPhone = document.getElementById("confirm-phone");
	var confirmEmail = document.getElementById("confirm-email");
	var nextProcess = document.getElementById("nextProcess");
	var messageConfirm = document.getElementById("processED");
		
	

	ct_none_email.setAttribute('style','border-color: #bbb;');
	if(ct_none_email.value.indexOf("@") != -1) {
		ct_none_email.setAttribute('style','border-color: #bbb;');
	} else {
		 ct_none_email.setAttribute('style','border-color: red;');
		if(ct_none_email.value.length == 0) {
			return console.log('Email Address Required!');
		} else {
			return console.log('Invalid Email Address!');
		}
		
	}
	
	
	document.getElementById("nextProcess").disabled = true; 
	messageConfirm.setAttribute('style','margin-top: 10px;color: #ed1c24;clear: both;');
	messageConfirm.innerHTML = 'Processing...';
	
	const formData = new FormData();
	formData.append('xinfox', 'xinfox');
	formData.append('fname', ct_none_fname.value);
	formData.append('lname', ct_none_lname.value);
	formData.append('email', ct_none_email.value);
	formData.append('phone', ct_none_phone.value);
	formData.append('zipcode', ct_none_zipcode.value);
	formData.append('street', streetAddress.value);
	formData.append('city', ct_none_city.value);
	formData.append('state', ct_none_state.value);
	
	const customerFormData = Object.fromEntries(formData.entries());
	
	fetch(window.location.protocol + '//' + window.location.hostname + '/wp-json/pestmarhsal/v1/create', {
		method: 'POST',
		body: formData,
		})
		.then(response => response.json())
		.then(result => {
			console.log('Success:', result);
			if(result.verify == 0) {
				messageConfirm.setAttribute('style','display: none;');	
			}
			
			if(result.verify != 0) {
				
					messageConfirm.setAttribute('style','margin-top: 10px;color: #ed1c24;clear: both');
					messageConfirm.innerHTML = '';
					
					element.classList.add("active");
					firstInformation.setAttribute('style','display: none;');
					secondInformation.setAttribute('style','display: block;');
					
					yournName.innerHTML = ct_none_fname.value + ' ' + ct_none_lname.value;
					yourLocation.innerHTML = streetAddress.value + '<br>' + ct_none_city.value + ', ' + ct_none_state.value + ' ' + ct_none_zipcode.value;
					yourPhone.innerHTML = ct_none_phone.value;
					yourEmail.innerHTML = ct_none_email.value;
					
					var serviceName = document.getElementById("service-name");
					var serviceLocation = document.getElementById("service-location");
					var servicePhone = document.getElementById("service-phone");
					var serviceEmail = document.getElementById("service-email");
					
				
				for (var i = 0; i < result.length; i++) {
					
					serviceName.innerHTML = result[i].title;
					serviceLocation.innerHTML = result[i].address;
					servicePhone.innerHTML = result[i].phone;
					serviceEmail.innerHTML = result[i].email;
					document.getElementById("officeID").value = result[i].officeid;
				//	document.getElementById("authenticationKey").value = result[i].authenticationkey;
				//	document.getElementById("authenticationToken").value = result[i].authenticationtoken; 
					
					const selectData = new FormData();
					selectData.append('xinfoxd', 'xinfoxd');
					selectData.append('locationid', result[i].slid);
				//	console.log('customerFormData 3: ', JSON.stringify(customerFormData));
					
					
					/* ============== Service type inputs =============== */
					/* ============== Service type inputs =============== */

					
					var serviceDescraiption = document.getElementById("service-product");
					serviceDescraiption.innerHTML = '';
					
					if(result[i].service_types_data.status !== 'error') {
						for (var j = 0; j < result[i].service_types_data.length; j++) {
						//	console.log('Success 53s13:', result[i].service_types_data);
							serviceDescraiption.innerHTML += '<label>' + result[i].service_types_data[j].product + result[i].service_types_data[j].description + '</label>';
						}
					} else {
						serviceDescraiption.innerHTML = '<p id="pest_warning">No services available.</p>';
					}
					/* ============== Service type inputs =============== */
					/* ============== Service type inputs =============== */
					/*
					fetch(window.location.protocol + '//' + window.location.hostname + '/wp-json/pestmarhsal/v1/get', {
					method: 'POST',
					body: selectData,
					})
					.then(response => response.json())
					.then(result => {
						console.log('Success:', result);
						var serviceDescraiption = document.getElementById("service-product");
						serviceDescraiption.innerHTML = '';
						
						if(result.status !== 'error') {
							for (var i = 0; i < result.length; i++) {
								serviceDescraiption.innerHTML += result[i].product + result[i].description;
							}
						} else {
							serviceDescraiption.innerHTML = '<p id="pest_warning">No services available.</p>';
						}
					});
					*/
				}
				
				const getData = new FormData();
				getData.append('xinget', 'xinfoxd');
				getData.append('fname', ct_none_fname.value);
				getData.append('lname', ct_none_lname.value);
				getData.append('email', ct_none_email.value);
				getData.append('phone', ct_none_phone.value);
				getData.append('zipcode', ct_none_zipcode.value);
				
				fetch(window.location.protocol + '//' + window.location.hostname + '/wp-json/pestmarhsal/v1/person', {
				method: 'POST',
				body: getData,
				})
				.then(response => response.json())
				.then(result => {
					console.log('Success:', result);
					document.getElementById("customerID").value = result.customer;
					document.getElementById("pestID").value = result.pestid;					
				});
				
				
				
				
			} else {
					
				
					document.getElementById("availableCode").innerHTML = ct_none_zipcode.value;
					document.getElementById("next-progress-1").classList.remove("active");
					firstInformation.setAttribute('style','display: none;');
					document.getElementById("zipcodeAvailable").setAttribute('style','display: block;');
					return console.log('Zipcode not available!');
			}
			
		})
		
		
			
}



function scheduleAppointment(n) {
	
	var ct_none_fname = document.getElementById('firstname');	
	var ct_none_lname = document.getElementById('lastname');	
	var streetAddress = document.getElementById('streetAddress');
	var ct_none_email = document.getElementById('emailAddress');	
	var ct_none_phone = document.getElementById('phoneNumber');	
	var ct_none_city = document.getElementById('cityInput');
	var ct_none_state = document.getElementById('stateInput');		
	var ct_none_zipcode = document.getElementById('zipInput');
	var element = document.getElementById("next-progress-2");
	var firstInformation = document.getElementById("firstInformation");
	var secondInformation = document.getElementById("secondInformation");
	var yournName = document.getElementById("your-name");
	var yourLocation = document.getElementById("your-location");
	var yourPhone = document.getElementById("your-phone");
	var yourEmail = document.getElementById("your-email");
	var confirmName = document.getElementById("confirm-name");
	var confirmLocation = document.getElementById("confirm-location");
	var confirmPhone = document.getElementById("confirm-phone");
	var confirmEmail = document.getElementById("confirm-email");
	var nextProcess = document.getElementById("nextProcess");
	var messageConfirm = document.getElementById("processED");
	
	
	var radios = document.getElementsByName('package');
	var radioSelect = '';
	for (var i = 0, length = radios.length; i < length; i++) {
	  if (radios[i].checked) {
		// do whatever you want with the checked radio
		  radioSelect += radios[i].value;	

		// only one radio can be logically checked, don't check the rest
		break;
	  }
	}
	
	const formData = new FormData();
	formData.append('xinfox', 'xinfox');
	formData.append('serviceid', radioSelect);
	
	formData.append('fname', ct_none_fname.value);
	formData.append('lname', ct_none_lname.value);
	formData.append('email', ct_none_email.value);
	formData.append('phone', ct_none_phone.value);
	formData.append('zipcode', ct_none_zipcode.value);
	formData.append('street', streetAddress.value);
	formData.append('city', ct_none_city.value);
	formData.append('state', ct_none_state.value);
	formData.append('officeID', document.getElementById("officeID").value);
	//const withOfficeID = Object.fromEntries(formData.entries());
	console.log('formData serviceid :', formData.get("serviceid"));
	
	fetch(window.location.protocol + '//' + window.location.hostname + '/wp-json/pestmarhsal/v1/serveid', {
		method: 'POST',
		body: formData,
		})
		.then(response => response.json())
		.then(result => {
			console.log('Success Sandig:', result);
			
			document.getElementById("confirmed-name").innerHTML = document.getElementById("service-name").textContent;
			document.getElementById("confirmed-location").innerHTML  = document.getElementById("service-location").textContent;
			document.getElementById("confirmed-phone").innerHTML  = document.getElementById("service-phone").textContent;
			document.getElementById("confirmed-email").innerHTML  = document.getElementById("service-email").textContent;
			document.getElementById("fieldroutes_customer").innerHTML  = 'FLDR: '+ result.customer_id_fldr;
			
			
			confirmName.innerHTML = ct_none_fname.value + ' ' + ct_none_lname.value;
			confirmLocation.innerHTML = streetAddress.value + '<br>' + ct_none_city.value + ', ' + ct_none_state.value + ' ' + ct_none_zipcode.value;
			confirmPhone.innerHTML = ct_none_phone.value;
			confirmEmail.innerHTML = ct_none_email.value;
			
			document.getElementById("confirmedInformation").setAttribute('style','display: block;');
			secondInformation.setAttribute('style','display: none;');
			document.getElementById("next-progress-3").classList.add("active");
			document.getElementById("next-progress-3").setAttribute('style','background: #ED1C24;');
			
			
			
			
		})
	
}


function reloadAgain() {
	location.reload();
}