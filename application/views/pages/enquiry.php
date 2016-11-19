<div class="page-header">
  <h1>Enquiry</h1>
</div>
<div class="bs-example" data-example-id="basic-forms"> 
	<div id="enquiryFormSuccess" class="alert alert-success" style="display:none;">
	  <strong>Thanks!</strong> Our sales team will contact you soon.
	</div>
	<div id="enquiryFormError" class="alert alert-danger" style="display:none;">
	  <strong>Error! </strong> <span id="cancelErr">Please correct the errors.</span>
	</div>
	<form id="enquiryForm" class="form-horizontal">	
		<div id="enquiryNameBlock" class="form-group">									 
			<label for="enquiryName" class="col-sm-2 control-label">Name:</label>
			<div class="col-sm-10">
				<div class="input-group">
				   <span class="input-group-addon">
					 <span class="glyphicon glyphicon-user"></span>
				   </span>
				   <input type="text" class="form-control" data-validate="required" name="enquiryName" id="enquiryName" maxlength="50" placeholder="Name" value=""/>
			  
				</div>
			   <span id="enquiryNameSpan" class="help-block"></span>
			</div>			
		</div>		
	   <div id="enquiryEmailBlock" class="form-group">									 
			<label for="enquiryEmail" class="col-sm-2 control-label">Email:</label>
			<div class="col-sm-10">
            	<div class="input-group">
            	   <span class="input-group-addon">
                     <span class="glyphicon glyphicon-envelope"></span>
                   </span>
	               <input type="text" class="form-control" data-validate="required, email" name="enquiryEmail" id="enquiryEmail" maxlength="50" placeholder="Email" value=""/>
              
	            </div>
               <span id="enquiryEmailSpan" class="help-block"></span>
            </div>			
	   </div>
	  	   
	  <div id="enquiryMobileBlock" class="form-group">									 
		<label for="enquiryMobile" class="col-sm-2 control-label">Mobile:</label>
		<div class="col-sm-10">
			<div class="input-group">
			   <span class="input-group-addon">
				 <span class="glyphicon glyphicon-phone"></span>
			   </span>				   
				<input type="text" class="form-control" data-validate="required" name="enquiryMobile" id="enquiryMobile" maxlength="15" placeholder="Mobile" value=""/>		  
			</div>
		   <span id="enquiryMobileSpan" class="help-block"></span>
		</div>			
	</div>	   
	<div id="enquiryTextBlock" class="form-group">									 
		<label for="enquiryText" class="col-sm-2 control-label">Enquiry:</label>
		<div class="col-sm-10">
			<div class="input-group">
			   <span class="input-group-addon">
				 <!-- span class="glyphicon glyphicon-envelope"></span-->
			   </span>				   
				<textarea maxlength="250" id="enquiryText" data-validate="required" name="enquiryText" class="form-control" rows="3" style="resize:none"></textarea>		  
			</div>
			<div id="enquiryTextLength"></div>
		   <span id="enquiryTextSpan" class="help-block"></span>
		</div>			
	</div>							
	  
	   <div id="enquiryCampangeBlock" class="form-group">																	
			<label for="enquiryMobile" class="col-sm-2 control-label">How did you hear about us?:</label>						  									  
			<div class="col-sm-10">
			<div class="input-group">
			   <span class="input-group-addon">
				 <span class="glyphicon glyphicon-question-sign"></span>
			   </span>
				<select data-validate="required" name="enquiryCampange" id="enquiryCampange" class="form-control">
		        		<option value="">Select</option>			                
		                <option value="Google">Google</option>
		                <option value="Other Search Engine">Other Search Engine</option>
		                <option value="Referral">Facebook/Twitter</option>
		                <option value="Family">Family</option>
		                <option value="Friend">Friend</option>
		                <option value="Newspaper / Magazine">Newspaper / Magazine</option>
		                <option value="Event">Event</option>
		                <option value="Other">Other</option>			                
		        </select>		        
		       </div>
		       <span id="enquiryCampangeSpan" class="help-block"></span>																					  															
			</div>
	   </div>	   
	   <div class="col-sm-offset-2">
		<button id="enquirySubmit" type="button" class="btn btn btn-danger">Submit</button> 
	  </div>
	</form> 
</div>