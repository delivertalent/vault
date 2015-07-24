@extends('layouts.manager')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}
{{ HTML::style('includes/assets/plugins/fancybox/source/jquery.fancybox.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Damaged Inventory List</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('manager/manager-dashboard', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						
						<li>
							<a href="javaScript:void(0);">Damaged Inventory List</a>
							<i class="fa fa-angle-right"></i>
						</li>						
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->

			<div class="row">
				<div class="col-md-12">

					<div class="portlet box blue">
						<div class="portlet-title">
							<div id="topFlug" class="caption"><i class="fa fa-globe"></i>Damaged Inventory</div>
							<div class="actions">
								<!--<button type="button" id="btnAddUser" class="btn blue"><i class="fa fa-plus"></i> Add New</button>
								<a class="btn default" data-toggle="modal" href="#responsive">View Demo</a>-->
							</div>
						</div>
						<div class="portlet-body form">
							<table class="table table-bordered table-striped table-condensed flip-content" id="sample_2">
								<thead>
									<tr>
										<th>Id</th>
										<th>Image</th>
										<th>Job Name</th>
										<th>Job id</th>
										<th>PO#</th>
										<th>Description</th>
										<th>Room</th>
										<th>Manufacturer</th>
										<th>Mfg #</th>
										<th>Category </th>
										<th>Status</th>
										<th>QR Code</th>
										<th>Notes</th>
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
										<tr class="odd gradeX">
											<td><a href="{{ URL::to('/admin/inventory-details/'.$inventory->id)  }}"><b>{{ $inventory->id }}</b></a></td>
											<td> @if($inventory->inv_item_images!='')
												<a class="mix-preview fancybox-button" href="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" title="Inventory Image:{{ $inventory->id }}" data-rel="fancybox-button">
												<img width="50" height="50" src="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" alt="">
												</a>
												@endif
											</td>
											<td>{{ $inventory->job_name }}</td>
											<td>{{ $inventory->Job_id }}</td>
											<td>{{ $inventory->inv_pono }}</td>
											<td>{{ $inventory->itds_name }}</td>
											<td>{{ $inventory->room_name }}</td>
											<td>{{ $inventory->manuf_name }}</td>
											<td>{{ $inventory->inv_mfg }}</td>
											<td>{{ $inventory->invcat_name }}</td>
											<td>{{ $status }}</td>
											<td> @if($inventory->inv_qrcode!='')<img width="50" height="50" src="{{ URL::asset($inventory->inv_qrcode) }}" alt="">@endif</td>
											<td>{{ $inventory->inv_note }}</td>
											<td>{{ $inventory->bin_name }}</td>
											<td>{{ $inventory->binlrt_name }}</td>
										</tr>		
										@endforeach
									@endif

								</tbody>
							</table>

						</div>
							
						</div>
						</div>
						</div>	

	

{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/adminjs/InventoryList.js') }}
{{ HTML::script('includes/assets/plugins/fancybox/source/jquery.fancybox.pack.js') }} 
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop