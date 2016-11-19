<div class="page-header">
  <h1>Cancellation</h1>
</div>
<div class="bs-example" data-example-id="basic-forms"> 
	<div id="cancelFormSuccess" class="alert alert-success" style="display:none;">
	  <strong>Success!</strong> Cancellation process initiated.
	</div>
	<div id="cancelFormError" class="alert alert-danger" style="display:none;">
	  <strong>Error! </strong> <span id="cancelErr">Please correct the errors.</span>
	</div>
	<form id="cancelForm" class="form-horizontal">		
	    <div id="cancelEmailBlock" class="form-group">									 
			<label for="cancelEmail" class="col-sm-2 control-label">Email:</label>
			<div class="col-sm-10">
            	<div class="input-group">
            	   <span class="input-group-addon">
                     <span class="glyphicon glyphicon-envelope"></span>
                   </span>
	               <input type="text" class="form-control" data-validate="required, email" name="cancelEmail" id="cancelEmail" maxlength="50" placeholder="Email" value="<?php echo $email; ?>"/>
              
	            </div>
               <span id="cancelEmailSpan" class="help-block"></span>
            </div>			
	   </div>
	   
	   <div id="cancelOrderidBlock" class="form-group">									 
			<label for="cancelOrderid" class="col-sm-2 control-label">Order ID:</label>
			<div class="col-sm-10">
            	<div class="input-group">
            	   <span class="input-group-addon">
                     <span class="glyphicon glyphicon-gift"></span>
                   </span>	               
              		<input type="text" class="form-control" data-validate="required" name="cancelOrderid" id="cancelOrderid" maxlength="50" placeholder="Order ID" value=""/>
	            </div>
               <span id="cancelOrderidSpan" class="help-block"></span>
            </div>			
	   </div>	
	   <div id="cancelReasonBlock" class="form-group">									 
			<label for="cancelReason" class="col-sm-2 control-label">Reason:</label>
			<div class="col-sm-10">
            	<div class="input-group">
            	   <span class="input-group-addon">
                     <span class="glyphicon glyphicon-question-sign"></span>
                   </span>	               
              		<select class="form-control" data-validate="required" name="cancelReason" id="cancelReason">
              			<option value="">Select a reason </option>
              			<option value="I placed a duplicate order">I placed a duplicate order </option>
              			<option value="I ordered the wrong product">I ordered the wrong product </option>
              			<option value="The driver did't reached on time">The driver did't reached on time </option>
              			<option value="Not able to contact Tech support">Not able to contact Tech support </option>
              			<option value="The ride is not as described">The ride is not as described </option>
              			<option value="Other reasons">Other reasons </option>
              		</select>
	            </div>
               <span id="cancelReasonSpan" class="help-block"></span>
            </div>			
	   </div>		
		<div class="col-sm-offset-2">
			<button id="cancelSubmit" type="button" class="btn btn btn-danger">Submit</button>  
		</div>
	</form>
</div>