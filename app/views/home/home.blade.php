@extends('layouts.designer')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
{{ HTML::style('uploadify/uploadify.css') }}

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
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row homeBody">
				<div class="col-md-12">
					<!-- IF THE ACCOUNT IS NOT IN ACTIVE STATE -->
					@if($designerInfo->status ==3) 

						<!-- BEGIN UNORDERED LISTS PORTLET-->
						<div id="termContainer" class="portlet">
							<div class="portlet-title">
								<div class="caption"><i class="fa fa-reorder"></i>Terms and Conditions</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">
								<!-- <iframe id="iframepdf" src="files/GLG School form design.pdf"></iframe> -->
								<object id="pdfContainer" data="files/Vault Designer Delivery 2014.pdf" type="application/pdf">
							        <embed src="files/Vault Designer Delivery 2014.pdf" type="application/pdf" />
							    </object>

									<div class="form-group">
										<div class="checkbox-list">
											<label id="ckLavel" class="checkbox-inline">
												<input type="checkbox" id="acceptCheckbox" value="option1"> Check to Agree with Terms and Conditions
											</label> 
										</div>
									</div>	

									<div class="form-group">
										<a class="btn green" id="inlineCheckbox" href="javascript:void(0)">Next <i class="fa fa-angle-right"></i></a>
									</div>						    
								
							</div>
						</div>
						<!-- END UNORDERED LISTS PORTLET-->


						<!-- BEGIN UNORDERED LISTS PORTLET-->
						<div id="endUserAgreement" style="display:none;" class="portlet">
							<div class="portlet-title">
								<div class="caption"><i class="fa fa-reorder"></i>Warehouse Wizard End User Agreement</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">
								<!-- <iframe id="iframepdf" src="files/GLG School form design.pdf"></iframe> -->
								<object id="pdfContainer" data="files/Warehouse Wizard End User Agreement.pdf" type="application/pdf">
							        <embed src="files/Warehouse Wizard End User Agreement.pdf" type="application/pdf" />
							    </object>

									<div class="form-group">
										<div class="checkbox-list">
											<label id="ckLavel2" class="checkbox-inline">
												<input type="checkbox" id="acceptCheckbox2" value="option1"> Check to Agree with Terms and Conditions
											</label> 
										</div>
									</div>	

									<div class="form-group">
										<a class="btn green" id="inlineCheckbox2" href="javascript:void(0)">Next <i class="fa fa-angle-right"></i></a>
									</div>						    
								
							</div>
						</div>
						<!-- END UNORDERED LISTS PORTLET-->

						<!-- BEGIN UNORDERED LISTS PORTLET-->
						<div id="forgetForm" style="display:none;" class="portlet">
							<div class="portlet-title">
								<div class="caption"><i class="fa fa-reorder"></i>Update Password to Active your Account</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">
							<form id="form_sample_2" class="form-horizontal" role="form">
								<div class="form-group">
								<div class="alert alert-danger display-hide">
										<button class="close" data-close="alert"></button>
										You have some form errors. Please check below.
									</div>
									<div class="alert alert-success display-hide">
										<button class="close" data-close="alert"></button>
										Your form validation is successful!
									</div>
								</div>

								<div class="form-group">
									<label for="userPassword" class="col-md-2 control-label">Password</label>
									<div class="col-md-4">
										<input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Password">
									</div>
								</div>

								<div class="form-group">
									<label for="retype_password" class="col-md-2 control-label">Re-type Password</label>
									<div class="col-md-4">
										<input type="password" class="form-control" id="retype_password" name="retype_password" placeholder="Re-type Password">
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-offset-2 col-md-10">
										<button id="btnSave" type="submit" class="btn blue">Submit</button>
									</div>
								</div>
							</form>
							<hr>									
							</div>
						</div>
						<!-- END UNORDERED LISTS PORTLET-->

					@endif
						<!-- BEGIN DASHBOARD BOXES-->
						<div id="userDasjboard" @if($designerInfo->status ==3){{'style="display:none;"'}} @endif>
							<div  class="row">
									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a class="dlinkClass" href="{{ URL::to('/jobs')  }}">
										<div id="speedJob" class="">
											
											<div class="details designerJobs">
												<div class="number"> {{$jobs}} </div>
											</div>
								
										</div>
										</a>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a class="dlinkClass" href="{{ URL::to('/designer-inventories')  }}">
										<div id="speedInventory" class="">
											
											<div class="details designerInventory">
												<div class="number"> {{$totalInventory}} </div>
											</div>
											
										</div>
										</a>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a class="dlinkClass" href="{{ URL::to('/designer-damage-inventories')  }}">
										<div id="designerBroken" class="">
											
											<div class="details designerInventory">
												<div class="number">{{$damaged}}</div>
											</div>
											
										</div>
										</a>
									</div>
							</div>


							<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a class="dlinkClass" href="{{ URL::to('/workorders')  }}">
										<div id="designerWork" class="">
											
											<div class="details workOrderNumber">
												<div class="number"> {{$newworkorders}}</div>
											</div>
										</div>
										</a>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a class="dlinkClass" href="{{ URL::to('/additional-designer')  }}">
										<div id="designerDesign" class="">
											
											<div class="details designerInventory">
												<div class="number"> {{$aditionalDesigners}} </div>
											</div>
											
										</div>
										</a>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
										<a class="dlinkClass" href="{{ URL::to('/workorders-form')  }}">
										<div id="designerViewWork" class="">
											
											<div class="details designerInventory">
												<div class="number"></div>
											</div>
											
										</div>
										</a>
									</div>

							</div>
						</div>
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