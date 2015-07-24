@extends('layouts.designer')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Customer Details</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							{{ HTML::link('/customers', 'Customer') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="javaScript:void(0);">Customer Details</a>
							<i class="fa fa-angle-right"></i>
						</li>						
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
								<div class="portlet box green">
									<div class="portlet-title">
										<div class="caption"><i class="fa fa-reorder"></i>Customer: {{$thiscustomers->customer_last_name}}</div>
										<div class="tools">
											<a href="javascript:;" class="collapse"></a>
											<a href="#portlet-config" data-toggle="modal" class="config"></a>
											<a href="javascript:;" class="reload"></a>
											<a href="javascript:;" class="remove"></a>
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form class="form-horizontal" role="form">
											<div class="form-body">
												<h3 class="form-section">Customer Info:</h3>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Name:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$thiscustomers->customer_first_name.' '.$thiscustomers->customer_last_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Primary Address 1:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$thiscustomers->customer_primary}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Email:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$thiscustomers->customer_email}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Primary Address 2:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$thiscustomers->customer_address2}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->        
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Phone:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$thiscustomers->customer_phone}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">City:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$thiscustomers->customer_city}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">State:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$thiscustomers->state_full}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Zip:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$thiscustomers->customer_zip}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>

												<!--/row-->                      
												
											</div>
										
										</form>
										<!-- END FORM-->  
									</div>
								</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->


			<!-- BEGIN PAGE CONTENT-->
			<div id="jobTop" class="row">
				<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box blue">
						<div class="portlet-title">
							<div id="topFlug" class="caption"><i class="fa fa-globe"></i>{{$thiscustomers->customer_last_name}} Job List:</div>
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
										<th>Job ID</th>
										<th>Job Name</th>
										<th>Customer Last Name</th>
										<th>Lead Designer Name</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($jobs as $job)

									<tr class="odd gradeX">
										<td><a href="{{ URL::to('/job-details/'.$job->id .'/'.$job->job_client_id)  }}"><b>{{ $job->id }}</b></a></td>
										<td>{{ $job->job_name }}</td>
										<td>{{ $job->customer_last_name }}</td>
										<td>{{ $job->designer_name }}</td>
										<td>@if($job->job_status==1) {{"New"}} @elseif($job->job_status==2){{"In Progress"}} @elseif($job->job_status==3) {{"Closed"}} @else {{''}} @endif</td>
										<td>
											<!-- <a href ='javaScript:void(0)'  class="btn mini blue" alt="Edit"><i class="fa fa-edit"></i></a> -->
											<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_{{$job->id}}" href="javaScript:void(0);"><i class="fa fa-pencil"></i>Edit</a>
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
											<div class="col-md-8">
												<div class="form-group">
													<label class="control-label" for="job_name">Job Name <span class="required">*</span></label>
													<input id="job_name" data-required="1"  name="job_name" class="form-control" type="text" placeholder="Job Name">												
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="job_status">Status</label>
													<select  data-filter="true" class="form-control input-medium" id="job_status"  name="job_status">
															<option value="">Select Status</option>
															<option value="1">New</option>
															<option value="2">In Progress</option>
															<option value="3">Closed</option>
													</select>													
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="job_customer_id">Customer Name</label>
													<select class="form-control " id="job_customer_id"  name="job_customer_id">
														<option value="">Select Customer Name</option>		
														@if($customers)
														@foreach($customers as $customer)
															<option value="{{$customer->id}}">{{$customer->customer_first_name.' '.$customer->customer_last_name}} </option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
											
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="job_designer_id">Lead Designer Name <span class="required">*</span></label>
													<select class="form-control" id="job_designer_id"  name="job_designer_id">
														<option value="">Select Designer Name</option>
														@if($adiDesigners)
														@foreach($adiDesigners as $adiDesigner)
															<option value="{{$adiDesigner->id}}">{{$adiDesigner->designer_name}}</option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="col-md-4">
											<div class="form-group">
												<label for="job_install_date" class="control-label">Est. Install Date </label>
												<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
													<input type="text" id="job_install_date" name="job_install_date" class="form-control" style="width:100%" readonly>
													<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
													</span>
												</div>                          
											</div>
										</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">	
													<label class="control-label" for="job_address1">Address 1<span class="required">*</span></label>
													<textarea id="job_address1"  name="job_address1" data-provide="markdown" rows="2" class="form-control"></textarea>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="job_address2">Address 2</label>
													<textarea id="job_address2"  name="job_address2" data-provide="markdown" rows="2" class="form-control"></textarea>
												</div>										
											</div>										
										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="job_city" class="control-label">City<span class="required">*</span></label>
													<input id="job_city" data-required="1"  name="job_city" class="form-control" type="text" placeholder="City">
												</div>	
											</div>	
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="job_state_id">State<span class="required">*</span></label>
													<select  class="form-control input-medium" id="job_state_id"  name="job_state_id">
														<option value="">Select State</option>
														@if($states)
														@foreach($states as $state)
															<option value="{{$state->state_code}}">{{$state->state_full}}</option>
														@endforeach
														@endif
													</select>
												</div>												
											</div>	

											<div class="col-md-4">
												<div class="form-group">	
													<label class="control-label" for="job_zip">Zip Code<span class="required">*</span></label>
													<input id="job_zip" name="job_zip" data-required="1" class="form-control input-small" type="text" placeholder="Zip Code">
												</div>
											</div>

										</div>	
										<div style="clear:both"></div>


										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="job_development_name" class="control-label">Development Name <span class="required">*</span></label>
													<input id="job_development_name" name="job_development_name" data-required="1" class="form-control" type="text" placeholder="Enter Development Name">                        
												</div>
											</div>
										</div>

										<div id="row">
											<div class="col-md-4">
												<div class="checkbox-list">
													<label class="control-label" ><input id="job_gated" class="checkboxClass" name="job_gated" type="checkbox"> Gated</label>
													<label class="control-label" ><input id="job_alarm" class="checkboxClass" name="job_alarm" type="checkbox"> Alarm</label>
													<label class="control-label" ><input id="job_condo" class="checkboxClass" name="job_condo" type="checkbox"> Condo</label>
												</div>
											</div>

									
											<div class="col-md-4">
												<div class="checkbox-list">
													<label class="control-label" ><input id="job_stairs" class="checkboxClass" name="job_stairs" type="checkbox"> Stairs</label>
													<label class="control-label" ><input id="job_elevator" class="checkboxClass" name="job_elevator" type="checkbox"> Elevator</label>
												</div>
											</div>	

											<div class="col-md-4">
												<div class="form-group">	
													<label class="control-label" for="job_house_sqft">House Sq. Ft<span class="required">*</span></label>
													<input id="job_house_sqft" name="job_house_sqft" data-required="1" class="form-control" type="text" placeholder="Enter House Sq. Ft">
												</div>
											</div>

										</div>					
										<div style="clear:both"></div>
										
										<div id="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="job_comments">Comments</label>
													<textarea id="job_comments"  name="job_comments" data-provide="markdown" rows="3" class="form-control"></textarea>
												</div>										
											</div>	
										</div>
										<div style="clear:both"></div>
										<input type="hidden" name="id" id="did" value="">									
										<input type="hidden" name="rowPos" id="rowPos" value="">									
										<input type="hidden" name="job_client_id" id="job_client_id" value="{{$thiscustomers->customer_firm_id}}">									
									</div>
									<div class="form-actions right">
										<button id="jobCancel" type="button" class="btn default">Cancel</button>
										<button type="submit" id="btnSave" class="btn blue"><i class="fa fa-check"></i> Save</button>
									</div>
								</from>
						</div>
							
						</div>
						</div>
						</div>
	
		<!-- /.modal -->
	
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/Customerdetails.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop