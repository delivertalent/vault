<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en" class="no-js"><!--<![endif]-->
  <!-- BEGIN HEAD -->
  <head>
  	<meta charset="utf-8" />
    <title>{{ $title }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta name="MobileOptimized" content="320">
	<!-- BEGIN GLOBAL MANDATORY STYLES -->          
	<link href="includes/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="includes/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="includes/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES --> 
	<link rel="stylesheet" type="text/css" href="includes/assets/plugins/select2/select2_metro.css" />
	<!-- END PAGE LEVEL SCRIPTS -->
	<!-- BEGIN THEME STYLES --> 
	<link href="includes/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
	<link href="includes/assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="includes/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="includes/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="includes/assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="includes/assets/css/pages/login.css" rel="stylesheet" type="text/css"/>
	<link href="includes/assets/css/custom.css" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
</head>

  </head>
  <!-- END HEAD -->
  <!-- BEGIN BODY -->
<body class="login">
	<!-- BEGIN LOGO -->
			<div class="logo">
				<img src="includes/img/template_logsmall.png" alt="Vault Logo" /> 
			</div>
	<!-- END LOGO -->
	<!-- BEGIN LOGIN -->
	<div class="content">
		<!-- BEGIN LOGIN FORM -->
		<form class="login-form" action="auth/login" method="post">
			<h3 class="form-title">Login to your account</h3>
			<!-- <h6>{{ Hash::make('123456')}}</h6> -->
			@if($errors->has())
				<div class="alert alert-danger display-hide" style="display: block;">
					<button class="close" data-dismiss="alert"></button>
					<span>
						<ul>
						  {{ $errors->first('userid', '<li>:message</li>') }}
						  {{ $errors->first('email', '<li>:message</li>') }}
						  {{ $errors->first('password', '<li>:message</li>') }}
						</ul>
					</span>
				</div>
		    @endif
		    
		    @if(Session::has('message'))
				<div class="alert alert-danger display-hide" style="display: block;">
					<button class="close" data-close="alert"></button>
					<span>
						<ul><li>{{ Session::get('message') }}</li></ul>
					</span>
				</div>
		    @endif
			
			<div class="alert alert-danger display-hide">
				<button class="close" data-close="alert"></button>
				<span>Enter any username and password.</span>
			</div>
			<div class="form-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">Username</label>
				<div class="input-icon">
					<i class="fa fa-user"></i>
					<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="email"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9">Password</label>
				<div class="input-icon">
					<i class="fa fa-lock"></i>
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
				</div>
			</div>
			<div class="form-actions">
				<label class="checkbox">
				<input type="checkbox" name="remember" value="1"/> Remember me
				</label>
				<button type="submit" class="btn green pull-right">
				Login <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
			<div class="forget-password">
				<h4>Forgot your password ?</h4>
				<p>
					No worries, click <a href="javascript:;"  id="forget-password">here</a>
					to reset your password.
				</p>
			</div>
		</form>
		<!-- END LOGIN FORM -->
		<!-- BEGIN FORGOT PASSWORD FORM -->
		<form class="forget-form" action="" method="post">
			<h3 >Forget Password ?</h3>
			<p>Enter your e-mail address below to reset your password.</p>
			
			<div class="form-group">
				<div class="alert alert-danger display-hide">
					<button class="close" data-close="alert"></button>
					You have some form errors. Please check below.
				</div>
				<div class="alert alert-success display-hide">
					<button class="close" data-close="alert"></button>
					Your form validation is successful!
				</div> 

				<div class="input-icon">
					<i class="fa fa-envelope"></i>
					<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" id="forgetEmail" name="email" />
				</div>
			</div>
			<div class="form-actions">
				<button type="button" id="back-btn" class="btn">
				<i class="m-icon-swapleft"></i> Back
				</button>

				<button id="forgetBtn" type="submit" class="btn green pull-right">
				Submit <i class="m-icon-swapright m-icon-white"></i>
				</button>  
				<img id="spinner" style="display:none;" class="pull-right" src="includes/assets/img/input-spinner.gif" alt="" />          
			</div>
		</form>
		<!-- END FORGOT PASSWORD FORM -->
		</div>
		<!-- END LOGIN -->


			<footer class="container">
				<!-- BEGIN COPYRIGHT -->
				<div class="copyright">
					{{ date('Y') }} &copy; Copyright superior designer services, Inc . All rights Reserved.
				</div>
				<!-- END COPYRIGHT -->
			</footer>


  		
		<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
		<!-- BEGIN CORE PLUGINS -->   
		<script src="includes/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
		<script src="includes/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
		<script src="includes/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="includes/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
		<script src="includes/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="includes/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
		<script src="includes/assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
		<script src="includes/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="includes/assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>	
		<script type="text/javascript" src="includes/assets/plugins/select2/select2.min.js"></script>     
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="includes/assets/scripts/app.js" type="text/javascript"></script>
		<script src="includes/assets/scripts/login.js" type="text/javascript"></script> 
		{{ HTML::script('includes/js/forgetPass.js') }}
		<!-- END PAGE LEVEL SCRIPTS --> 
		<script>
			jQuery(document).ready(function() {     
			  App.init();
			  Login.init();
			});
		</script>
		<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
