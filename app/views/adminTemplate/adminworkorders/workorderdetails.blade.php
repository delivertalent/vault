@extends('layouts.master')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
{{ HTML::style('includes/assets/plugins/bootstrap-timepicker/compiled/timepicker.css') }}
{{ HTML::style('includes/assets/plugins/bootstrap-colorpicker/css/colorpicker.css') }}
<style media="print">
  .page-title,.breadcrumb,#jobform,#imageHolder,#qrCodeLabel,.footer,.doNotPrint{ display: none; }
 .control-label{width: 200px; float: left;}
 .form-control{width: 200px; float: left; border:none }
 .portlet.box.blue{
 	border-style: none;
    border-width: 0;	
 }
	a:link:after, a:visited:after {
	    content: "";
	}
 /*  #qrContainer{ display: block !important; } */
    #btnSave{display:none}
    #workTop{display:block}
 table { page-break-after:auto ; page-break-before : auto;}
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; page-break-after:auto }
  thead { display:table-header-group; page-break-after:auto ;}
  tfoot { display:table-footer-group }
  .page-content {
	min-height: auto !important;
}
</style>

			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Work order Details</h3>
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
<div id="workTop" style="font-size: 14px; overflow:hidden; margin:0 0 10px 0;"  class="row doPrint">
	<div style="width:300px; float:left;" >	
		<b>{{$workorders->firm_name}}</b><br/>
		<span>{{$workorders->first_name}} {{$workorders->last_name}}</span><br/>
		<span>Phone: {{$workorders->phone}} </span><span></span><br/>
		<span>Date: {{date("m-d-Y")}} </span><span></span><br/>
	</div>

	<div style="float:left;" >	
		<b>Vault Designer Delivery</b><br/>
		<span>561-2962-6222</span><br/>
		<span>vaultdesignerdelivery.com</span><br/><br/><br/>
		<img src="{{ URL::asset('includes/img/template_logo.png')}}" alt="logo" class="img-responsive" />
	</div>
	<div style="float:right;" >	

	<b>{{$workorders->job_name}}</b><br/>
	<span>{{$workorders->job_address1}}</span><br/>
	<span>{{$workorders->job_city}} {{$workorders->state_full}}</span><br/>
	<span>Zip: {{$workorders->job_zip}} </span><span></span><br/>
	<span>Time: {{date('h:i:s A')}} </span><span></span><br/>

	</div>	
</div>	
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
								<div class="alert alert-danger display-hide doNotPrint">
									<button class="close" data-close="alert"></button>
									You have some form errors. Please check below.
								</div>
								<div class="alert alert-success display-hide doNotPrint">
									<button class="close" data-close="alert"></button>
									Your form validation is successful!
								</div> 
									<div class="row doNotPrint">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label" for="job_name">Client Name: <span class="required">*</span></label>
												<input class="form-control" type="text" name="firm_name" value="{{$workorders->firm_name}}" readonly>										
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label" for="job_name">Job Name: <span class="required">*</span></label>
												<input class="form-control" type="text" name="jobName" value="{{$workorders->job_name}}" readonly>										
											</div>
										</div>
									</div>

									<div class="row doNotPrint">
										<div class="col-md-4">
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

										<div class="col-md-4">
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
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label" for="wo_delivery_time">Status</label>
												<select class="form-control " id="wo_status"  name="wo_status">
														<option @if($workorders->wo_status ==1) selected="selected" @endif value="1">New</option>
														<option @if($workorders->wo_status ==2) selected="selected" @endif value="2">PENDING</option>
														<option @if($workorders->wo_status ==3) selected="selected" @endif value="3">PULLED</option>
														<option @if($workorders->wo_status ==4) selected="selected" @endif value="4">DELIVERED</option>
														<option @if($workorders->wo_status ==5) selected="selected" @endif value="5">Closed</option>
												</select>			
											</div>
										</div>										
									</div>	

									<div class="row doNotPrint">
										<div class="col-md-6">
											<div class="form-group">	
												<label class="control-label" for="notes">Note</label>
												<textarea id="notes"  name="notes" data-provide="markdown" rows="2" class="form-control">{{$workorders->notes}}</textarea>
											</div>
										</div>	
										<div class="col-md-6">
											<div class="form-group">	
												<label class="control-label" for="wo_requests">Other Requests</label>
												<textarea id="wo_requests" name="wo_requests" data-provide="markdown" rows="2" class="form-control">{{$workorders->wo_requests}}</textarea>
											</div>
										</div>


									</div>

									<div class="row">
										<div id="invLIST" class="col-md-12">
											<table class="table table-striped table-condensed flip-content" id="tdEmergencyData">
												<thead>
													<tr>
														<th class="table-checkbox doNotPrint">Select</th>
														<th>Id</th>
														<th>PO#</th>
														<th>Description</th>
														<th>Room</th>
														<th class="doNotPrint">Manufacturer</th>
														<th class="doNotPrint">Mfg #</th>
														<th class="doNotPrint">Category </th>
														<th class="doNotPrint">Status</th>
														<th class="doNotPrint">Image</th>
														<th>QR Code</th>
														<th class="doNotPrint">Notes</th>
														<th>Bin</th>
														<th>Bin Ltr</th>														
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
															<td>{{ $inventory->inv_pono }}</td>
															<td>{{ wordwrap($inventory->itds_name, 15, "<br />\n") }}</td>
															<td>{{ wordwrap($inventory->room_name, 15, "<br />\n") }}</td>
															<td class="doNotPrint">{{ wordwrap($inventory->manuf_name, 15, "<br />\n") }}</td>
															<td class="doNotPrint">{{ wordwrap($inventory->inv_mfg, 15, "<br />\n")  }}</td>
															<td class="doNotPrint">{{ wordwrap($inventory->invcat_name, 15, "<br />\n")  }}</td>
															<td class="doNotPrint">{{ wordwrap($status, 15, "<br />\n") }}</td>
															<td class="doNotPrint"> @if($inventory->inv_item_images!='')<img width="50" height="50" src="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" alt="">@endif</td>
															<td> @if($inventory->inv_qrcode!='')<img width="50" height="50" src="{{ URL::asset($inventory->inv_qrcode) }}" alt="">@endif</td>
															<td class="doNotPrint">{{ wordwrap($inventory->inv_note, 15, "<br />\n") }}</td>
															<td> {{ $inventory->bin_name }}</td>
															<td> {{ $inventory->binlrt_name }}</td>
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
{{ HTML::script('includes/js/adminjs/AdminWorkorderDetails.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		   handleTimePickers();
		});
	</script>			
@stop