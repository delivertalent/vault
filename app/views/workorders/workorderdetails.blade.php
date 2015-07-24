@extends('layouts.designer')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
{{ HTML::style('includes/assets/plugins/bootstrap-timepicker/compiled/timepicker.css') }}
{{ HTML::style('includes/assets/plugins/bootstrap-colorpicker/css/colorpicker.css') }}
{{ HTML::style('includes/assets/plugins/fancybox/source/jquery.fancybox.css') }}

<style media="print">
  .page-title,.breadcrumb,#jobform,#imageHolder,#qrCodeLabel,.footer,.doNotPrint{ display: none; }
 .control-label{width: 200px; float: left;}
 .form-control{width: 200px; float: left; border:none }
	a:link:after, a:visited:after {
	    content: "";
	}
 /*  #qrContainer{ display: block !important; } */
    #btnSave{display:none}
</style>

			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<div class="row" >
						<div class=" col-md-4">
						<h3 class="page-title">Work order Details</h3>
						</div>
						<img class="img-responsive doNotPrint" style="float: right; height: 70px; margin: 0 18px 0 0; width: 530px;"  src="{{ URL::asset('without-flash-uploader/images_ad/thumb/'.$advImage->advertise_image) }}" alt="" class="col-md-8 pull-right">
					</div>					
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="javaScript:void(0);">Work order Details</a>
							<i class="fa fa-angle-right"></i>
						</li>	
						<li><button onclick="window.history.back()">Go Back</button></li>						
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
 
	<!-- BEGIN PAGE CONTENT-->
			<div id="jobTop" class="row">
				<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box blue">
						<div class="portlet-title">
							<div id="topFlug" class="caption"><i class="fa fa-globe"></i> Work Order</div>
							<div class="actions">
								<a class="btn default green doNotPrint" onClick="window.print()" href="javaScript:void(0)"><i class="fa fa-print"></i> Print</a>
							</div>
						</div>
						<div class="portlet-body">
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
												<label class="control-label" for="job_name">Job Name: <span class="required">*</span></label>
												<input class="form-control" type="text" name="jobName" value="{{$workorders->job_name}}" readonly>
																							
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="wo_delivery_date" class="control-label">Delivery Date </label>
												<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
													<input type="text" id="wo_delivery_date" value="{{$workorders->wo_delivery_date}}" name="wo_delivery_date" class="form-control" style="width:100%" readonly>
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
													<input type="text" id="wo_delivery_time" value="{{$workorders->wo_delivery_time}}" name="wo_delivery_time" class="form-control timepicker-24" style="width:100%" readonly>
													<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
													</span>
												</div>
											</div>
										</div>
										
									</div>	

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">	
												<label class="control-label" for="notes">Note</label>
												<textarea id="notes"  name="notes" data-provide="markdown" rows="2" class="form-control">{{$workorders->notes}}</textarea>
											</div>
										</div>	
										<div class="col-md-6">
											<div class="form-group">	
												<label class="control-label" for="wo_requests">Other Requests<span class="required">*</span></label>
												<textarea id="wo_requests" name="wo_requests" data-provide="markdown" rows="2" class="form-control">{{$workorders->wo_requests}}</textarea>
											</div>
										</div>


									</div>

									<div class="row">
										<div id="invLIST" class="col-md-12">
											<table class="table table-bordered table-striped table-condensed flip-content" id="tdEmergencyData">
												<thead>
													<tr>
														<th class="table-checkbox doNotPrint">Select</th>
														<th>Id</th>
														<th>Image</th>
														<th>PO#</th>
														<th>Description</th>
														<th>Room</th>
														<th>Manufacturer</th>
														<th>Mfg #</th>
														<th>Category </th>
														<th>Status</th>
														<th>QR Code</th>
														<th>Notes</th>
													</tr>
												</thead>
												<tbody>
													@if($inventories)
														@foreach($inventories as $inventory)
															<?php
													        if($inventory->inv_item_status ==1)
													            $status = "Received in good condition";
													        else if($inventory->inv_item_status ==2)
													            $status = "Damaged";
													        else if($inventory->inv_item_status ==3)
													            $status = "Being repaired – in house";
													        else if($inventory->inv_item_status ==4)
													            $status = "Being repaired – out for repair";
													        else if($inventory->inv_item_status ==5)
													            $status = "Awaiting call tag / awaiting pickup";
													        else if($inventory->inv_item_status ==6)
													            $status = "Picked up";
													        else{
													            $status = "";
													        }
													        ?>
														<tr class="odd gradeX @if($inventory->inv_woid !=$workorders->id) doNotPrint @endif">
															<td class="doNotPrint"><input type="checkbox" @if($inventory->inv_woid ==$workorders->id) checked @endif name="selector[]" class="checkboxes" value="{{ $inventory->id }}" /></td>
															<td>{{ $inventory->id }}</td>
															<td> @if($inventory->inv_item_images!='')
																<a class="mix-preview fancybox-button" href="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" title="Inventory Image:{{ $inventory->id }}" data-rel="fancybox-button">
																<img width="50" height="50" src="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" alt="">
																</a>
																@endif
														    </td>
															<td>{{ $inventory->inv_pono }}</td>
															<td>{{ $inventory->itds_name }}</td>
															<td>{{ $inventory->room_name }}</td>
															<td>{{ $inventory->manuf_name }}</td>
															<td>{{ $inventory->inv_mfg }}</td>
															<td>{{ $inventory->invcat_name }}</td>
															<td>{{ $status }}</td>
															<td> @if($inventory->inv_qrcode!='')<img width="50" height="50" src="../{{ $inventory->inv_qrcode }}" alt="">@endif</td>
															<td>{{ $inventory->inv_note }}</td>
														</tr>		
														@endforeach
													@endif

												</tbody>
											</table>
										</div>
									</div>
									<div style="clear:both"></div>

									<input type="hidden" name="id" id="did" value="{{$workorders->id}}">									
									<input type="hidden" name="rowPos" id="rowPos" value="">									
								</div>
								<div class="form-actions right">
									<button type="submit" id="btnSave" class="btn blue"><i class="fa fa-check"></i> Update</button>
								</div>
							</from>
				
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->


	
		<!-- /.modal -->
	
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}  
{{ HTML::script('includes/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js') }}
{{ HTML::script('includes/assets/plugins/fancybox/source/jquery.fancybox.pack.js') }} 
{{ HTML::script('includes/js/WorkorderDetails.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		   handleTimePickers();
		});
	</script>			
@stop