@extends('layouts.designer')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
{{ HTML::style('includes/assets/plugins/fancybox/source/jquery.fancybox.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<div class="row" >
						<div class=" col-md-4">
						<h3 class="page-title">Job Details</h3>
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
										<div class="tools">
											<a href="javascript:;" class="collapse"></a>
											<a href="#portlet-config" data-toggle="modal" class="config"></a>
											<a href="javascript:;" class="reload"></a>
											<a href="javascript:;" class="remove"></a>
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
							<div class="actions">
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
										<th>ID</th>
										<th>Image</th>
										<th>Purchase Order</th>
										<th>Description</th>
										<th>Room</th>
										<th>Manufacturer</th>
										<th>Mfg #</th>
										<th>Category </th>
										<th>Status</th>
										<th>QR Code</th>
										<th>Notes</th>
										<th>Action</th>
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
										<td><a href="{{ URL::to('/details-inventory/'.$inventory->id)  }}"><b>{{ $inventory->id }}</b></a></td>
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
										<td> @if($inventory->inv_qrcode!='')<img width="50" height="50" src="{{ URL::asset($inventory->inv_qrcode) }}" alt="">@endif</td>
										<td>{{ $inventory->inv_note }}</td>
										<td>
											<!-- <a href ='javaScript:void(0)'  class="btn mini blue" alt="Edit"><i class="fa fa-edit"></i></a> -->
											<a class="btn btn-xs blue btn-editable" data-id="1" id="edit_{{$inventory->id}}" href="{{ URL::to('/details-inventory/'.$inventory->id)  }}"><i class="fa fa-pencil"></i> View Details</a>
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
														<option value="">Select Designer Name</option>
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
														<input type="text" id="inv_received" name="inv_received" class="form-control" style="width:100%" readonly>
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
													<input id="inv_quantity" data-required="1"  name="inv_quantity" class="form-control" type="text" placeholder="Quantity">
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
													<input id="inv_storage_price" data-required="1"  name="inv_storage_price" class="form-control" type="text" placeholder="Storage Price">                
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