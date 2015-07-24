@extends('layouts.manager')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
{{ HTML::style('uploadify/uploadify.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Manager Dashboard</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('manager/manager-dashboard', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<!-- BEGIN PAGE CONTENT-->
							<div  class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<a href="{{ URL::to('/manager/manager-workorders')  }}">
										<div class="dashboard-stat blue">
											<div class="visual">
												<i class="fa fa-truck"></i>
												</div>
												<div class="details">
												<div class="number">{{$newworkorders}} </div>
												<div class="desc">  Pending / Pulled Work Orders </div>
											</div>
											<span class="more">
												View more<i class="m-icon-swapright m-icon-white"></i>
											</span>
										</div>
										</a>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<a href="{{ URL::to('/manager/manager-damaged-inventories')  }}">
										<div class="dashboard-stat green">
											<div class="visual">
												<i class="fa fa-chain-broken"></i>
											</div>
											<div class="details">
												<div class="number">{{$damaged}}</div>
												<div class="desc"> Damaged / Being Repaired Inventory </div>
											</div>
											<span class="more">
												View more<i class="m-icon-swapright m-icon-white"></i>
											</span>
										</div>
										</a>
									</div>
							</div>				
			<!-- END PAGE CONTENT-->

						<!-- END DASHBOARD BOXES-->

{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/Home.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop