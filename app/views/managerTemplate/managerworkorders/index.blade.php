@extends('layouts.manager')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
{{ HTML::style('includes/assets/plugins/bootstrap-timepicker/compiled/timepicker.css') }}
{{ HTML::style('includes/assets/plugins/bootstrap-colorpicker/css/colorpicker.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Work Orders</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/manager/manager-dashboard', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="javaScript:void(0);">Work Orders</a>
							<i class="fa fa-angle-right"></i>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div id="jobTop" class="row">
				<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div id="topFlug" class="caption"><i class="fa fa-globe"></i>Work Order List</div>
							<div class="actions">
								<!--<a class="btn default" data-toggle="modal" href="#responsive">View Demo</a>-->
							</div>
						</div>
						<div class="portlet-body">
							<!--<div class="table-toolbar">
								<div class="btn-group">
									<button id="sample_editable_1_new" class="btn green">
									Add New <i class="fa fa-plus"></i>
									</button>
								</div>
							</div>-->
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
										<td><a href="{{ URL::to('/manager/manager-workorder-details/'.$workorder->id)  }}"><b>{{ $workorder->id }}</b></a></td>
										<td>{{ $workorder->firm_name }}</td>
										<td>{{ $workorder->job_name }}</td>
										<td>{{ $workorder->wo_delivery_date }}</td>
										<td>{{ $workorder->wo_delivery_time }}</td>
										<td>@if($workorder->wo_status==1) {{"NEW"}} @elseif($workorder->wo_status==2){{"PENDING"}} @elseif($workorder->wo_status==3){{"PULLED"}} @elseif($workorder->wo_status==4) {{"DELIVERED"}} @elseif($workorder->wo_status==5) {{"CLOSED"}} @else {{''}} @endif</td>
										<td>
											<!-- <a href ='javaScript:void(0)'  class="btn mini blue" alt="Edit"><i class="fa fa-edit"></i></a> -->
											<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_{{$workorder->id}}" href="{{ URL::to('/manager/manager-workorder-details/'.$workorder->id)  }}"><i class="fa fa-pencil"></i> View</a>
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
{{ HTML::script('includes/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}  
{{ HTML::script('includes/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js') }}


{{ HTML::script('includes/js/adminjs/AdminWorkorder.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		   handleTimePickers();
		});
	</script>			
@stop