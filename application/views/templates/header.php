<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url('favicon.ico');?>" type="image/x-icon" />
    <title><?php echo (!empty($seo_title))?$seo_title:DEFAULT_SEO_TITLE;?></title>
    <meta name="description" content="<?php echo (!empty($seo_desc))?$seo_desc:'';?>"/>
    <meta name="Keywords" content="Car Rental Services Mumbai, Cab Services in Mumbai, Mumbai to Pune Cab Services, Mumbai to Shirdi Taxi, Mumbai Pune Taxi Fare"/>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css?ver=' . CACHE_VERSION); ?>" rel="stylesheet" media="screen">
    <link href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css?ver=' . CACHE_VERSION);?>" rel="stylesheet" media="screen">           
    <link href="<?php echo base_url('assets/css/custom.css?ver=' . CACHE_VERSION);?>" rel="stylesheet" media="screen">  
    <?php if(isset($css_files) && is_array($css_files)) { ?>
    		<?php foreach($css_files as $key => $val) {
    				if(!empty($val)) {?>
    			<link href="<?php echo base_url('assets/css/'.$val.'.css?ver=' . CACHE_VERSION);?>" rel="stylesheet" media="screen">
    		<?php 		}
    				} ?>
    <?php } ?> 
    
    <script type="text/javascript">
    	var siteUrl = '<?php echo site_url(); ?>';
    </script> 
    <?php 
    	$user = isLogin();
    	$grp_id = 0;
    	if(is_object($user) && !empty($user->id)) {
    		$grp_id = getGroup($user->id);
    	}
    	if($grp_id != 1 && ENVIRONMENT != 'development') { ?>
    <script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75485150-1', 'auto');
  ga('send', 'pageview');

</script>

  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Service",
      "serviceType": "Car and Cab Rental Services Mumbai,Pune,Shirdi,Khandala,Aligaug,Imagica,Kolad,Mahabaleshwar",
      "provider": {
      "@type": "LocalBusiness",
      "name": "Pin A Ride",
      "address":{
      "@type": "PostalAddress",
      "streetAddress": "NL-5, BLD-25, ROOM-11,",
      "addressRegion": "Near Shani Mandir, Nerul-E, Navi Mumbai ",
      "addressLocality": "Maharastra",
      "postalCode": "400706",
      "description" : "If you want online enquiry about Car and Cab Rental Services Mumbai to Pune,Mumbai to Shirdi Taxi, Mumbai Pune Taxi Fare,then Pin A Ride is one stop Solution.Are You looking for Car and Cab Rental Services in Mumbai? Pin A Ride is one the best taxi services provider in Mumbai, Shirdi, Pune and more.Get Pune Cab Services, Mumbai Pune Taxi Fare Pin A Ride Respects your privacy and recognizes the need to protect the personally identifiable information. If you have question from where to take Car and Cab Rental Services for Mumbai, Pune, Shirdi, then Pin A Ride give you best service in Maharashtra, India.",
      "url": "http://www.pinaride.com" ,
      "email" : "support@pinaride.com",
      "telephone" : "+91-96999-30-594" }
    }
}
    </script>
    <?php } ?>
  </head>
  <body>
   	<div id="headerWrap">
		<div id="header">
			<div id="siteLogo">	
				<div class="logowrap"><img src="<?php echo base_url('assets/images/logo1.png');?>" /></div>					
				<a style="text-decoration: underline;" href="<?php echo base_url();?>">
					Pin A Ride
				</a><div class="clear"></div>
				<span class="logoText">Car on rental</span>
			</div>
			<div id="headerRightSectioBox">
			<a href="javascript:void(0)" id="callus" class="callus-b"><img src="<?php echo base_url('assets/images/call-us1.png');?>" /></a>
			<div id="helplineBox" class="callus">
				<div class="helplineTitle">Call Us</div>
				<div class="helplineNumber"><?php echo CALL_US;?></div>
			</div>
			<button id="menu-btn" class="userinfo menu">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<div id="userinfo-wrap" class="userinfo-wrap headerLinks">	
				<?php
					$history = 'history';
					$enquiry = 'enquiry';
					if($grp_id == 1) {
						$history = 'admin/booking/index';
						$enquiry = 'admin/enquire/index';
					}
				?>			
				<?php if(is_object($user) && !empty($user->first_name)) { ?>				
				<span role="presentation" class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="javascript: void(0);" role="button" aria-haspopup="true" aria-expanded="false">
				      <?php echo $user->first_name;?> <span class="caret"></span>
				    </a>
				    &nbsp;&nbsp;  |  &nbsp;&nbsp;
				    <ul class="dropdown-menu">
				    	<?php if($grp_id ==1 ){?>
				    		<li><a href="<?php echo base_url('admin/auth');?>">Users</a></li>
				    		<li><a href="#">Coupons</a></li>
				    		<li><a href="#">Rides</a></li>
				    	<?php }else{ ?>				    	
				    	<li><a href="#">Profile</a></li>
				    	<?php } ?>
				    	<li role="separator" class="divider"></li>
				    	<li><a href="<?php echo site_url('user/logout'); ?>">Logout</a></li>
				    </ul>
				    
				</span>								
				<a href="<?php echo base_url($history);?>" >History </a> &nbsp;&nbsp;|  &nbsp;&nbsp;	
				<?php } else {?>
					<a href="javascript: void(0);" data-toggle="modal" data-target="#signinModal">Sign In</a>&nbsp;&nbsp;  |  &nbsp;&nbsp;
					<a href="javascript: void(0);" data-toggle="modal" data-target="#registerModal">Register</a> &nbsp;&nbsp;|  &nbsp;&nbsp;
				<?php } ?>
				<?php if($grp_id == 1) { ?>
					<a href="<?php echo base_url('admin/feedback/index');?>">Feedback</a>&nbsp;&nbsp;   | &nbsp;&nbsp;
				<?php }else{ ?>
					<a href="<?php echo base_url('cancellation');?>">Cancellation</a>&nbsp;&nbsp;   | &nbsp;&nbsp;
				<?php } ?>  
				<a href="<?php echo base_url($enquiry);?>">Enquiry&nbsp;&nbsp;</a>				
    
				</div>
				
			</div>
		 
		</div>
	</div>
   
    <div id="section" class="container">  
		<br/>
         <div class="row">