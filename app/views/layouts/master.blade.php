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
    {{ HTML::style('includes/assets/css/themes/default.css', array('id'=>'style_color')) }}
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
<body class="page-header-fixed page-sidebar-fixed">
	<!-- BEGIN HEADER -->   
	<div class="header navbar navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="header-inner">
			<!-- BEGIN LOGO -->  
			<a class="navbar-brand" href="{{ URL::to('/admin/dashboard')  }}">
			<img src="{{ URL::asset('includes/assets/img/template_logsmall.png')}}" alt="logo" class="img-responsive" />
			</a>
			<!-- END LOGO -->
			<!-- BEGIN RESPONSIVE MENU TOGGLER --> 
			<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				
			<img src="{{ URL::asset('includes/assets/img/menu-toggler.png')}}" alt="" />
			</a> 
			<!-- END RESPONSIVE MENU TOGGLER -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<ul class="nav navbar-nav pull-right">

				<!-- BEGIN USER LOGIN DROPDOWN -->
				<li class="dropdown user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<!-- <img alt="" src="assets/img/avatar1_small.jpg"/> -->
					<span class="username">Logged in as : {{Session::get('sessionEmail') }}</span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<!-- <li><a href="extra_profile.html"><i class="fa fa-user"></i>My Profile</a></li> -->
						<li class="divider"></li>
						<li><a href="javascript:;" id="trigger_fullscreen"><i class="fa fa-move"></i> Full Screen</a></li>
						<!-- <li><a href="extra_lock.html"><i class="fa fa-lock"></i> Lock Screen</a></li> -->
						<li><a href="{{ URL::to('/logout')  }}"><i class="fa fa-key"></i> Log Out</a></li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
			</ul>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<div class="clearfix"></div>
	<!-- BEGIN CONTAINER -->   
	<div class="page-container">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        
			<ul class="page-sidebar-menu">
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li class="start @if($menu=='Dashboard'){{'active'}} @endif">
					<a href="{{ URL::to('/admin/dashboard')  }}">
					<i class="fa fa-home"></i> 
					<span class="title">Dashboard</span>
					<span class="selected"></span>
					</a>
				</li>

				<li class="@if($menu=='Designer'){{'active'}} @endif">
					<a href="{{ URL::to('/admin/designer')  }}">
					<i class="fa fa-group"></i> 
					<span class="title">Clients</span>
					<span class="selected"></span>
					</a>
				</li>


				<li class="@if($menu=='warManager'){{'active'}} @endif">
					<a href="{{ URL::to('/admin/warehouse-manager')  }}">
					<i class="fa fa-group"></i> 
					<span class="title">Warehouse Manager</span>
					<span class="selected"></span>
					</a>
				</li>


				<li class="@if($menu=='Jobs'){{'active'}} @endif">
					<a href="{{ URL::to('/admin/admin-jobs')  }}">
					<i class="fa fa-briefcase"></i> 
					<span class="title">Jobs</span>
					<span class="selected"></span>
					</a>
				</li>

				<li class="@if($menu=='inventorylist'){{'active'}} @endif">
					<a href="{{ URL::to('/admin/inventories')  }}">
					<i class="fa fa-puzzle-piece"></i> 
					<span class="title">Inventory</span>
					<span class="selected"></span>
					</a>
				</li>
				
				<li class="@if($menu=='workorders'){{'active'}} @endif">
					<a href="{{ URL::to('/admin/admin-workorders')  }}">
					<i class="fa fa-truck"></i> 
					<span class="title">Work Orders</span>
					<span class="selected"></span>
					</a>
				</li>

				<li class="@if($menu=='closedWorkorders'){{'active'}} @endif">
					<a href="{{ URL::to('/admin/admin-closed-workorders')  }}">
					<i class="fa fa-power-off"></i> 
					<span class="title">Closed Work Orders</span>
					<span class="selected"></span>
					</a>
				</li>

				<li class="@if($menu=='Storage'){{'active'}} @endif">
					<a href="{{ URL::to('/admin/storage')  }}">
					<i class="fa fa-archive"></i> 
					<span class="title">Storage</span>
					<span class="selected"></span>
					</a>
				</li>
				
				<li class="@if($menu=='Configuration'){{'active'}} @endif">
					<a href="javascript:;">
					<i class="fa fa-cogs"></i> 
					<span class="title">Configuration</span>
					<span class="selected"></span>
					<span class="arrow open"></span>
					</a>
					<ul class="sub-menu">
						<li class="@if($submenu=='advertise'){{'active'}} @endif">
							<a href="{{ URL::to('/admin/advertise')  }}">Advertise</a>
						</li>
						<li class="@if($submenu=='manufacturer'){{'active'}} @endif">
							<a href="{{ URL::to('/admin/manufacturers')  }}">Manufacturer</a>
						</li>
						<li class="@if($submenu=='carrier'){{'active'}} @endif">
							<a href="{{ URL::to('/admin/carriers')  }}">Carrier</a>
						</li>
						<li class="@if($submenu=='inventorycategory'){{'active'}} @endif">
							<a href="{{ URL::to('/admin/inventorycategory')  }}">Inventory Category</a>
						</li>	

						<li class="@if($submenu=='itemdescription'){{'active'}} @endif">
							<a href="{{ URL::to('/admin/itemdescription')  }}">Item Descriptions</a>
						</li>	

						<li class="@if($submenu=='room'){{'active'}} @endif">
							<a href="{{ URL::to('/admin/room')  }}">Rooms</a>
						</li>	
						
						<li class="@if($submenu=='StoragePrice'){{'active'}} @endif">
						  	<a href="{{ URL::to('/admin/storage-price')  }}">Storage Price </a>
						  </li>

						<li class="@if($submenu=='warehouses'){{'active'}} @endif">
							<a href="{{ URL::to('/admin/warehouses')  }}">Warehouses</a>
						</li>
						<li class="@if($submenu=='bins'){{'active'}} @endif">
							<a href="{{ URL::to('/admin/bins')  }}">Bin</a>
						</li>

						<li class="@if($submenu=='binlrts'){{'active'}} @endif">
							<a href="{{ URL::to('/admin/binlrts')  }}">Bin Ltr</a>
						</li>
						<!-- <li >
							<a href="layout_idle_timeout.html">
							<span class="badge badge-roundless badge-important">new</span>User Idle Timeout</a>
						</li>
						<li class="active">
							<a href="layout_blank_page.html">
							Blank Page</a>
						</li>
						<li >
							<a href="layout_boxed_page.html">
							Boxed Page</a>
						</li>
						<li >
							<a href="layout_boxed_not_responsive.html">
							Non-Responsive Boxed Layout</a>
						</li> -->
					</ul>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
		<!-- END SIDEBAR -->
	<div class="clearfix"></div>
	<!-- END HEADER -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
		@yield('content')
		</div>

		</div>
		<!-- END PAGE -->    
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		<div class="footer-inner">
			&copy; Copyright {{ date('Y')}} superior designer services, Inc . All rights Reserved.
		</div>
		<div class="footer-tools">
			<span class="go-top">
			<i class="fa fa-angle-up"></i>
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
