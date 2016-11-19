<div class="page-header">
	  <h2>Join Us</h2>
	</div>
<div class="static-page">
	
	<div class="bs-example" data-example-id="basic-forms">
		<!--Register Modal -->
		
		<div id="joinUsFormSuccess" class="alert alert-success" style="display:none;">
		  <strong>Success!</strong> Registeration completed succesfully.
		</div>		
		<div id="joinUsFormError" class="alert alert-danger" style="display:none;">			
			<strong>Failed!</strong> Please correct the errors.			  	
		</div>
		
		<form id="joinUsForm"  class="form-horizontal" >								  
		   <div id="joinusNameBlock" class="form-group  ">																	 
					<label for="joinusName" class="col-sm-2 control-label">Contact Name:</label>
					<div class="col-sm-10">
						<div class="inner-addon left-addon">
							<i class="glyphicon glyphicon-user"></i>	
							<input type="text" class="form-control" data-validate="required, char" name="joinusName" id="joinusName" maxlength="50" placeholder="Name"  value=""/>
							<span id="joinusNameSpan" class="help-block"></span>
						</div>
					</div>																		  								
				
		   </div>
		   <div id="joinusEmailBlock" class="form-group ">																	
					<label for="joinusEmail" class="col-sm-2 control-label">E-mail:</label>
					<div class="col-sm-10">
						<div class="inner-addon left-addon">									
							<i class="glyphicon glyphicon-envelope"></i>			  									  
							<input type="text" class="form-control" data-validate="required, Email" name="joinusEmail" id="joinusEmail" maxlength="50" placeholder="example@example.com" value=""/>
							<span id="joinusEmailSpan" class="help-block"></span>
						</div>
					</div>																		  								
				
		   </div>										
		   <div id="joinusPasswordBlock" class="form-group ">																	
					<label for="joinusPassword" class="col-sm-2 control-label">Password:</label>
					<div class="col-sm-10">												
						<div class="inner-addon left-addon">
							<i class="glyphicon glyphicon-lock"></i>					  									  
							<input type="password" class="form-control" data-validate="required, password" name="joinusPassword" id="joinusPassword" maxlength="50" placeholder="Password" value=""/>
							<span id="joinusPasswordSpan" class="help-block"></span>
						</div>
					</div>																		  															
		   </div>
		   <div id="joinusMobileBlock" class="form-group ">																	
					<label for="joinusMobile" class="col-sm-2 control-label">Mobile:</label>
					<div class="col-sm-10">		
						<div class="inner-addon left-addon">										
							<i class="glyphicon glyphicon-earphone"></i>			  									  
							<input type="text" class="form-control" data-validate="required, mobile" name="joinusMobile" id="joinusMobile" maxlength="12" placeholder="Mobile" value=""/>
							<span id="joinusMobileSpan" class="help-block"></span>
						</div>
					</div>																		  															
		   </div>		
		   <div id="joinusAddressBlock" class="form-group ">																	
					<label for="joinusAddress" class="col-sm-2 control-label">Address:</label>
					<div class="col-sm-10">		
						<div class="inner-addon left-addon">										
							<i class="glyphicon glyphicon-home"></i>			  									  
							<input type="text" class="form-control" data-validate="required" name="joinusAddress" id="joinusAddress" maxlength="50" placeholder="Address" value=""/>
							<span id="joinusAddressSpan" class="help-block"></span>
						</div>
					</div>																		  															
		   </div>	
	   	   <div id="joinusCityBlock" class="form-group ">																	
				<label for="joinusCity" class="col-sm-2 control-label">City:</label>
				<div class="col-sm-10">		
					<div class="inner-addon left-addon">										
						<i class="glyphicon glyphicon-globe"></i>
						<select class="form-control"  name="joinusCity" id="joinusCity" data-validate="required" class="form-control">
						  <option value="">&nbsp;&nbsp;&nbsp;City</option>
							<?php if(isset($cities) && is_array($cities)) {
   									foreach ($cities as $key => $val) {?>
   										<option value="<?php echo $val->city_id;?>">&nbsp;&nbsp;&nbsp;<?php echo $val->city_name;?></option>
   							<?php	} 
   								} ?>
						</select>		  									  
						
						<span id="joinusCitySpan" class="help-block"></span>
					</div>
				</div>																		  															
		   </div>	
		   <h4>Car details: </h4><hr/>		   
		   <div id="joinusCityBlock" class="form-group">	
			   <div class="col-sm-offset-2">				
	   				<table id="rideDetail" class="table">
	   					<thead>
	   						<tr>
	   							<th>Ride</th>
	   							<th>Number</th>	   							
	   							<th>Add/Remove</th>
	   						</tr>
	   					</thead>
	   					<tbody>	   						
	   						<tr>
	   							<td>
	   								 <div id="joinusRideBlock" class="form-group">																	
											<div class="col-sm-offset-2">							   				
								   					<select class="form-control" data-validate="required" name="joinusRide[]" id="joinusRide">
								   						<option value="">&nbsp;&nbsp;&nbsp;Ride</option>
								   						<?php if(isset($rides) && is_array($rides)) {
								   								foreach ($rides as $key => $val) {?>
								   									<option value="<?php echo $val->ride_id;?>"><?php echo $val->ride_name;?></option>
								   						<?php	} 
								   							} ?>	
													  </select>		
													  <span id="joinusRideSpan" class="help-block"></span>								   				
								   			</div>																	  															
									   </div>	
	   							</td>
	   							<td>
	   								 <div id="joinusNumberBlock" class="form-group">											
											<div class="col-sm-10">																																					  									  
												<input type="text" class="form-control" data-validate="required" name="joinusNumber[]" id="joinusNumber" maxlength="50" placeholder="MH-43-NA-5948" value="<?php echo set_value('joinusNumber[]'); ?>"/>
												<span id="joinusNumberSpan" class="help-block"></span>												
											</div>																		  															
								   </div>		
	   							</td>
	   							<td>
	   								<button type="button" class="addBtn btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></button>	   								
	   							</td>
	   						</tr>
	   					</tbody>
	   				</table>
	   			</div>		  
   			</div>
		     <script type="text/javascript">
		     	var fieldHTML = '<tr class="extraRides">\
					<td>\
						 <div id="joinusRideBlock" class="form-group">\
						 <div class="col-sm-offset-2">\
						 	<select class="form-control" data-validate="required" name="joinusRide[]" id="joinusRide">\
				   						<option value="">&nbsp;&nbsp;&nbsp;Ride</option>\
				   						<?php if(isset($rides) && is_array($rides)) { foreach ($rides as $key => $val) {?>\
				   									<option value="<?php echo $val->ride_id;?>"><?php echo $val->ride_name;?></option>\
				   						<?php	} } ?></select>\
						   			<span id="joinusRideSpan" class="help-block"></span>\
						   		</div>\
						   		</div>\
						 </td>\
					<td>\
						 <div id="joinusNumberBlock" class="form-group">\
						 	<div class="col-sm-10">\
						 	<input type="text" class="form-control" data-validate="required" name="joinusNumber[]" id="joinusNumber" maxlength="50" placeholder="MH-43-NA-5948"  value="<?php echo set_value('joinusNumber[]'); ?>"/>\
						 	<span id="joinusNumberSpan" class="help-block"></span>\
						 	</div>\
						 </div>\
					</td>\
					<td>\
					<button type="button" class="removeBtn btn btn-warning"><span class="glyphicon glyphicon-minus-sign"></span></button>\
					</td>\
				</tr>';
		     </script>
		   <div class="col-sm-offset-2">
				<button type="button" id="joinUs" class="btn btn-danger">Submit</button>
			</div>
		  </form>
	  </div>
</div>	
 
					