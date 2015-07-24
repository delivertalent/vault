@extends('layouts.master')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
{{ HTML::style('includes/assets/plugins/fancybox/source/jquery.fancybox.css') }}

<style media="print">
  .page-title,.breadcrumb,#jobform,#imageHolder,#qrCodeLabel,.actions,#btnPrint,.footer,#sample_2_filter,#sample_2_length,#btnAddUser,#sample_2_info,.doNotPrint{ display: none; }
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
 .portlet.box.blue{
 	border-style: none;
    border-width: 0;	
 }
div, input, select, textarea, span, img, table, td, th, p, a, button, ul, code, pre, li {
    border-radius: 0 !important;
}

a:link:after, a:visited:after {
	    content: "";
	}
</style>

			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Job Details</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/admin/dashboard', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="javaScript:void(0);">Job Details</a>
							<i class="fa fa-angle-right"></i>
						</li>	
						<li><button onclick="window.history.back()">Go Back</button></li>						
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
										<div class="caption"><i class="fa fa-reorder"></i>Job Name: {{$jobs->job_name}}</div>
										<div class="actions">
											<a id="btnPrint" onclick="window.print();" href="javaScript:void(0)" class="btn blue" type="button">
												<i class="fa fa-print"></i> Print
											</a>
										</div>
									</div>
									<div class="portlet-body form">
										<!-- BEGIN FORM-->
										<form class="form-horizontal" role="form">
											<div class="form-body">
												<h3 class="form-section">Job Info:</h3>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Cilent Name:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$jobs->firm_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Customer Name:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$jobs->customer_last_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Designer Name:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$jobs->designer_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Install Date:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$jobs->job_install_date}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->        
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">Development Name:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$jobs->job_development_name}}</p>
															</div>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label col-md-4">City:</label>
															<div class="col-md-8">
																<p class="form-control-static">{{$jobs->job_city}}</p>
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
							<div id="topFlug" class="caption"><i class="fa fa-globe"></i> Inventory List of {{$jobs->job_name}}</div>
							<div class="actions doNotPrint">
								<button type="button" id="btnAddUser" class="btn blue doNotPrint"><i class="fa fa-plus doNotPrint"></i> Add New</button>
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
										<th>Id</th>
										<th>Image</th>
										<th>Job Name</th>
										<!-- <th class="doNotPrint">Job id</th> -->
										<th>PO#</th>
										<th>Desc</th>
										<th>Room</th>
										<th>Manuf</th>
										<th>Mfg #</th>
										<th>Category </th>
										<th>Status</th>
										<th class="doNotPrint">QR Code</th>
										<th class="doNotPrint">Notes</th>
										<th class="doNotPrint">Bin</th>
										<th class="doNotPrint">Bin Ltr</th>
										<th class="doNotPrint">Delete</th>
									</tr>
								</thead>
								<tbody>
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
									<tr class="odd gradeX">
											<td><a href="{{ URL::to('/admin/inventory-details/'.$inventory->id)  }}"><b>{{ $inventory->id }}</b></a></td>
											<td> @if($inventory->inv_item_images!='')
												<a class="mix-preview fancybox-button" href="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" title="Inventory Image:{{ $inventory->id }}" data-rel="fancybox-button">
												<img width="50" height="50" src="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" alt="">
												</a>
												@endif
											</td>
											<td>{{ wordwrap($inventory->job_name, 15, "<br />\n") }}</td>
											<!-- <td class="doNotPrint">{{ $inventory->Job_id }}</td> -->
											<td>{{ $inventory->inv_pono }}</td>
											<td>{{ wordwrap($inventory->itds_name, 10, "<br />\n") }}</td>
											<td>{{ wordwrap($inventory->room_name, 10, "<br />\n") }}</td>
											<td>{{ wordwrap($inventory->manuf_name, 10, "<br />\n") }}</td>
											<td>{{ $inventory->inv_mfg }}</td>
											<td>{{ wordwrap($inventory->invcat_name, 10, "<br />\n") }}</td>
											<td>{{ wordwrap($status, 15, "<br />\n") }}</td>
											<td class="doNotPrint"> @if($inventory->inv_qrcode!='')<img width="50" height="50" src="{{ URL::asset($inventory->inv_qrcode) }}" alt="">@endif</td>
											<td class="doNotPrint">{{ wordwrap($inventory->inv_note, 15, "<br />\n") }}</td>
											<td class="doNotPrint">{{ wordwrap($inventory->bin_name, 15, "<br />\n") }}</td>
											<td class="doNotPrint">{{ wordwrap($inventory->binlrt_name, 15, "<br />\n") }}</td>
											<td><a id="del_{{$inventory->id}}" class="btn btn-xs red btn-editable delInv doNotPrint" href="javaScript:void(0)" data-id="1" title="Delete"><i class="fa fa-times"></i></a></td>
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
							<div id="modatTitle" class="caption"><i class="fa fa-reorder"></i>Add New Inventory.</div>
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
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="job_name">Job Name</label>
													<input id="job_name" data-required="1" value="{{$jobs->job_name}}"  name="job_name" class="form-control" type="text" placeholder="Job Name" readonly>												
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_description">Item Description <span class="required">*</span></label>
													<select  data-filter="true" class="form-control input-medium" id="inv_description"  name="inv_description">
															<option value="">Select Item Description</option> 
														@if($itemdescriptions)
															@foreach($itemdescriptions as $itemdescription)
																<option value="{{$itemdescription->id}}">{{$itemdescription->itds_name}} </option>
															@endforeach
														@endif
													</select>													
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label for="inv_pono" class="control-label">PO#</label>
													<input id="inv_pono" data-required="1"  name="inv_pono" class="form-control" type="text" placeholder="PO#">
												</div>
											</div>

										</div>

										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_category">Category <span class="required">*</span></label>
													<select class="form-control" id="inv_category"  name="inv_category">
														<option value="">Select Inventory Category</option>
														@if($inventorycategories)
														@foreach($inventorycategories as $inventorycategory)
															<option value="{{$inventorycategory->id}}">{{$inventorycategory->invcat_name}}</option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="inv_received" class="control-label">Date Received </label>
													<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
														<input type="text" value="{{date("Y-m-d")}}" id="inv_received" name="inv_received" class="form-control" style="width:100%" readonly>
														<span class="input-group-btn">
														<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
														</span>
													</div>                          
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">	
												<label for="inv_delivered" class="control-label">Date Delivered </label>
													<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
														<input type="text" id="inv_delivered" name="inv_delivered" class="form-control" style="width:100%" readonly>
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
													<label class="control-label" for="job_address2">Quantity</label>
													<input id="inv_quantity" data-required="1" value="1"  name="inv_quantity" class="form-control" type="text" placeholder="Quantity">
												</div>										
											</div>	
											<div class="col-md-4">
												<div class="form-group">
													<label for="inv_size" class="control-label">Size</label>
													<input id="inv_size" data-required="1"  name="inv_size" class="form-control" type="text" placeholder="Size">
												</div>	
											</div>	
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_manufacture">Manufacturer</label>
													<select  class="form-control input-medium" id="inv_manufacture"  name="inv_manufacture">
														<option value="">Select Manufacturer </option>
														@if($manufacturers)
															@foreach($manufacturers as $manufacturer)
																<option value="{{$manufacturer->id}}">{{$manufacturer->manuf_name}}</option>
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
																<option value="{{$carrier->id}}">{{$carrier->carrier_name}}</option>
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
																<option value="{{$room->id}}">{{$room->room_name}}</option>
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
																<option value="{{$storagePrice->price}}">{{$storagePrice->price}}</option>
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
													<input id="inv_mfg" data-required="1"  name="inv_mfg" class="form-control" type="text" placeholder="Mfg #">                
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_item_status">Item Status <span class="required">*</span></label>
													<select  data-filter="true" class="form-control input-medium" id="inv_item_status"  name="inv_item_status">
															<option value="">Select Status</option>
															<option value="1">Received in good condition</option>
															<option value="2">Damaged</option>
															<option value="3">Being repaired – in house</option>
															<option value="4">Being repaired – out for repair</option>
															<option value="5">Awaiting call tag / awaiting pickup</option>
															<option value="6">Picked up</option>
													</select>													
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_delivery_status">Delivery Status <span class="required">*</span></label>
													<select  data-filter="true" class="form-control input-medium" id="inv_delivery_status"  name="inv_delivery_status">
															<option value="">Select Delivery Status </option>
															<option value="1">Not yet received</option>
															<option value="2">In storage</option>
															<option value="3">Pulled / loaded</option>
															<option value="4">Delivered</option>
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
																<option value="{{$warehouse->id}}">{{$warehouse->warehouse_name}}</option>
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
													</select>                    
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label" for="inv_binltr">Bin Ltr</label>
													<select  class="form-control" id="inv_binltr"  name="inv_binltr">
														<option value="">Select Bin Ltr  </option>
													</select>               
												</div>
											</div>											

										</div>	
										<div style="clear:both"></div>
										
										<div id="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label" for="inv_note">Comments</label>
													<textarea id="inv_note"  name="inv_note" data-provide="markdown" rows="3" class="form-control"></textarea>
												</div>										
											</div>


											<div class="col-md-6">
												<div class="form-group">

														<label class="control-label" for=""></label>
								                        <center>
								                            <div style="margin-top: 10px; position: relative; z-index: 50;">
								                                <img id="loading" src="../../../without-flash-uploader/loading.gif" style="display:none;">
								                                <script>
								                                    var upload_button_name  = 'Upload Image';
								                                </script>
								                            </div>
								                        </center> 

								                        <link href="../../../without-flash-uploader/fileuploader.css" rel="stylesheet" type="text/css">      
								                        <style>
								                            .qq-upload-list li{display:none;}
								                        </style>
								                        <div id="file-uploader-demo1"></div>  
								                         
								                        <script src="../../../without-flash-uploader/fileuploader.js" type="text/javascript"></script>
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
								                                        $("#image").append($(document.createElement("img")).attr({src:"../../../without-flash-uploader/images/"+filenameServer,id:"jcrop",height: 150, width: 200, style:"margin:5px;"})).show();                
								                                    },
								                                    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
								                                     params: {
																            param1: img_job_id
																        },
								                                    action: '../../../without-flash-uploader/php_profile.php'
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
										<div style="clear:both"></div>
										<input type="hidden" name="id" id="did" value="">									
										<input type="hidden" name="rowPos" id="rowPos" value="">									
										<input type="hidden" name="firm_id" id="firm_id" value="{{$designerID}}">									
										<input type="hidden" name="job_id" id="job_id" value="{{$jobid}}">									
										<input type="hidden" name="editUrl" id="editUrl" value="{{ URL::to('/admin/inventory-details/')  }}">									
									</div>
									<div class="form-actions right">
										<button type="button" id="jobCancel" class="btn default">Cancel</button>
										<button type="submit" id="btnSave" class="btn blue"><i class="fa fa-check"></i> Save</button>
									</div>
								</from>
						</div>
						<div class="foto_box" id="image"></div>				                        					
						</div>
						</div>
						</div>	
	
		<!-- /.modal -->
	
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/adminjs/Jobiventory.js') }}
{{ HTML::script('includes/assets/plugins/fancybox/source/jquery.fancybox.pack.js') }} 
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop