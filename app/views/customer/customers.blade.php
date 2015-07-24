@extends('layouts.designer')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Customers</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="javaScript:void(0);">Customers</a>
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
							<div class="caption"><i class="fa fa-globe"></i>Manage Customer</div>
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
										<th>Customer ID</th>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Email</th>
										<th>Phone Number</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($customers as $customer)
									<tr class="odd gradeX">
										<td><a href="{{ URL::to('/customer-details/'.$customer->id)  }}"><b>{{ $customer->customer_id }}</b></a></td>
										<td>{{ $customer->customer_first_name }}</td>
										<td>{{ $customer->customer_last_name }}</td>
										<td>{{ $customer->customer_email }}</td>
										<td>{{ $customer->customer_phone }}</td>
										<td>
											<!-- <a href ='javaScript:void(0)'  class="btn mini blue" alt="Edit"><i class="fa fa-edit"></i></a> -->
											<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_{{$customer->id}}" href="javaScript:void(0);"><i class="fa fa-pencil"></i>Edit</a>
											<a class="btn btn-xs red btn-removable del" data-id="1" id="del_{{$customer->id}}" href="javaScript:void(0);"><i class="fa fa-times"></i>Delete</a>
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
						<h4 id="modatTitle" class="modal-title">Add Customer</h4>
					</div>
					<div class="modal-body">
						
								<div class="col-md-12">
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
											<div class="col-md-6">
												<div class="form-group">
													<label  class="control-label" for="customer_first_name">First Name<span class="required">*</span></label>
													<input id="customer_first_name" data-required="1"  name="customer_first_name" class="form-control" type="text" placeholder="Principal’s First Name">				
											     </div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
												<label  class="control-label" for="customer_last_name">Last Name<span class="required">*</span></label>
												<input id="customer_last_name" data-required="1"  name="customer_last_name" class="form-control" type="text" placeholder="Principal’s Last Name">
											</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">	
												<label  class="control-label" for="customer_phone">Phone<span class="required">*</span></label>
												<input id="customer_phone" name="customer_phone" data-required="1" class="form-control" type="text" placeholder="Enter Phone Number eg:(###)-###-####">
											</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
												<label  class="control-label" for="customer_email">Email</label>
												<input id="customer_email" name="customer_email" data-required="1"  class="form-control" type="text" placeholder="Enter Email Address">
											</div>	
										</div>
										</div>


										<div class="row">
											<div class="col-md-6">
												<div class="form-group">	
												<label  class="control-label" for="customer_primary">Primary Address 1</label>
												<textarea id="customer_primary"  name="customer_primary" data-provide="markdown" rows="2" class="form-control"></textarea>
											</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">	
												<label  class="control-label" for="customer_address2">Primary Address 2</label>
												<textarea id="customer_address2"  name="customer_address2" data-provide="markdown" rows="2" class="form-control"></textarea>
											</div>										
										</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
												<label  class="control-label" for="customer_city">City</label>
												<input id="customer_city" data-required="1"  name="customer_city" class="form-control" type="text" placeholder="City">
											</div>	
											</div>	
											<div class="col-md-6">
												<div class="form-group">
												<label  class="control-label" for="customer_state">State</label>
												<select class="form-control" id="customer_state"  name="customer_state">
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
												<label  class="control-label" for="customer_zip">Zip Code</label>
												<input id="customer_zip" name="customer_zip" data-required="1" class="form-control input-small" type="text" placeholder="Enter Zip Code">
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
{{ HTML::script('includes/js/Customer.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop