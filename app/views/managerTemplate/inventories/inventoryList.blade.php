@extends('layouts.manager')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
{{ HTML::style('includes/assets/plugins/fancybox/source/jquery.fancybox.css') }}

<style media="print">
  .page-title,.breadcrumb,.portlet-title,.form-actions,#jobform,#putResults,#searchFrom,.footer{ display: none; }
  #qrContainer{ display: block !important; }
 .control-label{width: 200px; float: left;}
 .form-control{width: 200px; float: left; border:none }
</style>


<!-- BEGIN PAGE HEADER-->
<div class="row">
<div class="col-md-12">
<!-- BEGIN PAGE TITLE & BREADCRUMB-->
<h3 class="page-title">Inventory List</h3>
<ul class="page-breadcrumb breadcrumb">
<li>
	<i class="fa fa-home"></i>
	{{ HTML::link('/admin/dashboard', 'Dashboard') }} 
	<i class="fa fa-angle-right"></i>
</li>

<li>
	<a href="javaScript:void(0);">Inventory List</a>
	<i class="fa fa-angle-right"></i>
</li>
<li><button onclick="window.history.back()">Go Back</button></li>						
</ul>
<!-- END PAGE TITLE & BREADCRUMB-->
</div>
</div>
<!-- END PAGE HEADER-->

<div id="searchFrom" class="row">
<div class="col-md-12">

<div class="portlet box blue">
<div class="portlet-title">
	<div id="topFlug" class="caption"><i class="fa fa-globe"></i> Inventory</div>
	<div class="actions">
		<button type="button" id="btnAddUser" class="btn blue"><i class="fa fa-plus"></i> Add New</button>
		<!--<a class="btn default" data-toggle="modal" href="#responsive">View Demo</a>-->
	</div>
</div>
<div class="portlet-body form">

<div class="col-md-3">
	<div class="form-group">
		<label class="control-label" for="jobSearch">Job Name</label>
		<select  data-filter="true" class="form-control input-medium filterInv" id="jobSearch"  name="jobSearch">
				<option value="">All Jobs</option>
				
				@foreach($searchJob as $job)
				<option value="{{$job->id}}">{{ $job->job_name }}</option>
				@endforeach
				
		</select>													
	</div>
</div>	


<div class="col-md-3">
	<div class="form-group">
		<label class="control-label" for="inv_categorySearch">Category</label>
		<select class="form-control filterInv" id="inv_categorySearch"  name="inv_categorySearch">
			<option value="">Select Category</option>
			@if($inventorycategories)
			@foreach($inventorycategories as $inventorycategory)
				<option value="{{$inventorycategory->id}}">{{$inventorycategory->invcat_name}}</option>
			@endforeach
			@endif
		</select>													
	</div>
</div>	


<div class="col-md-3">
	<div class="form-group">
		<label class="control-label" for="inv_roomSearch">Area</label>
		<select  class="form-control filterInv" id="inv_roomSearch"  name="inv_roomSearch">
			<option value="">Select Area  </option>
			@if($rooms)
				@foreach($rooms as $room)
					<option value="{{$room->id}}">{{$room->room_name}}</option>
				@endforeach
			@endif
		</select>													
	</div>
</div>							
		
<div class="col-md-3">
	<div class="form-group">
		<label class="control-label" for="inv_item_statusSearch">Status</label>
		<select  data-filter="true" class="form-control input-medium filterInv" id="inv_item_statusSearch"  name="inv_item_status">
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
		<label class="control-label" for="inv_item_statusSearch">ID# / PO#</label>
		<input id="inv_idPo" data-required="1"  name="inv_idPo" class="form-control" type="text" placeholder="Inventory ID Or PO Box number">												
	</div>
</div>	

<div class="col-md-4">
	<div class="row">
		<div class="col-md-6">	
			<div class="form-group">
				<label class="control-label" for="inv_item_statusSearch">Sort By</label>
				<select  data-filter="true" class="form-control input-small filterInv" id="inv_sort"  name="inv_sort">
						<option value="">Select </option>
						<option value="inventories.id">ID</option>
						<option value="inventories.inv_pono">PO#</option>
						<option value="itemdescriptions.itds_name">Description</option>
						<option value="manufacturers.manuf_name">Manufacturer</option>
						<option value="rooms.room_name">Room</option>
						<option value="inventory_category.invcat_name">Category</option>
				</select>													
			</div>
		</div>
		<div class="col-md-6">	
			<div class="form-group">
				<label class="control-label" for="inv_item_statusSearch">Order By</label>
				<select  data-filter="true" style="width: 127px !important;" class="form-control input-small filterInv" id="inv_sort_by"  name="inv_sort_by">
						<option value="asc">Ascending</option>
						<option value="desc">Descending</option>
				</select>													
			</div>
		</div>	
	</div>
</div>

<div class="col-md-4">	
		<button style="margin-top:27px;" type="submit" id="btnSearch" class="btn blue"><i class="fa fa-search"></i> Search</button>
		<button style="margin-top:27px;" type="button" id="btnResetSearch" class="btn red"><i class="fa fa-check"></i> Reset</button>
</div>																																			
<!-- END PAGE TITLE & BREADCRUMB-->
<div style="clear:both"></div>
<input type="hidden" name="linkLoad" id="linkLoad" value="{{route('search-inventory-manager')}}">
<input type="hidden" name="editingID" id="editingID" value="">


	<div id="putResults">

	</div> <!-- end of put results -->
	
</div>
	
</div>
</div>
</div>	

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
							<label class="control-label" for="firm_id">Clients <span class="required">*</span></label>
							<select  data-filter="true" class="form-control input-medium" id="firm_id"  name="firm_id">
									<option value="">Select Clients</option> 
								@if($clients)
									@foreach($clients as $client)
										<option value="{{$client->id}}">{{$client->firm_name}} </option>
									@endforeach
								@endif
							</select>													
						</div>
					</div>										
			</div>	
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label" for="job_id">Job Name</label>
							<!-- <input id="job_name" data-required="1" value=""  name="job_name" class="form-control" type="text" placeholder="Job Name" readonly> -->	
							<select  data-filter="true" class="form-control input-medium" id="job_id"  name="job_id">
									<option value="">Select Job Name</option> 
								
							</select>											
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
							<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" >
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
							<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" >
								<input type="text" id="inv_delivered" name="inv_delivered" class="form-control"  style="width:100%" readonly>
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
										<option value="{{$storagePrice->id}}">{{$storagePrice->price}}</option>
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
				
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label" for="inv_qb">QB Invoice</label>
							<input id="inv_qb" data-required="1"  name="inv_qb" class="form-control" type="text" placeholder="QB">
						</div>										
					</div>

					


					<div class="col-md-6">
						<div class="form-group">

								<label class="control-label" for=""></label>
		                        <center>
		                            <div style="margin-top: 10px; position: relative; z-index: 50;">
		                                <img id="loading" src="../without-flash-uploader/loading.gif" style="display:none;">
		                                <script>
		                                    var upload_button_name  = 'Upload Image';
		                                </script>
		                            </div>
		                        </center> 

		                        <link href="../without-flash-uploader/fileuploader.css" rel="stylesheet" type="text/css">      
		                        <style>
		                            .qq-upload-list li{display:none;}
		                        </style>
		                        <div id="file-uploader-demo1"></div>  
		                         
		                        <script src="../without-flash-uploader/fileuploader.js" type="text/javascript"></script>
		                        <script>        
		                            function createUploader(){  
		                                var img_job_id =$('#job_id').val(); 
		                                var imgNameVal = $('#show_image_name').val();

		                                var uploader = new qq.FileUploader({   
		                                    element: document.getElementById('file-uploader-demo1'), 
		                                    onProgress: function(id, fileName, loaded, total){$('#loading').show();},
		                                    onComplete: function(id, fileName, responseJSON)
		                                    { 
		                                        var restImage = parseInt($('#reset_image_Flug').val());
		                                        filenameServer = ''+responseJSON['filename']+''; 
		                                        if(restImage==0){
		                                        	imgNameVal = filenameServer+',';
		                                        }
		                                        else{
		                                        imgNameVal = imgNameVal+filenameServer+',';	
		                                        }
		                                           
		                                        $('#show_image_name').val(imgNameVal);
		                                        $('#loading').hide();
		                                        $('#reset_image_Flug').val(1);
		                                        $("#image").append($(document.createElement("img")).attr({src:"../without-flash-uploader/images/"+filenameServer,id:"jcrop",height: 150, width: 200, style:"margin:5px;"})).show();                
		                                    },
		                                    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
		                                     params: {
										            param1: img_job_id
										        },
		                                    action: '../without-flash-uploader/php_profile.php'
		                                });           
		                            } 
		                            window.onload = createUploader;       
		                        </script>  

		                        <div class="clear"></div>
		                        <br/>
		                        <div id="upload">
		                            <input type="hidden" class="normal_input2" name="profile_image" value="" id="show_image_name"/>
		                            <input type="hidden" class="normal_input2" name="reset_image_Flug" value="0" id="reset_image_Flug"/>
		                        </div>

							
						</div>										
					</div>


				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label" for="inv_note">Notes</label>
							<textarea id="inv_note"  name="inv_note" data-provide="markdown" rows="3" class="form-control"></textarea>
						</div>	
					</div>	
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label" for="inv_note">Private Notes</label>
							<textarea id="inv_private_note"  name="inv_private_note" data-provide="markdown" rows="3" class="form-control"></textarea>
						</div>	
					</div>									
				</div>
				<div style="clear:both"></div>
				<input type="hidden" name="id" id="did" value="">									
				<input type="hidden" name="rowPos" id="rowPos" value="">									
				
				<input type="hidden" name="editUrl" id="editUrl" value="{{ URL::to('/admin/inventory-details/')  }}">									
			</div>
			<div class="form-actions right">
				<button type="button" id="jobCancel" class="btn default">Cancel</button>
				<button type="submit" id="btnSave" class="btn blue"><i class="fa fa-check"></i> Save</button>
				<button type="button" id="btnClear" class="btn red"><i class="fa fa-check"></i> Clear</button>
			</div>
		</from>
</div>
<div class="foto_box" id="image"></div>				                        					
</div>
</div>
</div>	

<!-- /.modal -->
<div id="printContainer" style="display:none;" class="row">
	<div class="portlet box green">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-reorder"></i>Print QR Code</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body form">
				<!-- BEGIN FORM-->
				<form action="#" class="form-horizontal">
					<div class="form-body">
						<div id="printContainer" class="row">
							<div id="qrContainer" style="width:200px;" class="pull-left"></div>
							<div style="width:270px; margin: 10px; font-size: 17px;" class="pull-left">
								<b>#<span id="qrinvID"></span></b> <br/>
							 	<b><span id="qrdesigner_FullName"></span></b> <br/>
							 	<b><span id="qrjobs_name"></span></b><br/>
							 	<b> <span id="qrDec"></span></b><br/>
							 	<b><span id="qrRoom"></span></b><br/>
							</div>
						</div>						
					</div>
					<div class="form-actions fluid">
						<div class="col-md-offset-3 col-md-9">
						    <button type="button" onClick="window.print()" id="printPage" class="btn green"><i class="fa fa-print"></i> Print QR</button>
							<button type="button" id="showForm" class="btn default">Cancel</button>                              
						</div>
					</div>
				</form>
				<!-- END FORM--> 
			</div>
	</div>	
</div>


{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/ManagerInventoryList.js') }}
{{ HTML::script('includes/assets/plugins/fancybox/source/jquery.fancybox.pack.js') }} 
	<script>
		jQuery(document).ready(function() {       
		   //TableManaged.init();
		   $('.pagination').css('visibility', 'visible');
		   $('#sample_2_paginate').css('visibility', 'hidden');
		});
	</script>			
@stop