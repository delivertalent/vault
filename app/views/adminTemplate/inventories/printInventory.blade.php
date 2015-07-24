@extends('layouts.master')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
<style media="print">
  .page-title,.breadcrumb,#jobform,#imageHolder,#qrCodeLabel,.actions,#btnPrint,.footer{ display: none; }
  #printedContainer{ display: block !important; }

.form-body {
    padding: 10px;
}

.row:before, .row:after {
    content: " ";
    display: table;
}
.row:before, .row:after {
    content: " ";
    display: table;
}
*, *:before, *:after {
    box-sizing: border-box;
}
.row:after {
    clear: both;
}
.row:before, .row:after {
    content: " ";
    display: table;
}
.row:after {
    clear: both;
}
.row:before, .row:after {
    content: " ";
    display: table;
}
*, *:before, *:after {
    box-sizing: border-box;
}
.row {
    margin-left: -15px;
    margin-right: -15px;
}
.col-md-4 {
    width: 33.3333%;
}
.col-md-6 {
    width: 50%;
}
.col-md-8 {
    width: 66.6667%;
}
.col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11 {
    float: left;
}
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}

.form-horizontal .form-group:before, .form-horizontal .form-group:after {
    content: " ";
    display: table;
}
.form-horizontal .form-group:before, .form-horizontal .form-group:after {
    content: " ";
    display: table;
}
*, *:before, *:after {
    box-sizing: border-box;
}
.form-horizontal .form-group:after {
    clear: both;
}
.form-horizontal .form-group:before, .form-horizontal .form-group:after {
    content: " ";
    display: table;
}
.form-horizontal .form-group:after {
    clear: both;
}
.form-horizontal .form-group:before, .form-horizontal .form-group:after {
    content: " ";
    display: table;
}
*, *:before, *:after {
    box-sizing: border-box;
}
.form-horizontal .form-group {
    margin-left: -15px;
    margin-right: -15px;
}
.form-group {
    margin-bottom: 15px;
}

label {
    font-size: 12px;
    font-weight: 200;
}

.form-horizontal .form-control-static {
    padding-top: 7px;
}
.form-control-static {
    font-size: 12px;
    padding-top: 7px;
}
.form-control-static {
    margin-bottom: 0;
}

.form-control{width: 200px; float: left; border:none }
 .portlet.box.green{
 	border-style: none;
    border-width: 0;	
 }
div, input, select, textarea, span, img, table, td, th, p, a, button, ul, code, pre, li {
    border-radius: 0 !important;
}
</style>

			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Print Inventory Details</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/admin/dashboard', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						
						<li>
							{{ HTML::link('/admin/inventories', 'Inventory List') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							{{ HTML::link('/admin/inventory-details/'.$inventories->id, 'Inventory Details') }} 
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
										<div class="caption"><i class="fa fa-reorder"></i>Inventory Information:</div>
										<div class="actions">
											<a id="btnPrint" onclick="window.print();" href="javaScript:void(0)" class="btn blue" type="button">
												<i class="fa fa-print"></i> Print
											</a>
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form class="form-horizontal" role="form" id="printedContainer">
											<div class="form-body">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">PO#:</label>
															<div class="col-md-8">
																<p class="form-control-static"><b>{{$inventories->inv_pono}}</b></p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Designer Name:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$designerFullname}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Job Name:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$inventories->job_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Item Description:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$inventories->itds_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Category:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$inventories->invcat_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Date Received :</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$inventories->inv_received}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--div row Start-->        
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Quantity:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$inventories->inv_quantity}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Date Delivered :</label>
															<div class="col-md-8">
																<p class="form-control-static">@if($inventories->inv_delivered != '0000-00-00'){{$inventories->inv_delivered}} @endif</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--div row End -->                      
												<!--div row Start-->        
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Size:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{htmlspecialchars($inventories->inv_size, ENT_QUOTES)}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Manufacturer :</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$manufacturers_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--div row End -->	
												<!--div row Start-->        
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Carrier:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$carriers_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Item Status :</label>
															<div class="col-md-8">
																<p class="form-control-static">
															@if($inventories->inv_item_status == 1) {{'Received in good condition'}} @endif
															@if($inventories->inv_item_status == 2) {{'Damaged'}} @endif
															@if($inventories->inv_item_status == 3) {{'Being repaired – in house'}} @endif
															@if($inventories->inv_item_status == 4) {{'Being repaired – out for repair'}} @endif
															@if($inventories->inv_item_status == 5) {{'Awaiting call tag / awaiting pickup'}} @endif
															@if($inventories->inv_item_status == 6) {{'Picked up'}} @endif							

																</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--div row End -->
												<!--div row Start-->        
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Room:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$inventories->room_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Delivery Status :</label>
															<div class="col-md-8">
																<p class="form-control-static">
																
															@if($inventories->inv_delivery_status == 1) {{'Not yet received'}} @endif
															@if($inventories->inv_delivery_status == 2) {{'In storage'}}  @endif
															@if($inventories->inv_delivery_status == 3) {{'Pulled / loaded'}}  @endif
															@if($inventories->inv_delivery_status == 4) {{'Delivered'}}  @endif

																</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--div row End -->		
												<!--div row Start-->        
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Mfg #:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$inventories->inv_mfg}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Comments :</label>
															<div class="col-md-8">
																<p class="form-control-static">{{htmlspecialchars($inventories->inv_note, ENT_QUOTES)}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--div row End -->	
												<br/><br/><br/>

												<h3>Inventory Images</h3>
												<div class="foto_box" id="image" style="overflow:hidden">	
													@if($incentoryImages)	
														@foreach($incentoryImages as $incentoryImage)
															@if($incentoryImage->img_name !='')
															<div id="imgContainer_{{$incentoryImage->id}}" style="width:205px; float:left;">
															<img style="margin:5px; width:200px; height:150px;" src="../../without-flash-uploader/images/{{$incentoryImage->img_name}}"/>
															</div>
															@endif
														@endforeach
													@endif
												</div>																																
											</div>
										
										</form>
										<!-- END FORM-->  
									</div>
								</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
							
			<div style="clear:both"></div>
			<input type="hidden" name="id" id="did" value="{{$inventories->id}}">									
			<input type="hidden" name="rowPos" id="rowPos" value="">
			<input type="hidden" name="qr_firm_id" id="qr_firm_id" value="{{$inventories->firm_id}}">									
			<input type="hidden" name="qr_inv_description" id="qr_inv_description" value="{{$inventories->inv_description}}">									
			<input type="hidden" name="qr_inv_room" id="qr_inv_room" value="{{$inventories->inv_room}}">									
			<input type="hidden" name="job_id" id="job_id" value="{{$inventories->job_id}}">											
			<input type="hidden" name="inv_woid" id="inv_woid" value="{{$inventories->inv_woid}}">											
			<input type="hidden" name="job_client_id" id="job_client_id" value="{{$inventories->job_client_id}}">											
								
					

	
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/adminjs/InventoryDetails.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop