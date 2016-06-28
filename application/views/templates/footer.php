
</div>
</div>
<div class="footer_top">
	<div class="container">
		<div class="row">

			<div class="col-xs-6 col-sm-4">
				<h3 class="menu_head">Support</h3>
				<div class="footer_menu">
					<ul>
						<li><span class="glyphicon glyphicon-menu-right"></span><a href="<?php echo base_url('about-us');?>">About Us</a></li>
						<li><span class="glyphicon glyphicon-menu-right"></span><a href="<?php echo base_url('contact-us');?>">Contact Us</a></li>
						<li><span class="glyphicon glyphicon-menu-right"></span><a href="<?php echo base_url('feedback');?>">Feedback</a></li>
						<li><span class="glyphicon glyphicon-menu-right"></span><a href="<?php echo base_url('join-us');?>">Join Us</a></li>
					</ul>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4">
				<h3 class="menu_head">Policies</h3>
				<div class="footer_menu">
					<ul>
						<li><span class="glyphicon glyphicon-menu-right"></span><a href="<?php echo base_url('terms-conditions');?>">Terms
								&amp; Conditions </a></li>
						<li><span class="glyphicon glyphicon-menu-right"></span><a href="<?php echo base_url('disclaimer');?>">Disclaimer</a></li>
						<li><span class="glyphicon glyphicon-menu-right"></span><a href="<?php echo base_url('privacy-policy');?>">Privacy
								Policy </a></li>
					</ul>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="footer_b">
	<div class="container">
		<div class="row">
			<div class="col-xs-6 col-sm-4">
				<div class="footer_bottom">
					<p class="text-block">
						<strong>© Copyright reserved to <span>Pin A Ride </span></strong>
					</p>
				</div>
			</div>
			<div class="col-xs-6 col-sm-3 pull-right">
				<div class="footer_mid ">					
					<ul class="social-contact list-inline">
						<li><strong>Follow us on: </strong></li>
						<li>
							<a href="https://www.facebook.com/pinaride" target="_blank"><img alt="Pin A Ride Facebook"
								src="<?php echo base_url('assets/images/Facebook.png');?>" class="fotter-social"></a>
						</li>
						<li>
							<a href="https://twitter.com/pinaride" target="_blank"><img alt="Pin A Ride Twitter"
								src="<?php echo base_url('assets/images/Twitter.png');?>" class="fotter-social"></a>
						</li>
						<li>
							<a href="https://plus.google.com/+PinarideIndia" target="_blank"><img alt="Pin A Ride Google Plus"
								src="<?php echo base_url('assets/images/Google-plus.png');?>" class="fotter-social"></a>
						</li>
						<li>
							<a href="https://pinterest.com/pinaride" target="_blank"><img alt="Pin A Ride Pinterest"
								src="<?php echo base_url('assets/images/Pinterest.png');?>" class="fotter-social"></a>
						</li>						
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!--SignIn Modal -->
<div class="modal fade" id="signinModal" tabindex="-1" role="dialog"
	aria-labelledby="signinModalLabel" aria-hidden="true">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog vertical-align-center">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

					</button>
					<h4 class="modal-title" id="signinModalLabel">Signin</h4>

				</div>
				<div class="modal-body">
					<div id="signinFormError" class="alert alert-danger"
						style="display: none;">
						<strong>Failed!</strong> Please correct the errors.
					</div>
					<form id="signinForm" class="form-horizontal">
						<div id="signinEmailBlock" class="form-group">
							<label for="signinEmail" class="col-sm-2 control-label">Email:</label>
							<div class="col-sm-10">
								<div class="inner-addon left-addon">
									<i class="glyphicon glyphicon-envelope"></i> <input type="text"
										class="form-control" data-validate="required, email"
										name="signinEmail" id="signinEmail" maxlength="50"
										placeholder="Email" value="" /> <span id="signinEmailSpan"
										class="help-block"></span>
								</div>
							</div>
						</div>
						<div id="signinPasswordBlock" class="form-group">
							<label for="signinPassword" class="col-sm-2 control-label">Password:</label>
							<div class="col-sm-10">
								<div class="inner-addon left-addon">
									<i class="glyphicon glyphicon-lock"></i> <input type="password"
										class="form-control" data-validate="required"
										name="signinPassword" id="signinPassword" maxlength="50"
										placeholder="Password" value="" /> <span
										id="signinPasswordSpan" class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="col-sm-offset-2">
							<button type="button" id="signIn" class="btn btn-danger" >Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog"
	aria-labelledby="registerModalLabel" aria-hidden="true">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog vertical-align-center">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>

					</button>
					<h4 class="modal-title" id="registerModalLabel">Register</h4>

				</div>
				<div class="modal-body">
					<div id="signUpFormSuccess" class="alert alert-success"
						style="display: none;">
						<strong>Success!</strong> Registeration completed succesfully.
					</div>
					<div id="signUpFormError" class="alert alert-danger"
						style="display: none;">
						<strong>Failed!</strong> Please correct the errors.
					</div>
					<form id="signUpForm" class="form-horizontal">
						<div id="signupNameBlock" class="form-group">
							<label for="signupName" class="col-sm-2 control-label">Name:</label>
							<div class="col-sm-10">
								<div class="inner-addon left-addon">
									<i class="glyphicon glyphicon-user"></i> <input type="text"
										class="form-control" data-validate="required, char"
										name="signupName" id="signupName" maxlength="50"
										placeholder="Name" value="" /> <span id="signupNameSpan"
										class="help-block"></span>
								</div>
							</div>

						</div>
						<div id="signupEmailBlock" class="form-group">
							<label for="signupEmail" class="col-sm-2 control-label">E-mail:</label>
							<div class="col-sm-10">
								<div class="inner-addon left-addon">
									<i class="glyphicon glyphicon-envelope"></i> <input type="text"
										class="form-control" data-validate="required, Email"
										name="signupEmail" id="signupEmail" maxlength="50"
										placeholder="example@example.com" value="" /> <span
										id="signupEmailSpan" class="help-block"></span>
								</div>
							</div>

						</div>
						<div id="signupPasswordBlock" class="form-group">
							<label for="signupPassword" class="col-sm-2 control-label">Password:</label>
							<div class="col-sm-10">
								<div class="inner-addon left-addon">
									<i class="glyphicon glyphicon-lock"></i> <input type="password"
										class="form-control" data-validate="required, password"
										name="signupPassword" id="signupPassword" maxlength="50"
										placeholder="Password" value="" /> <span
										id="signupPasswordSpan" class="help-block"></span>
								</div>
							</div>
						</div>
						<div id="signupMobileBlock" class="form-group">
							<label for="signupMobile" class="col-sm-2 control-label">Mobile:</label>
							<div class="col-sm-10">
								<div class="inner-addon left-addon">
									<i class="glyphicon glyphicon-phone"></i> <input type="text"
										class="form-control" data-validate="required, mobile"
										name="signupMobile" id="signupMobile" maxlength="12"
										placeholder="Mobile" value="" /> <span id="signupMobileSpan"
										class="help-block"></span>
								</div>
							</div>
						</div>
						<div class="col-sm-offset-2">
							<button type="button" id="signUp" class="btn btn-danger">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript"
	src="<?php echo base_url('assets/js/jquery-1.11.3.min.js?ver=' . CACHE_VERSION);?>"
	charset="UTF-8"></script>
<script type="text/javascript"
	src="<?php echo base_url('assets/js/bootstrap.min.js?ver=' . CACHE_VERSION);?>"></script>
<script type="text/javascript"
	src="<?php echo base_url('assets/js/moment.js?ver=' . CACHE_VERSION); ?>"></script>
<script type="text/javascript"
	src="<?php echo base_url('assets/js/bootstrap-datetimepicker.js?ver=' . CACHE_VERSION);?>"
	charset="UTF-8"></script>
<script type="text/javascript"
	src="<?php echo base_url('assets/js/common.js?ver=' . CACHE_VERSION);?>"
	charset="UTF-8"></script>
<?php if(isset($js_files) && is_array($js_files)) { ?>
    		<?php foreach($js_files as $key => $val) {
	    			if(!empty($val)) { ?>
<script type="text/javascript"
	src="<?php echo base_url('assets/js/'.$val.'.js?ver=' . CACHE_VERSION);?>"
	charset="UTF-8"></script>
<?php 
					}
    			} ?>
    <?php } ?>
<?php 
$user = isLogin();
$grp_id = 0;
if(is_object($user) && !empty($user->id)) {
        $grp_id = getGroup($user->id);
}
if($grp_id != 1 && ENVIRONMENT != 'development') { ?>
<!--script type='text/javascript'>
    window._sbzq||function(e){e._sbzq=[];var t=e._sbzq;t.push(["_setAccount",43723]);var n=e.location.protocol=="https:"?"https:":"http:";var r=document.createElement("script");r.type="text/javascript";r.async=true;r.src=n+"//static.subiz.com/public/js/loader.js";var i=document.getElementsByTagName("script")[0];i.parentNode.insertBefore(r,i)}(window);
</script-->
<!-- Google Code for Search Form Clicked Conversion Page
In your html page, add the snippet and call
goog_report_conversion when someone clicks on the
chosen link or button. -->
<script type="text/javascript">
  /* <![CDATA[ */
  goog_snippet_vars = function() {
    var w = window;
    w.google_conversion_id = 882338006;
    w.google_conversion_label = "4vV4CP3G1mcQ1tHdpAM";
    w.google_remarketing_only = false;
  }
  // DO NOT CHANGE THE CODE BELOW.
  goog_report_conversion = function(url) {
    goog_snippet_vars();
    window.google_conversion_format = "3";
    var opt = new Object();
    opt.onload_callback = function() {
        if (typeof(url) != 'undefined') {
          window.location = url;
        }
    }
    var conv_handler = window['google_trackConversion'];
    if (typeof(conv_handler) == 'function') {
        conv_handler(opt);
    }
  }
  
    book_goog_snippet_vars = function() {
        var w = window;
        w.google_conversion_id = 882338006;
        w.google_conversion_label = "PMlxCJrj5mcQ1tHdpAM";
        w.google_remarketing_only = false;
    }
  // DO NOT CHANGE THE CODE BELOW.
  book_goog_report_conversion = function(url) {
    book_goog_snippet_vars();
    window.google_conversion_format = "3";
    var opt = new Object();
    opt.onload_callback = function() {
        if (typeof(url) != 'undefined') {
          window.location = url;
        }
    }
    var conv_handler = window['google_trackConversion'];
    if (typeof(conv_handler) == 'function') {
        conv_handler(opt);
      }
    }
    
/* ]]> */
</script>
<script type="text/javascript"
  src="//www.googleadservices.com/pagead/conversion_async.js">
</script>

<?php } ?>
</body>
</html>
