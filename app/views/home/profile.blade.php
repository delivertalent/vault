@extends('layouts.designer')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<div class="row" >
						<div class=" col-md-4">
						<h3 class="page-title">{{$designerInfo->firm_name}}</h3>
						</div>
						<img calss="img-responsive" style="width:530px; height:70px;"  src="{{ URL::asset('without-flash-uploader/images_ad/thumb/'.$advImage->advertise_image) }}" alt="" class="col-md-8 pull-right">
					</div>
					<div class="clear"></div>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/profile', 'Profile') }} 
							<i class="fa fa-angle-right"></i>
						</li>						
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profileBody">
				<div class="col-md-12">

					<!-- BEGIN PROFILE PORTLET-->
								<div class="portlet box green">
									<div class="portlet-title">
										<div class="caption"><i class="fa fa-reorder"></i>Profile Information</div>
										<div class="tools">
											<a href="javascript:;" class="collapse"></a>
											<!-- <a href="#portlet-config" data-toggle="modal" class="config"></a>
											<a href="javascript:;" class="reload"></a> -->
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form action="#" id="form_sample_2" class="form-horizontal">
											<div class="form-body">
												<div class="row">
													<div class="col-md-8">
														
															<div class="alert alert-danger display-hide">
																<button class="close" data-close="alert"></button>
																You have some form errors. Please check below.
															</div>
															<div class="alert alert-success display-hide">
																<button class="close" data-close="alert"></button>
																Your form validation is successful!
															</div>	
														
													</div>	
												</div>

												<div style="clear:both"></div>	
												<div class="row">
													<div class="col-md-8">
														<div class="form-group">
															<label class="control-label col-md-3" for="firm_name">Design Firm Name</label>
															<div class="col-md-9">
																<input type="text" id="firm_name" data-required="1" value="{{$designerInfo->firm_name}}"  name="firm_name" class="form-control" placeholder="Chee Kin">
															</div>
														</div>
													</div>
												</div>	
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4" for="first_name">Principal’s First Name</label>
															<div class="col-md-8">
																<input type="text" id="first_name" data-required="1" value="{{$designerInfo->first_name}}"  name="first_name" class="form-control" placeholder="Chee Kin">
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4" for="last_name">Principal’s Last Name</label>
															<div class="col-md-8">
																<input type="text" id="last_name" data-required="1" value="{{$designerInfo->last_name}}"  name="last_name" class="form-control" placeholder="Chee Kin">
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4" for="phone">Phone</label>
															<div class="col-md-8">
																<input type="text" id="phone" name="phone" value="{{$designerInfo->phone}}" class="form-control" placeholder="Chee Kin">
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4" for="email">Email</label>
															<div class="col-md-8">
																<input type="text" class="form-control disable" value="{{$designerInfo->email}}" placeholder="Lim">
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												
												<h3 class="form-section">Address</h3>
												<!--/row-->       
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4" for="primary_address">Primary Address 1</label>
															<div class="col-md-8">
																<input type="text" id="primary_address" value="{{$designerInfo->primary_address}}"  name="primary_address" class="form-control" >
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4" for="primary_address_two">Primary Address 2</label>
															<div class="col-md-8">
																<input type="text" id="primary_address_two" value="{{$designerInfo->primary_address_two}}"  name="primary_address_two" class="form-control" >
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">City</label>
															<div class="col-md-8">
																<input type="text" value="{{$designerInfo->city}}" id="city" data-required="1"  name="city" class="form-control"> 
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">State</label>
															<div class="col-md-8">
																<select name="state" id="state" data-name="state"  data-filter="true" class="select2me form-control">
																	@if($states)
																	@foreach($states as $state)
																		<option  value="{{$state->state_code}}" @if($designerInfo->state == $state->state_code) selected="selected" @endif >{{$state->state_full}}</option>
																	@endforeach
																	@endif
																</select> 
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->           
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4" for="zip_code">Zip Code</label>
															<div class="col-md-8">
																<input type="text" id="zip_code" name="zip_code" value="{{$designerInfo->zip_code}}" class="form-control input-small"> 
															</div>
														</div>
													</div>
												</div>
												<!--/row-->
											</div>
											<div class="form-actions fluid">
												<div class="row">
													<div class="col-md-6">
														<div class="col-md-offset-3 col-md-9">
															<button id="btnSave" type="submit" class="btn green">Update</button>                            
														</div>
													</div>
													<div class="col-md-6"></div>
												</div>
											</div>
										</form>
										<!-- END FORM-->                
									</div>
					<!-- END OF PROFILE PORTLET-->

						
					
				</div>
			</div>
			<!-- END PAGE CONTENT-->


			
	<script src="assets/plugins/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript" ></script>
	<script src="assets/plugins/bootstrap-markdown/lib/markdown.js" type="text/javascript" ></script>
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/Profile.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop