@extends('layouts.master')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
						Dashboard
					</h3>
					<ul class="page-breadcrumb breadcrumb">

						<li>
							<i class="fa fa-home"></i>
							<a href="index.html">Dashboard</a> 
							<i class="fa fa-angle-right"></i>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
							<div  class="row">
									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a class="dlinkClass" href="{{ URL::to('/admin/admin-workorders')  }}">
										<div id="designerWork" class="">
											
											<div class="details">
												<div class="number workOrderNumber">{{$newworkorders}} </div>
											</div>

										</div>
										</a>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a class="dlinkClass" href="{{ URL::to('/admin/damaged-inventories')  }}">
										<div id="designerBroken" class="">
											
											<div class="details designerInventory">
												<div class="number">{{$damaged}}</div>
											</div>
											
										</div>
										</a>
									</div>


									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a class="dlinkClass" href="{{ URL::to('/admin/storage')  }}">
										<div id="adminPrice" class="">
											
											<div class="details speedPrice">
												<div class="number">${{number_format($totalPrice, 2, '.', '')}}</div>
												
											</div>
											
										</div>
										</a>
									</div>


							</div>				
			<!-- END PAGE CONTENT-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div id="topFlug" class="caption"><i class="fa fa-globe"></i>Work Orders</div>
							<div class="actions">
								<!--<button type="button" id="btnAddUser" class="btn blue"><i class="fa fa-plus"></i> Add New</button>
								<a class="btn default" data-toggle="modal" href="#responsive">View Demo</a>-->
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
									<tr>
										<th>ID</th>
										<th>Client Name</th>
										<th>Job Name</th>
										<th>Delivery Date</th>
										<th>Delivery Time</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($workorders as $workorder)

									<tr class="odd gradeX">
										<td><a href="javascript:void(0)"><b>{{ $workorder->id }}</b></a></td>
										<td>{{ $workorder->firm_name }}</td>
										<td>{{ $workorder->job_name }}</td>
										<td>{{ $workorder->wo_delivery_date }}</td>
										<td>{{ $workorder->wo_delivery_time }}</td>
										<td>@if($workorder->wo_status==1) {{"NEW"}} @elseif($workorder->wo_status==2){{"PENDING"}} @elseif($workorder->wo_status==3){{"PULLED"}} @elseif($workorder->wo_status==4) {{"DELIVERED"}} @elseif($workorder->wo_status==5) {{"CLOSED"}} @else {{''}} @endif</td>
										<td>
											<!-- <a href ='javaScript:void(0)'  class="btn mini blue" alt="Edit"><i class="fa fa-edit"></i></a> -->
											<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_{{$workorder->id}}" href="{{ URL::to('/admin/admin-workorder-details/'.$workorder->id)  }}"><i class="fa fa-pencil"></i>View</a>
										</td>
									</tr>		
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->			
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/Home.js') }}
	<script>
		//jQuery(document).ready(function() {       
		  // TableManaged.init();
		//});
	</script>		
@stop