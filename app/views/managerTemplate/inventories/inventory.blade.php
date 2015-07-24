@extends('layouts.manager')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
<style media="print">
  .page-title,.breadcrumb,#jobform,#imageHolder,#qrCodeLabel,.footer{ display: none; }
  #qrContainer{ display: block !important; }
</style>

			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Inventory Details</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/manager/manager-dashboard', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						
						<li>
							<a href="javaScript:void(0);">Inventory Details</a>
							<i class="fa fa-angle-right"></i>
						</li>						
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
										Your Inventory Update is successful!
									</div> 
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="job_name">Job Name</label>
													<div id="jobInputDiv" class="input-group">
														<input style="width:100%" id="job_name" data-required="1" value="{{$inventories->job_name}}"  name="job_name" class="form-control" type="text" placeholder="Job Name" readonly>												
														<span id="changeInvJob" style="cursor:pointer" class="input-group-addon">
															<i class="fa fa-edit"></i>
														</span>
													</div>
													<div id="jobSelectDiv" class="input-group" style="display:none">
														<select style="width:100%" data-filter="true" class="form-control" id="jobSelect"  name="jobSelectBox">
															<option value="">Select Jobs</option> 
															@if($jobs)
																@foreach($jobs as $job)
																	<option value="{{$job->id}}" @if($job->id == $inventories->job_id) selected="selected" @endif>{{$job->job_name}} </option>
																@endforeach
															@endif
														
														</select>
														<span id="updateInvJob" style="cursor:pointer; background-color:#1D943B;" class="input-group-addon">
															<i class="fa fa-check-square-o" style="color:#FFF;"></i>
														</span>
													</div>												
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_description">Item Description <span class="required">*</span></label>
													<select  data-filter="true" class="form-control input-medium" id="inv_description"  name="inv_description">
															<option value="">Select Item Description</option> 
														@if($itemdescriptions)
															@foreach($itemdescriptions as $itemdescription)
																<option value="{{$itemdescription->id}}" @if($inventories->inv_description == $itemdescription->id) selected="selected" @endif>{{$itemdescription->itds_name}} </option>
															@endforeach
														@endif
													</select>													
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label for="inv_pono" class="control-label">PO#</label>
													<input id="inv_pono" data-required="1" value="{{$inventories->inv_pono}}"  name="inv_pono" class="form-control" type="text" placeholder="PO#">
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_category">Category <span class="required">*</span></label>
													<select class="form-control" id="inv_category"  name="inv_category">
														<option value="">Select Designer Name</option>
														@if($inventorycategories)
														@foreach($inventorycategories as $inventorycategory)
															<option value="{{$inventorycategory->id}}" @if($inventories->inv_category == $inventorycategory->id) selected="selected" @endif>{{$inventorycategory->invcat_name}}</option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="inv_received" class="control-label">Date Received </label>
													<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
														<input type="text" id="inv_received" value="@if($inventories->inv_received != '0000-00-00'){{$inventories->inv_received}} @endif"  name="inv_received" class="form-control" style="width:100%" readonly>
														<span class="input-group-btn">
														<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
														</span>
													</div>                          
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">	
												<label for="inv_delivered" class="control-label">Date Delivered </label>
													<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
														<input type="text" id="inv_delivered" value="@if($inventories->inv_delivered != '0000-00-00') {{$inventories->inv_delivered}} @endif"  name="inv_delivered" class="form-control" style="width:100%" readonly>
														<span class="input-group-btn">
														<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
														</span>
													</div>
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_quantity">Quantity</label>
													<input id="inv_quantity" data-required="1" value="{{$inventories->inv_quantity}}"   name="inv_quantity" class="form-control" type="text" placeholder="Quantity">
												</div>										
											</div>	
											<div class="col-md-4">
												<div class="form-group">
													<label for="inv_size" class="control-label">Size</label>
													<input id="inv_size" data-required="1" value="{{htmlspecialchars($inventories->inv_size, ENT_QUOTES)}}"   name="inv_size" class="form-control" type="text" placeholder="Size">
												</div>	
											</div>	
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_manufacture">Manufacturer</label>
													<select  class="form-control input-medium" id="inv_manufacture"  name="inv_manufacture">
														<option value="">Select Manufacturer </option>
														@if($manufacturers)
															@foreach($manufacturers as $manufacturer)
																<option value="{{$manufacturer->id}}" @if($inventories->inv_manufacture == $manufacturer->id) selected="selected" @endif>{{$manufacturer->manuf_name}}</option>
															@endforeach
														@endif
													</select>
												</div>												
											</div>																				
										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">	
													<label class="control-label" for="inv_carrier">Carrier</label>
													<select  class="form-control" id="inv_carrier"  name="inv_carrier">
														<option value="">Select Carrier  </option>
														@if($carriers)
															@foreach($carriers as $carrier)
																<option value="{{$carrier->id}}" @if($inventories->inv_carrier == $carrier->id) selected="selected" @endif>{{$carrier->carrier_name}}</option>
															@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_room">Room</label>
													<select  class="form-control" id="inv_room"  name="inv_room">
														<option value="">Select Room  </option>
														@if($rooms)
															@foreach($rooms as $room)
																<option value="{{$room->id}}" @if($inventories->inv_room == $room->id) selected="selected" @endif>{{$room->room_name}}</option>
															@endforeach
														@endif
													</select>                    
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_storage_price">Storage Price</label>
													<select  class="form-control" id="inv_storage_price"  name="inv_storage_price">
														<option value="">Select Price  </option>
														@if($storagePrices)
															@foreach($storagePrices as $storagePrice)
																<option value="{{$storagePrice->id}}" @if($inventories->inv_storage_price == $storagePrice->id) selected="selected" @endif>{{$storagePrice->price}}</option>
															@endforeach
														@endif
													</select> 													
												</div>
											</div>											

										</div>	
										<div style="clear:both"></div>


										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_mfg">Mfg #</label>
													<input id="inv_mfg" data-required="1" value="{{$inventories->inv_mfg}}"   name="inv_mfg" class="form-control" type="text" placeholder="Mfg #">                
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_item_status">Item Status <span class="required">*</span></label>
													<select  data-filter="true" class="form-control input-medium" id="inv_item_status"  name="inv_item_status">
															<option value="">Select Status</option>
															<option value="1" @if($inventories->inv_item_status == 1) selected="selected" @endif>Received in good condition</option>
															<option value="2" @if($inventories->inv_item_status == 2) selected="selected" @endif>Damaged</option>
															<option value="3" @if($inventories->inv_item_status == 3) selected="selected" @endif>Being repaired – in house</option>
															<option value="4" @if($inventories->inv_item_status == 4) selected="selected" @endif>Being repaired – out for repair</option>
															<option value="5" @if($inventories->inv_item_status == 5) selected="selected" @endif>Awaiting call tag / awaiting pickup</option>
															<option value="6" @if($inventories->inv_item_status == 6) selected="selected" @endif>Picked up</option>
													</select>													
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_delivery_status">Delivery Status <span class="required">*</span></label>
													<select  data-filter="true" class="form-control input-medium" id="inv_delivery_status"  name="inv_delivery_status">
															<option value="">Select Delivery Status </option>
															<option value="1" @if($inventories->inv_delivery_status == 1) selected="selected" @endif>Not yet received</option>
															<option value="2" @if($inventories->inv_delivery_status == 2) selected="selected" @endif>In storage</option>
															<option value="3" @if($inventories->inv_delivery_status == 3) selected="selected" @endif>Pulled / loaded</option>
															<option value="4" @if($inventories->inv_delivery_status == 4) selected="selected" @endif>Delivered</option>
													</select>													
												</div>
											</div>											
										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">	
													<label class="control-label" for="inv_warehouse">Warehouse</label>
													<select  class="form-control" id="inv_warehouse"  name="inv_warehouse">
														<option value="">Select Warehouse  </option>
														@if($warehouses)
															@foreach($warehouses as $warehouse)
																<option value="{{$warehouse->id}}" @if($inventories->inv_warehouse == $warehouse->id) selected="selected" @endif>{{$warehouse->warehouse_name}}</option>
															@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_bin">Bin</label>
													<select  class="form-control" id="inv_bin"  name="inv_bin">
														<option value="">Select Bin  </option>
														@if($bins)
															@foreach($bins as $bin)
																<option value="{{$bin->id}}" @if($inventories->inv_bin == $bin->id) selected="selected" @endif>{{$bin->bin_name}}</option>
															@endforeach
														@endif														
													</select>                    
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_binltr">Bin Ltr</label>
													<select  class="form-control" id="inv_binltr"  name="inv_binltr">
														<option value="">Select Bin Ltr  </option>
														@if($binlrts)
															@foreach($binlrts as $binlrt)
																<option value="{{$binlrt->id}}" @if($inventories->inv_binltr == $binlrt->id) selected="selected" @endif>{{$binlrt->binlrt_name}}</option>
															@endforeach
														@endif														
													</select>               
												</div>
											</div>											

										</div>	
										<div style="clear:both"></div>
										
										<div calss="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="inv_qb">QB Invoice</label>
													<input id="inv_qb" data-required="1"  name="inv_qb" class="form-control" value="{{$inventories->inv_qb}}" type="text" placeholder="QB">
												</div>										
											</div>
											

											<div class="col-md-6">
												<div class="form-group">

													<label class="control-label" for=""></label>
								                        <center>
								                            <div style="margin-top: 10px; position: relative; z-index: 50;">
								                                <img id="loading" src="../../without-flash-uploader/loading.gif" style="display:none;">
								                                <script>
								                                    var upload_button_name  = 'Upload Image';
								                                </script>
								                            </div>
								                        </center> 

								                        <link href="../../without-flash-uploader/fileuploader.css" rel="stylesheet" type="text/css">      
								                        <style>
								                            .qq-upload-list li{display:none;}
								                        </style>
								                        <div id="file-uploader-demo1"></div>  
								                         
								                        <script src="../../without-flash-uploader/fileuploader.js" type="text/javascript"></script>
								                        <script>        
								                            function createUploader(){  
								                                var img_job_id =$('#job_id').val(); 
								                                var imgNameVal = $('#show_image_name').val();

								                                var uploader = new qq.FileUploader({   
								                                    element: document.getElementById('file-uploader-demo1'), 
								                                    onProgress: function(id, fileName, loaded, total){$('#loading').show();},
								                                    onComplete: function(id, fileName, responseJSON)
								                                    { 
								                                        filenameServer = ''+responseJSON['filename']+''; 
								                                        imgNameVal = imgNameVal+filenameServer+',';   
								                                        $('#show_image_name').val(imgNameVal);
								                                        $('#loading').hide();
								                                        $("#image").append($(document.createElement("img")).attr({src:"../../without-flash-uploader/images/"+filenameServer,id:"jcrop",height: 150, width: 200, style:"margin:5px;"})).show();                
								                                    },
								                                    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
								                                     params: {
																            param1: img_job_id
																        },
								                                    action: '../../without-flash-uploader/php_profile.php'
								                                });           
								                            } 
								                            window.onload = createUploader;       
								                        </script>  

								                        <div class="clear"></div>
								                        <br/>
								                        <div id="upload">
								                            <input type="hidden" class="normal_input2" name="profile_image" value="" id="show_image_name"/>
								                        </div>

													
												</div>										
											</div>

										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="inv_note">Notes</label>
													<textarea id="inv_note" name="inv_note"  data-provide="markdown" rows="3" class="form-control">{{htmlspecialchars($inventories->inv_note, ENT_QUOTES)}}</textarea>
												</div>	
											</div>	
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="inv_note">Private Notes</label>
													<textarea id="inv_private_note"  name="inv_private_note" data-provide="markdown" rows="3" class="form-control">{{htmlspecialchars($inventories->inv_private_note, ENT_QUOTES)}}</textarea>
												</div>	
											</div>									
										</div>
										<div style="clear:both"></div>
										<input type="hidden" name="id" id="did" value="{{$inventories->id}}">									
										<input type="hidden" name="rowPos" id="rowPos" value="">
										<input type="hidden" name="qr_firm_id" id="qr_firm_id" value="{{$inventories->firm_id}}">									
										<input type="hidden" name="qr_inv_description" id="qr_inv_description" value="{{$inventories->inv_description}}">									
										<input type="hidden" name="qr_inv_room" id="qr_inv_room" value="{{$inventories->inv_room}}">									
										<input type="hidden" name="job_id" id="job_id" value="{{$inventories->job_id}}">
										<input type="hidden" name="inv_woid" id="inv_woid" value="{{$inventories->inv_woid}}">											
										<input type="hidden" name="job_client_id" id="job_client_id" value="{{$inventories->job_client_id}}">											
									</div>
									<div class="form-actions right">
										
										<button type="submit" id="btnSave" class="btn blue"><i class="fa fa-check"></i> Save</button>
									</div>
								</from>
						</div>
							
						</div>
						</div>
						</div>	


			<div class="row" id="imageHolder">
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
										<div id="imgContainer_{{$incentoryImage->id}}" style="width:200px; float:left;">
										<img style="margin:5px; width:200px; height:150px;" src="../../without-flash-uploader/images/{{$incentoryImage->img_name}}"/>
										<span style="float:left;"><a class="removeImg" id="removeImg_{{$incentoryImage->id}}" href="javascript:void(0);">Remove </a></span>
										</div>
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
						<div id="qrCodeLabel" class="portlet-title">
							<div class="caption"><i class="fa fa-reorder"></i> Qr Code</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body form">	
							<div id="printContainer" class="col-md-8">
								<div id="qrContainer" style="width:200px;" class="pull-left">
									@if($inventories->inv_qrcode!='')
									<img src="../../{{$inventories->inv_qrcode}}" class="pull-left" width="200" height="200" alt="QR CODE">
									@endif
								</div>
								<div style="width:270px; margin: 10px; font-size: 17px;" class="pull-left">
								 <b>#{{$inventories->id}}</b></br>
								 <b>{{$designerFullname}}</b></br>
								 <b>{{$inventories->job_name}}</b></br>
								 <b><span id="qrDec">{{$inventories->itds_name}}</span></b></br>
								 <b>Room: <span id="qrRoom">{{$inventories->room_name}}</span></b></br>
								 </div>
							</div>
							<div class="col-md-4" style="margin-top:25px">
								<a class="btn red createQR" data-id="1" id="" href=""><i class="fa  fa-plus"></i> Create Qr</a>
								<a id="printBTN" @if($inventories->inv_qrcode=='') style="display:none" @endif onclick="printDiv('printContainer')" class="btn green" data-id="1" id="" href="javaScript:void(0)"><i class="fa fa-print"></i> Print QR</a>
							</div>	
															
						</div>
					</div>
				</div>
			</div>	
		<!-- /.modal -->
	
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/ManagerInventoryDetails.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop