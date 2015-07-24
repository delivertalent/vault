@extends('layouts.master')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Clients</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/admin/dashboard', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="javaScript:void(0);">Clients</a>
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
					<div class="portlet box green ">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-globe"></i>Manage Clients</div>
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
										<th>Design Firm Name</th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Email</th>
										<th>Phone Number</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($designers as $designer)
									<tr class="odd gradeX">
										<td><a href="{{ URL::to('/admin/client-details/'.$designer->id)  }}">{{ $designer->firm_name }}</a></td>
										<td>{{ $designer->first_name }}</td>
										<td>{{ $designer->last_name }}</td>
										<td>{{ $designer->email }}</td>
										<td>{{ $designer->phone }}</td>
										<td>@if($designer->status ==1) {{ 'Active' }} @else {{'InActive'}}@endif</td>
										<td>
											<!-- <a href ='javaScript:void(0)'  class="btn mini blue" alt="Edit"><i class="fa fa-edit"></i></a> -->
											<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_{{$designer->id}}" href="javaScript:void(0);"><i class="fa fa-pencil"></i>Edit</a>
											<a class="btn btn-xs red btn-removable del" data-id="1" id="del_{{$designer->id}}" href="javaScript:void(0);"><i class="fa fa-times"></i>Delete</a>
											@if($designer->status !=1)
											<a class="btn btn-xs green btn-removable resend" data-id="1" id="resend_{{$designer->id}}" href="javaScript:void(0);"><i class="fa fa-envelope"></i> Re-send email</a>
											@endif
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


	<!-- /.modal -->
		<div id="responsive" data-backdrop="static" class="modal fade" tabindex="-1" aria-hidden="true">
			<div id="designerModal" class="modal-dialog">
				<div class="modal-content">
					<form action="#" id="form_sample_2" class="form-horizontal">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 id="modatTitle" class="modal-title">Add Clients</h4>
					</div>
					<div class="modal-body">
						
							
								<div class="col-md-12 scrollFlug">
									<div class="form-body">
									<div class="row">	
									<div class="alert alert-danger display-hide">
										<button class="close" data-close="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success display-hide">
										<button class="close" data-close="alert"></button>
										Your form validation is successful!
									</div> 
									</div> 
										<div class="row">
											<div class="form-group col-md-11">
												<label class="control-label" for="firm_name">Design Firm Name<span class="required">*</span></label>
												<input id="firm_name" data-required="1"  name="firm_name" class="form-control" type="text" placeholder="Design Firm Name">
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label"  for="first_name">Principal’s First Name<span class="required">*</span></label>
													<input id="first_name" data-required="1"  name="first_name" class="form-control" type="text" placeholder="Principal’s First Name">												
												</div>
											</div>
											<div class="col-md-6">
											<div class="form-group">
													<label class="control-label" for="last_name">Principal’s Last Name<span class="required">*</span></label>
													<input id="last_name" data-required="1"  name="last_name" class="form-control" type="text" placeholder="Principal’s Last Name">
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-md-6">
												<div class="form-group">	
													<label class="control-label" for="primary_address">Primary Address 1</label>
													<textarea id="primary_address"  name="primary_address" data-provide="markdown" rows="2" class="form-control"></textarea>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="primary_address_two">Primary Address 2</label>
													<textarea id="primary_address_two"  name="primary_address_two" data-provide="markdown" rows="2" class="form-control"></textarea>
												</div>										
											</div>										
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="city">City</label>
													<input id="city" data-required="1"  name="city" class="form-control" type="text" placeholder="City">
												</div>	
											</div>	
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="state">State</label>
													<select class="form-control" id="state"  name="state">
														@if($states)
															<option value="">Select State</option>
														@foreach($states as $state)
															<option value="{{$state->state_code}}">{{$state->state_full}}</option>
														@endforeach
														@endif
													</select>
												</div>												
											</div>												
										</div>	


										<div class="row">
											<div class="col-md-6">
												<div class="form-group">	
													<label class="control-label" for="phone">Phone</label>
													<input id="phone" name="phone" data-required="1" class="form-control" type="text" placeholder="Enter Phone Number eg:(###)-###-####">
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="email">Email<span class="required">*</span></label>
													<input id="email" name="email" data-required="1"  class="form-control" type="text" placeholder="Enter Email Address">
												</div>	
											</div>	
										</div>	

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">	
													<label for="phone">Zip Code</label>
													<input id="zip_code" name="zip_code" class="form-control input-small" type="text" placeholder="Zip Code">
												</div>
											</div>

											<div id="accountStatus" style="display:none;" class="col-md-6">
												<div class="form-group">
													<label for="email">Account Status</label>
													<select class="form-control" id="status"  name="status">
														<option value="0">Inactive</option>
														<option value="1">Active</option>
													</select>	
												</div>	
											</div>	
										</div>


										<input type="hidden" name="id" id="did" value="">									
										<input type="hidden" name="rowPos" id="rowPos" value="">									
									</div>
								</div>
							
						
					</div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn default">Close</button>
						<button type="submit" class="btn green" id="btnSave">Save</button>
					</div>
				</form>
				</div>
			</div>
		</div>
	
		<!-- /.modal -->
	
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/Designer.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop