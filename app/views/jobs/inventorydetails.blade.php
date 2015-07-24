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
						<h3 class="page-title">Inventory Details</h3>
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
							<a href="javaScript:void(0);">Inventory Details</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li><button onclick="window.history.back()">Go Back</button></li>						
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->

			<div id="jobform" class="row">
				<div class="col-md-12">

					<div class="portlet box blue">
						<div class="portlet-title">
							<div id="modatTitle" class="caption"><i class="fa fa-reorder"></i> Inventory.</div>
							<div class="actions">
								<a id="btnEmail" href="javaScript:void(0)" class="btn green" type="button">
									<i class="fa fa-envelope"></i> Email 
								</a>

							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->
						<!-- <form action="#" class="horizontal-form"> -->
						<form action="#" id="form_sample_2" class="horizontal-form">


									<div class="form-body"> 
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="job_name">Job Name</label>
													<input id="job_name" data-required="1" value="{{$inventories->job_name}}"  name="job_name" class="form-control" type="text" placeholder="Job Name" readonly>												
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_description">Item Description</label>
													<input id="job_name" data-required="1" value="{{$inventories->itds_name}}"  name="itds_name" class="form-control" type="text" placeholder="Item Description" readonly>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label for="inv_pono" class="control-label">PO#</label>
													<input id="inv_pono" data-required="1" value="{{$inventories->inv_pono}}"  name="inv_pono" class="form-control" type="text" placeholder="PO#" readonly>
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_category">Category </label>
													<input id="invcat_name" data-required="1" value="{{$inventories->invcat_name}}"  name="invcat_name" class="form-control" type="text" placeholder="Category Name" readonly>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="inv_received" class="control-label">Date Received </label>
													<input id="inv_received" data-required="1" value="@if($inventories->inv_received != '0000-00-00'){{$inventories->inv_received}} @endif"  name="inv_received" class="form-control input-medium " type="text" placeholder="Date Received" readonly>                         
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">	
												<label for="inv_delivered" class="control-label">Date Delivered </label>
													<input id="inv_delivered" data-required="1" value="@if($inventories->inv_delivered != '0000-00-00') {{$inventories->inv_delivered}} @endif"  name="inv_delivered" class="form-control input-medium " type="text" placeholder="Date Delivered" readonly>
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_quantity">Quantity</label>
													<input id="inv_quantity" data-required="1" value="{{$inventories->inv_quantity}}"   name="inv_quantity" class="form-control" type="text" placeholder="Quantity" readonly>
												</div>										
											</div>	
											<div class="col-md-4">
												<div class="form-group">
													<label for="inv_size" class="control-label">Size</label>
													<input id="inv_size" data-required="1" value="{{htmlspecialchars($inventories->inv_size, ENT_QUOTES)}}"   name="inv_size" class="form-control" type="text" placeholder="Size" readonly>
												</div>	
											</div>	
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_manufacture">Manufacturer</label>
													<input id="manuf_name" data-required="1" value="{{$inventories->manuf_name}}"  name="manuf_name" class="form-control" type="text" placeholder="Manufacturer" readonly>
												</div>												
											</div>																				
										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">	
													<label class="control-label" for="inv_carrier">Carrier</label>												
													<input id="inv_carrier" data-required="1" value="{{$inventories->carrier_name}}"  name="inv_carrier" class="form-control" type="text" placeholder="Room" readonly>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_room">Room</label>  
													<input id="room_name" data-required="1" value="{{$inventories->room_name}}"  name="room_name" class="form-control" type="text" placeholder="Room" readonly>                 
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_storage_price">Storage Price</label>
													<input id="inv_storage_price" data-required="1" value="{{$inventories->inv_storage_price}}"   name="inv_storage_price" class="form-control" type="text" placeholder="Storage Price" readonly>                
												</div>
											</div>											

										</div>	
										<div style="clear:both"></div>


										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_mfg">Mfg #</label>
													<input id="inv_mfg" data-required="1" value="{{$inventories->inv_mfg}}"   name="inv_mfg" class="form-control" type="text" placeholder="Mfg #" readonly>      
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_item_status">Item Status</label>
													<?php 
														$itm_status = '';
														if($inventories->inv_item_status == 1) $itm_status="Received in good condition";
														elseif($inventories->inv_item_status == 2) $itm_status="Damaged";
														elseif($inventories->inv_item_status == 3) $itm_status="Being repaired – in house";
														elseif($inventories->inv_item_status == 4) $itm_status="Being repaired – out for repair";
														elseif($inventories->inv_item_status == 5) $itm_status="Awaiting call tag / awaiting pickup";
														elseif($inventories->inv_item_status == 6) $itm_status="Picked up";
													?>
													<input id="inv_item_status" data-required="1" value="{{$itm_status}}"   name="inv_item_status" class="form-control" type="text" placeholder="Item Status" readonly>											
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_delivery_status">Delivery Status</label>
													<?php 
														$delivery_status = '';
														if($inventories->inv_delivery_status == 1) $delivery_status="Not yet received";
														elseif($inventories->inv_delivery_status == 2) $delivery_status="In storage";
														elseif($inventories->inv_delivery_status == 3) $delivery_status="Pulled / loaded";
														elseif($inventories->inv_delivery_status == 4) $delivery_status="Delivered";
													?>
													<input id="inv_delivery_status" data-required="1" value="{{$delivery_status}}"   name="inv_delivery_status" class="form-control" type="text" placeholder="Delivery Status" readonly>																											
												</div>
											</div>											
										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">	
													<label class="control-label" for="inv_warehouse">Warehouse</label>
													<input id="inv_warehouse" data-required="1" value="{{$inventories->warehouse_name}}" name="inv_warehouse" class="form-control" type="text" placeholder="Delivery Status" readonly>
												</div>
											</div>
																						
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_note">QB Invoice</label>
													<input id="inv_binltr" data-required="1" value="{{$inventories->inv_qb}}"   name="inv_binltr" class="form-control" type="text" placeholder="QB" readonly>
												</div>										
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_note">Notes</label>
													<textarea id="inv_note"  name="inv_note" data-provide="markdown" rows="3" class="form-control">{{htmlspecialchars($inventories->inv_note, ENT_QUOTES)}}</textarea>
												</div>										
											</div>	


										</div>
										<div style="clear:both"></div>											
									</div>
									<div class="form-actions right">
										
							
									</div>
								</from>
						</div>
							
						</div>
						</div>
						</div>	


			<div class="row">
				<div class="col-md-12">

					<div class="portlet box blue">
						<div class="portlet-title">
							<div id="modatTitle" class="caption"><i class="fa fa-reorder"></i> Inventory Images</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="foto_box" id="image">	
								@if($incentoryImages)	
									@foreach($incentoryImages as $incentoryImage)
										@if($incentoryImage->img_name !='')
										<img style="margin:5px; width:200px; height:150px;" src="../without-flash-uploader/images/{{$incentoryImage->img_name}}"/>
										@endif
									@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">

					<div class="portlet box blue">
						<div class="portlet-title">
							<div id="modatTitle" class="caption"><i class="fa fa-reorder"></i> Qr Code</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">	
							<div id="qrContainer" class="col-md-6" style="border:1ps solid #999; min-height:150px;">
								@if($inventories->inv_qrcode!='')
								<img src="../{{$inventories->inv_qrcode}}" width="200" height="200" alt="QR CODE">
								@endif
							</div>	
							<div class="col-md-6" style="margin-top:25px">
							</div>								
						</div>
					</div>
				</div>
			</div>	
		<!-- /.modal -->


			<!-- /.modal -->
		<div id="responsiveEmail" data-backdrop="static" class="modal fade" tabindex="-1" aria-hidden="true">
			<div id="designerModal" class="modal-dialog">
				<div class="modal-content">
					<form action="#" id="form_email_send" class="form-horizontal">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 id="modatTitle" class="modal-title">Email</h4>
					</div>
					<div class="modal-body">
						
								<div class="col-md-12 scrollFlug">
									<div class="form-body">
									<div class="row">
										<div id="erAlert" class="alert alert-danger display-hide">
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
													<label  class="control-label" for="fromEmail">From<span class="required">*</span></label>
													<div class="input-group">
																<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
																<input class="form-control" name="fromEmail" id="fromEmail" type="email" placeholder="Email Address">
															</div>				
											     </div>
											</div>
											
											<div class="col-md-6">
												<div class="form-group">
												<label  class="control-label" for="toEmail">To<span class="required">*</span></label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
													<input class="form-control" name="toEmail" id="toEmail" type="email" placeholder="Email Address">
												</div>
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label class="control-label">Message</label>
													<textarea class="form-control" id="eMessage" name="eMessage" rows="12"></textarea>	
												</div>
											</div>
										</div>
										<i>Inventory Information And the Images will be automatically added to email body.</i>
													

										

										<input type="hidden" name="invId" id="invId" value="{{$inventories->id}}">									
										<input type="hidden" name="rowPos" id="rowPos" value="">									
									</div>
								</div>
							
						
					</div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn default">Close</button>
						<button type="submit" class="btn blue" id="btnSendEmail"><i class="fa fa-check"></i>Send Email</button>
					</div>
				</form>
				</div>
			</div>
		</div>
	
		<!-- /.modal -->	<img src="" alt="">
	
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/adminjs/Jobiventory.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop