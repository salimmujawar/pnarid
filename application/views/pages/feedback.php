<div class="page-header">
  <h2>Feedback</h2>
</div>
<div class="static-page">
	<div class="bs-example" data-example-id="basic-forms"> 
		<div id="feedbackFormSuccess" class="alert alert-success" style="display:none;">
		  <strong>Thanks!</strong> for you valuable feedback.
		</div>
		<div id="feedbackFormError" class="alert alert-danger" style="display:none;">
		  <strong>Error! </strong> <span id="cancelErr">Please correct the errors.</span>
		</div>
		<form id="feedbackForm" class="form-horizontal">
		<div id="feedbackNameBlock" class="form-group">									 
			<label for="feedbackName" class="col-sm-2 control-label">Name:</label>
			<div class="col-sm-10">
				<div class="input-group">
				   <span class="input-group-addon">
					 <span class="glyphicon glyphicon-user"></span>
				   </span>
				   <input type="text" class="form-control" data-validate="required" name="feedbackName" id="feedbackName" maxlength="50" placeholder="Name" value=""/>
			  
				</div>
			   <span id="feedbackNameSpan" class="help-block"></span>
			</div>			
		</div>
		<div id="feedbackEmailBlock" class="form-group">									 
			<label for="feedbackEmail" class="col-sm-2 control-label">Email:</label>
			<div class="col-sm-10">
				<div class="input-group">
				   <span class="input-group-addon">
					 <span class="glyphicon glyphicon-envelope"></span>
				   </span>
				   <input type="text" class="form-control" data-validate="required, email" name="feedbackEmail" id="feedbackEmail" maxlength="50" placeholder="Email" value=""/>
			  
				</div>
			   <span id="feedbackEmailSpan" class="help-block"></span>
			</div>			
		</div>
	  <div id="feedbackMobileBlock" class="form-group">									 
		<label for="feedbackMobile" class="col-sm-2 control-label">Mobile:</label>
		<div class="col-sm-10">
			<div class="input-group">
			   <span class="input-group-addon">
				 <span class="glyphicon glyphicon-phone"></span>
			   </span>				   
				<input type="text" class="form-control" data-validate="required" name="feedbackMobile" id="feedbackMobile" maxlength="15" placeholder="Mobile" value=""/>		  
			</div>
		   <span id="feedbackMobileSpan" class="help-block"></span>
		</div>			
	</div>
		<div id="feedbackCategoryBlock" class="form-group">									 
			<label for="feedbackCategory" class="col-sm-2 control-label">Category:</label>
			<div class="col-sm-10">
				<div class="input-group">
				   <span class="input-group-addon">
					 <!-- span class="glyphicon glyphicon-envelope"></span-->
				   </span>
				   
				  <select name="feedbackCategory" id="feedbackCategory" class="form-control" data-validate="required"> 
	
					 <option value="">Select Category</option>
	
					 <option value="Ride booking related questions">Ride booking related suggestions</option>
	
					 <option value="Grievances about customer support">Customer support feedback</option>
	
					 <option value="General site feedback &amp; suggestions">General site feedback &amp; suggestions</option>							 
	
				   </select>
				</div>
			   <span id="feedbackCategorySpan" class="help-block"></span>
			</div>			
		</div>		
		  <div id="feedbackScoreBlock" class="form-group">
			<label for="feedBackEmail" class="col-sm-2 control-label">Your score</label>
			<div class="col-sm-10">
			  <label class="radio-inline">
			  <input type="radio" name="feedbackScore" id="feedbackScore" value="Excellent"> Excellent
			</label>
			<label class="radio-inline">
			  <input type="radio" name="feedbackScore" id="feedbackScore1" value="Satisfied"> Satisfied
			</label>
			<label class="radio-inline">
			  <input type="radio" name="feedbackScore" id="feedbackScore2" value="UnSatisfied"> UnSatisfied
			</label>
			 <span id="feedbackScoreSpan" class="help-block"></span>
			</div>
			
		  </div>
		  
		  <div id="feedbackMessageBlock" class="form-group">									 
			<label for="feedbackMessage" class="col-sm-2 control-label">Message(Optional):</label>
			<div class="col-sm-10">
				<div class="input-group">
				   <span class="input-group-addon">
					 <!-- span class="glyphicon glyphicon-envelope"></span-->
				   </span>				   
					<textarea id="feedbackMessage" name="feedbackMessage" class="form-control" rows="3" style="resize:none"></textarea>		  
				</div>
			   <span id="feedbackMessageSpan" class="help-block"></span>
			</div>			
		</div>

		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button id="feedbackSubmit" type="button" class="btn btn-danger">Submit</button>
			</div>
		  </div>
		</form>					
	</div>
</div>