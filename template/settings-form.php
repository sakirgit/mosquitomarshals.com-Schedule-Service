<form class="settings-location-carlo">
<div class="container">
<div class="page-header">
    <h1>Settings</h1>  
	
  </div>
   <div class="row">
   <div class="col-sm-4">
       <div class="panel panel-primary">
    <div class="panel-heading">Subject</div>
    <div class="panel-body">
        <div class="form-group">
		<input type="text" value="<?=get_option("subject_custom_js")?>" class="form-control" id="subject" name="subject">
	  </div>
        
    </div>
    </div>
	
        </div> 
   
       <div class="col-sm-4">
       <div class="panel panel-primary">
    <div class="panel-heading">Email Address</div>
    <div class="panel-body">
        <div class="form-group">
		<input type="text" value="<?=get_option("email_custom_js")?>" class="form-control" id="emailAddress" name="emailaddreee">
	  </div>
        
    </div>
    </div>
	
        </div> 
        
         <div class="col-sm-8">
       <div class="panel panel-primary">
    <div class="panel-heading">Message Error</div>
    <div class="panel-body">
        <div class="form-group">
		<textarea class="form-control" name="message_error"><?=get_option("message_error_js")?></textarea>
	  </div>
        
    </div>
    </div>
        </div>
        <div class="col-sm-8">
       <div class="panel panel-primary">
    <div class="panel-heading">Message Success</div>
    <div class="panel-body">
       <div class="form-group">
		<textarea class="form-control" name="message_success"><?=get_option("message_success_js")?></textarea>
	  </div>
        
    </div>
    </div>
        </div>
        <div class="col-sm-8">
	   <button type="submit" class="btn btn-primary">Save</button>
	<div class="mt-4 some-messages"></div>
	  </div> 
   </div> 
  
  </div> 
</form>  