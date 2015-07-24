@extends('layouts.master')
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
							{{ HTML::link('/admin/dashboard', 'Dashboard') }} 
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
							<div id="topFlug" class="caption"><i class="fa fa-globe"></i>Manage Work Orders</div>
							<div class="actions">
								<button type="button" id="btnAddUser" class="btn blue"><i class="fa fa-plus"></i> Add New</button>
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
										<td><a href="javascript:void(0)"><b>{{ $workorder->id }}</b></a></td>
										<td>{{ $workorder->firm_name }}</td>
										<td>{{ $workorder->job_name }}</td>
										<td>{{ $workorder->wo_delivery_date }}</td>
										<td>{{ $workorder->wo_delivery_time }}</td>
										<td>@if($workorder->wo_status==1) {{"NEW"}} @elseif($workorder->wo_status==2){{"PENDING"}} @elseif($workorder->wo_status==3){{"PULLED"}} @elseif($workorder->wo_status==4) {{"DELIVERED"}} @elseif($workorder->wo_status==5) {{"CLOSED"}} @else {{''}} @endif</td>
										<td>
											<!-- <a href ='javaScript:void(0)'  class="btn mini blue" alt="Edit"><i class="fa fa-edit"></i></a> -->
											<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_{{$workorder->id}}" href="{{ URL::to('/admin/admin-workorder-details/'.$workorder->id)  }}"><i class="fa fa-pencil"></i>Edit</a>
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

		

			<div id="jobform" style="display:none;" class="row">
				<div class="col-md-12">

					<div class="portlet box blue">
						<div class="portlet-title">
							<div id="modatTitle" class="caption"><i class="fa fa-reorder"></i>Add New Job.</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->
						<!-- <form action="#" class="horizontal-form"> -->
						<form action="#" id="form_sample_2" class="horizontal-form">

									<div class="form-body">
									<div class="alert alert-danger display-hide">
										<button class="close" data-close="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success display-hide">
										<button class="close" data-close="alert"></button>
										Your form validation is successful!
									</div> 
										<div class="row">

											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="wo_firmid">Client Name <span class="required">*</span></label>
													<select class="form-control " id="wo_firmid"  name="wo_firmid">
														<option value="">Select Client</option>	
														@if($designers)
														@foreach($designers as $designer)
															<option value="{{$designer->id}}">{{$designer->firm_name}} </option>
														@endforeach
														@endif	
													</select>												
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="job_name">Job Name <span class="required">*</span></label>
													<select class="form-control filterInv" id="job_name"  name="job_name">
														<option value="">Select Job Name</option>		
													</select>												
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_delivery_status">Category</label>
													<select class="form-control filterInv" id="inv_category"  name="inv_category">
														<option value="">Select Category</option>
														@if($inventorycategories)
														@foreach($inventorycategories as $inventorycategory)
															<option value="{{$inventorycategory->id}}">{{$inventorycategory->invcat_name}}</option>
														@endforeach
														@endif
													</select>													
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_delivery_status">Area</label>
													<select  class="form-control filterInv" id="inv_room"  name="inv_room">
														<option value="">Select Area  </option>
														@if($rooms)
															@foreach($rooms as $room)
																<option value="{{$room->id}}">{{$room->room_name}}</option>
															@endforeach
														@endif
													</select>													
												</div>
											</div>	

											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_delivery_status">Status</label>
													<select  data-filter="true" class="form-control input-medium filterInv" id="inv_item_status"  name="inv_item_status">
															<option value="">Select Status</option>
															<option value="1">Received in good condition</option>
															<option value="2">Damaged</option>
															<option value="3">Being repaired – in house</option>
															<option value="4">Being repaired – out for repair</option>
															<option value="5">Awaiting call tag / awaiting pickup</option>
															<option value="6">Picked up</option>
													</select>													
												</div>
											</div>											
										</div>	

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="wo_delivery_date" class="control-label">Delivery Date </label>
													<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
														<input type="text" id="wo_delivery_date" name="wo_delivery_date" value="" class="form-control" style="width:100%" readonly>
														<span class="input-group-btn">
														<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
														</span>
													</div>                          
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="wo_delivery_time">Delivery Time</label>
													<div class="input-group input-medium bootstrap-timepicker">                                       
														<input type="text" id="wo_delivery_time" name="wo_delivery_time"  value="" class="form-control timepicker-24" style="width:100%" readonly>
														<span class="input-group-btn">
														<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
														</span>
													</div>
												</div>
											</div>
											
										</div>	
										<input type="hidden" name="curDate" id="curDate" value="{{date("Y-m-d")}}">
										<input type="hidden" name="curTime" id="curTime" value="{{ date("H:i")}}">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">	
													<label class="control-label" for="notes">Note</label>
													<textarea id="notes"  name="notes" data-provide="markdown" rows="2" class="form-control"></textarea>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">	
													<label class="control-label" for="wo_requests">Other Requests </label>
													<textarea id="wo_requests"  name="wo_requests" data-provide="markdown" rows="2" class="form-control"></textarea>
												</div>
											</div>

										</div>

										<div class="row">
											<div id="invLIST" class="col-md-12">
	
											</div>
										</div>
										<div style="clear:both"></div>
										<input type="hidden" name="id" id="did" value="">									
										<input type="hidden" name="rowPos" id="rowPos" value="">									
									</div>
									<div class="form-actions right">
										<button type="button" id="jobCancel" class="btn default">Cancel</button>
										<button type="submit" id="btnSave" class="btn blue"><i class="fa fa-check"></i> Save</button>
									</div>
								</from>
						</div>
							
						</div>
						</div>
						</div>











	
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