<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
	#service-product {
		 display: flex;
		 flex-wrap: wrap;
		 justify-content: flex-start;
	}
	#service-product label{
		 display: inline-block;
		 margin-right: 11px;
		 margin-bottom: 11px;
	}
	#service-product label .item-type{
		margin: 0;
		padding: 20px;
		border: 1px solid #ddd !important;
		border-radius: 7px;
	}
	#service-product label .item-type .row-items-1 {
		 margin-right: 5px;
	}
</style>
<div class="schedule-service__progress">
<div class="schedule-service__progress--item active" id="next-progress-1"><span>1. Your Information</span><span class="arrow"></span></div>
<div class="schedule-service__progress--item" id="next-progress-2"><span>2. Select Service / Payment</span><span class="arrow"></span></div>
<div class="schedule-service__progress--item" id="next-progress-3"><span>3. Confirmation</span></div>
</div>
<div id="firstInformation">
<div class="form-contaner">
<div class="step-1 form">
<div id="column-service-1" style="float: left; width: 50%;">
<h3>What is your name?</h3>
<div class="row-1">
<div class="form-group"><label for="firstname">First Name:</label>
<input type="text" class="form-control" id="firstname" /><span for="firstname"></span></div>
<div class="form-group"><label for="lastname">Last Name:</label>
<input type="text" class="form-control" id="lastname" /><span for="lastname"></span></div>
</div>
<div id="clear" class="clear"></div>
<h3 id="contacts-form" style="margin-top: 26px;">How should we contact you?</h3>
<div class="row-1">
<div class="form-group"><label for="emailAddress">Email:</label>
<input type="email" class="form-control" id="emailAddress" /><span for="emailAddress"></span></div>
<div class="form-group"><label for="phoneNumber">Phone:</label>
<input type="text" class="form-control" id="phoneNumber" /><span for="phoneNumber"></span></div>
</div>
</div>
<div id="column-service-2" style="float: right; width: 50%;">
<h3>What is the property address?</h3>
<div class="row-1">
<div class="form-group street"><label for="streetAddress">Street Address:</label>
<input type="text" class="form-control" id="streetAddress" /><span for="streetAddress"></span></div>
</div>
<div class="row-2">
<div class="form-group city"><label for="cityInput">City:</label>
<input type="text" class="form-control" id="cityInput" /><span for="cityInput"></span></div>
<div class="form-group state"><label for="usr">State:</label>
<select name="stateInput" id="stateInput">
<option value="AL">AL</option>
<option value="GA">GA</option>
<option value="MS">MS</option>
<option value="FL">FL</option>
<option value="TX">TX</option>
<option value="TN">TN</option>
</select></div>
<div class="form-group zip"><label for="zipInput">Zip Code:</label>
<input type="text" class="form-control" id="zipInput" /><span for="zipInput"></span></div>
</div>
</div>
</div>
</div>
<div class="clear"></div>
<div><button type="submit" class="schedule-service--next btn btn-scheme-light btn-scheme-hover-light btn-style-default btn-style-semi-round btn-size-default" id="nextProcess" onclick="pestSubmition(this)">Next</button></div>
</div>
<div id="secondInformation" style="display: none;">
<div class="step-2 form">
<div id="column-service-1" style="float: left; width: 50%;">
<h3>Your Information</h3>
<div class="row-1">
<div id="your-name"></div>
<div id="your-location"></div>
<div id="your-phone"></div>
<div id="your-email"></div>
<span onclick="reloadAgain()" style="cursor: pointer;">Edit</span>

</div>
</div>
<div id="column-service-2" style="float: left; width: 50%;">
<h3>Service Provider</h3>
<div class="row-1">
<div id="service-name"></div>
<div id="service-location"></div>
<div id="service-phone"></div>
<div id="service-email"></div>
</div>
</div>
<div class="clear"></div>
<div id="column-service-3" style="float: left; width: 100%; margin-top: 30px;">
<h3>What type of service do you need?</h3>
	</div>
	<div class="form-group" style="margin-top: 20px; margin-bottom: 20px;"><label class="checkbox"><input name="request_information" type="checkbox" id="request_information" onclick="myRequest()" /> <strong style="color: red;">Request More Information</strong>
	</label></div>
<div id="service-product"></div>
</div>
</div>
<div><input type="hidden" class="form-control" id="customerID" />
<input type="hidden" class="form-control" id="pestID" />
<input type="hidden" class="form-control" id="officeID" />
<input type="hidden" class="form-control" id="authenticationKey" />
<input type="hidden" class="form-control" id="authenticationToken" /></div>
<div id="moreInfo">
<div class="payment-title">
<h3>Payment Information</h3>
</div>
<div class="form-container">
<div class="field-container" style="display: none !important;"><label for="name">Name</label>
<input id="name" maxlength="20" type="text" /></div>
<div class="field-container">

<label for="cardnumber">Card Number</label><span id="generatecard"></span>
<input id="cardnumber" type="text" pattern="[0-9]*" inputmode="numeric" />
<svg id="ccicon" class="ccicon" width="750" height="471" viewbox="0 0 750 471" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"></svg>

&nbsp;

&nbsp;

</div>
<div class="field-container"><label for="expirationdate">Expiration (mm/yy)</label>
<input id="expirationdate" type="text" pattern="[0-9]*" inputmode="numeric" /></div>
<div class="field-container"><label for="securitycode">Security Code</label>
<input id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric" /></div>
</div>
<div class="form-group"><label for="usr">Enter Promo Code:</label>
<input type="text" class="form-control" id="promoCode" style="display: block;padding: 15px; width: 37%; border: 1px solid #a8a8a8; border-radius: 3px; margin-bottom: 20px; margin-top: 5px;" />
<small>Your promo discount will be applied before you are charged for your first treatment.</small></div>
<div class="display"><a href="#final_process" type="submit" onclick="scheduleAppointment(this)" class="schedule-service--next run">Schedule Appointment</a></div>
</div>
<div id="zipcodeAvailable" style="display: none;">
<h3 style="font-size: 19px;">Thank you for your interest, but we are not currently offering services to this location. <span id="availableCode"></span></h3>
<p style="font-size: 19px;">To learn how you can join the Marshal Team, please visit our Franchise Opportunities page to <a href="https://mosquito.wordpressthe.com/franchise-opportunities/">learn more.</a></p>

</div>
<div id="confirmedInformation" style="display: none;">
<div id="column-service-3" style="float: left; width: 100%; margin-top: 30px;">
<h3>Service Has Been Requested!</h3>
<div id="message-confirmed">Email confirmation has been sent out. A Mosquito Marshals representative will be in touch</div>
</div>
<div class="clear"></div>
<div class="step-2 form">
<div id="column-service-1" style="float: left; width: 50%;">
<h3>Your Information</h3>
<div class="row-1">
<div id="confirm-name"></div>
<div id="confirm-location"></div>
<div id="confirm-phone"></div>
<div id="confirm-email"></div>
<div id="fieldroutes_customer"></div>
</div>
</div>
<div id="column-service-2" style="float: left; width: 50%;">
<h3>Service Provider</h3>
<div class="row-1">
<div id="confirmed-name"></div>
<div id="confirmed-location"></div>
<div id="confirmed-phone"></div>
<div id="confirmed-email"></div>
</div>
</div>
</div>
</div>
<div id="processED"></div>
<script>

$(function(){
			
	
		$('.run').click(function(){
			
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
				formData.append('fname', document.getElementById('firstname').value);
				formData.append('lname', document.getElementById('lastname').value);
				formData.append('address', document.getElementById('streetAddress').value);
				formData.append('email', document.getElementById('emailAddress').value);
				formData.append('phone', document.getElementById('phoneNumber').value);
				formData.append('sprovider', document.getElementById("service-name").textContent);
				formData.append('sarea', document.getElementById("service-location").textContent);
				formData.append('spemail', document.getElementById("service-email").textContent);
				formData.append('pay_cardnumber', document.getElementById('cardnumber').value.replace(/\D/g, ''));
				formData.append('pay_expirationdate', document.getElementById('expirationdate').value);
				formData.append('pay_securitycode', document.getElementById('securitycode').value);
				formData.append('pay_promoCode', document.getElementById('promoCode').value);
				formData.append('pay_request_information', document.getElementById('request_information').value);
				
				fetch(window.location.protocol + '//' + window.location.hostname + '/wp-json/pestmarhsal/v1/serveid', {
				method: 'POST',
				body: formData,
				})
				.then(response => response.json())
				.then(result => {
					console.log('Success Test:', result);
					
				var noteMessage = 'Service:' + result.title + ' | price:' + result.price + ' | ';
				var checkBoxed = document.getElementById("request_information");
				if (checkBoxed.checked == true){
				noteMessage += '';
				} else {
				noteMessage += 'Card Number:' + document.getElementById('cardnumber').value.replace(/\D/g, '') + ', Expiration:  ' + document.getElementById('expirationdate').value + ' Security  Code: ' + document.getElementById('securitycode').value + ' Promo Code: ' + document.getElementById('promoCode').value;

				}
					/*
				$.post("https://msmosquitocontrol.pestroutes.com/api/import/main",
					{
						"authenticationKey": document.getElementById("authenticationKey").value,
						"authenticationToken": document.getElementById("authenticationToken").value,
						"dataMain":[
							{
								"CustomerID":      document.getElementById("customerID").value,     //Your primary key, iterate to repeat test
								"Branch":          "Pest Control", 
								"CustomerName":    document.getElementById('firstname').value + ' ' + document.getElementById('lastname').value,
								"CustomerAddress": document.getElementById('streetAddress').value,
								"CustomerCity":    document.getElementById('cityInput').value,
								"CustomerState":   document.getElementById('stateInput').value,
								"CustomerZipCode": document.getElementById('zipInput').value,
								"CustomerPhone1":  document.getElementById('phoneNumber').value,
								"CustomerPhone2":  "",
								"CustomerEmail":    document.getElementById('emailAddress').value,
								"CustomerStatus":   "Act",
								"Notes":  noteMessage,
							}
						]
					}, function(response){
						console.log(response);
					},"JSON");
					*/
					
				});
				
				
			});
		});
		
</script>