<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
  <!-- BEGIN HEAD -->
  <head>
  	<meta charset="utf-8" />
    <title>{{ $title }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   	<meta content="emr project" name="description" />
   	<meta content="nesar uddin" name="author" />
    <meta name="MobileOptimized" content="320">
	
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{ HTML::style('includes/assets/plugins/bootstrap/css/bootstrap.min.css') }}
    {{ HTML::style('includes/assets/css/style-responsive.css', array('media'=>'screen')) }}
    {{ HTML::style('includes/assets/plugins/font-awesome/css/font-awesome.min.css') }}
    {{ HTML::style('includes/assets/css/style-metronic.css') }}
    {{ HTML::style('includes/assets/css/style.css') }}
    {{ HTML::style('includes/assets/css/style-responsive.css') }}
    {{ HTML::style('includes/assets/css/themes/grey.css', array('id'=>'style_color')) }}
    {{ HTML::style('includes/assets/plugins/uniform/css/uniform.default.css') }}
    {{ HTML::style('includes/assets/plugins/bootstrap-datepicker/css/datepicker.css') }}

    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
    
    
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->
	{{ HTML::script('includes/assets/plugins/jquery-1.10.2.min.js') }}
	{{ HTML::script('includes/assets/plugins/jquery-migrate-1.2.1.min.js') }}   
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->

	<!-- END JAVASCRIPTS -->
  </head>
  <!-- END HEAD -->
  <!-- BEGIN BODY -->
  <body class="page-full-width page-boxed page-header-fixed page-footer-fixed">
  	<!-- BEGIN HEADER -->   
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="header-inner">
				<!-- BEGIN LOGO -->
				<a class="navbar-brand" href="">
					<!--<img src="includes/img/traumalink.gif" alt="logo" class="img-responsive" />-->
					<img src="{{ URL::asset('includes/img/traumalink.gif')}}" alt="logo" class="img-responsive" />
					
				</a>
				
				<!-- END LOGO -->
				
				<!-- BEGIN HORIZANTAL MENU -->
				<div class="hor-menu hidden-sm hidden-xs">
						<ul class="nav navbar-nav">
							<li>{{ HTML::link('/', 'Home') }}</li>
							@if(Auth::check())
							<li>{{ HTML::link('/reports', 'Reports') }}</li>
							<li>{{ HTML::link('/hospital', 'Hospital') }}</li>
							<li>
								<a data-toggle="dropdown" data-hover="dropdown" data-close-others="true" class="dropdown-toggle" href="javascript:;">
									Location
									<i class="fa fa-angle-down"></i>     
								</a>
								<ul class="dropdown-menu">
									<li >{{ HTML::link('/zone', 'Manage Zone') }}</li>
									<li >{{ HTML::link('/landmark', 'Manage Landmark') }}</li>
								</ul>
							</li>
							<li>{{ HTML::link('/responder', 'Responder') }}</li>				
							<li>
								<a data-toggle="dropdown" data-hover="dropdown" data-close-others="true" class="dropdown-toggle" href="javascript:;">
									Admin
									<i class="fa fa-angle-down"></i>     
								</a>
								<ul class="dropdown-menu">
									<li >{{ HTML::link('/getUser', 'User Manage') }}</li>
								</ul>
							</li>										
				           	@else
				           	@endif
						</ul>
				</div>
				<!-- END HORIZANTAL MENU -->
				
				
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
				{{ HTML::image('includes/assets/img/menu-toggler.png', '') }}
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->            
				<!-- BEGIN TOP NAVIGATION MENU -->              
				<ul class="nav navbar-nav pull-right">              
					<!-- BEGIN USER LOGIN DROPDOWN -->
					@if(Auth::check())
						<li class="dropdown user">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							<!--<img alt="" src="assets/img/avatar1_small.jpg"/>-->
							<span class="username">Login as : {{Session::get('userid') }}</span>
							<i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu">
								
								<li><a href="{{ URL::to('/logout')  }}"><i class="fa fa-key"></i> Log Out</a></li>
							</ul>
						</li>
    				@else
						<li>{{ HTML::link('/login', 'login') }}</li>
    				@endif
					<!-- END USER LOGIN DROPDOWN -->
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU --> 
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<div class="clearfix"></div>
	<!-- END HEADER -->
  	<!-- BEGIN CONTAINER -->   
	<div class="page-container">
		@yield('content')
	</div>

    <!-- BEGIN FOOTER -->
	<div class="footer">
		<div class="footer-inner">
			&copy; Copyright 2014 superior designer services, Inc . All rights Reserved.
		</div>
		<div class="footer-tools">
			<span class="go-top">
			<i class="icon-angle-up"></i>
			</span>
		</div>
	</div>
	<!-- END FOOTER -->


	{{ HTML::script('includes/assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}
	{{ HTML::script('includes/assets/plugins/bootstrap/js/bootstrap.min.js') }}
	{{ HTML::script('includes/assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js') }}
	<!--[if lt IE 9]>
	{{ HTML::script('includes/assets/plugins/excanvas.min.js') }}
	{{ HTML::script('includes/assets/plugins/respond.min.js') }}
	<![endif]--> 
	{{ HTML::script('includes/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}
	{{ HTML::script('includes/assets/plugins/jquery.blockui.min.js') }}
	{{ HTML::script('includes/assets/plugins/jquery.cookie.min.js') }}
	{{ HTML::script('includes/assets/plugins/uniform/jquery.uniform.min.js') }}  
	
	{{ HTML::script('includes/assets/plugins/bootbox/bootbox.min.js') }}
	<!-- END CORE PLUGINS -->
	{{ HTML::script('includes/assets/scripts/app.js') }}   

   {{ HTML::script('includes/assets/plugins/jquery-validation/dist/jquery.validate.min.js') }}
   {{ HTML::script('includes/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}
   {{ HTML::script('includes/assets/scripts/form-components.js') }}	       
	<script>
		jQuery(document).ready(function() {    
		   App.init();
		   FormComponents.init();
		});
	</script>

  </body>
</html>
