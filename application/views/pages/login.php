<div class="page-header">
  <h1>Login</h1>
</div>
<div class="static-page">	
	<div id="loginFormError" class="alert alert-danger" style="display:none;">
	  <strong>Failed!</strong> Please correct the errors.
	</div>
	<form id="loginForm" class="form-horizontal">								  
	   <div id="loginEmailBlock" class="form-group">									 
			<label for="loginEmail" class="col-sm-2 control-label">Email:</label>
			<div class="col-sm-10">
				<div class="inner-addon left-addon">
					<i class="glyphicon glyphicon-envelope"></i>
					<input type="text" class="form-control" data-validate="required, email" name="loginEmail" id="loginEmail" maxlength="50" placeholder="Email" value=""/>
					<span id="loginEmailSpan" class="help-block"></span>
				</div>
			</div>
	   </div>
	   <div id="signupPasswordBlock" class="form-group">								
			<label for="loginPassword" class="col-sm-2 control-label">Password:</label>
			<div class="col-sm-10">	
				<div class="inner-addon left-addon">
					<i class="glyphicon glyphicon-lock"></i>					  									  
					<input type="password" class="form-control" data-validate="required" name="loginPassword" id="loginPassword" maxlength="50" placeholder="Password" value=""/>
					<span id="loginPasswordSpan" class="help-block"></span>
				</div>
			</div>
	   </div>										
	   <div class="col-sm-offset-2">
			<button type="button" id="login" class="btn btn-danger">Submit</button>
		</div>
	  </form>
</div>					