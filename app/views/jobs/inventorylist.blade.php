@extends('layouts.designer')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/fancybox/source/jquery.fancybox.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<div class="row" >
						<div class=" col-md-4">
						<h3 class="page-title">{{$title}}</h3>
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
							<a href="javaScript:void(0);">{{$title}}</a>
							<i class="fa fa-angle-right"></i>
						</li>						
					</ul>

					@if(isset($viewSearch) && $viewSearch=='yes')
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label" for="inv_delivery_status">Job Name</label>
								<select  data-filter="true" class="form-control input-medium filterInv" id="jobSearch"  name="jobSearch">
										<option value="">All Jobs</option>
										
										@foreach($jobs as $job)
										<option value="{{$job->id}}">{{ $job->job_name }}</option>
										@endforeach
										
								</select>													
							</div>
						</div>	


						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label" for="inv_delivery_status">Category</label>
								<select class="form-control filterInv" id="inv_category"  name="inv_category">
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
								<label class="control-label" for="inv_delivery_status">Area</label>
								<select  class="form-control filterInv" id="inv_room"  name="inv_room">
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
								<label class="control-label" for="inv_delivery_status">Status</label>
								<select  data-filter="true" class="form-control input-medium filterInv" id="inv_item_status"  name="inv_item_status">
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
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
				@endif
			</div>
			<!-- <div class="row">
							<div class="col-md-12">
								<button type="submit" class="btn green" id="btnSave">Search</button>
							</div>
						</div> -->			
			<hr/>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div id="putResults" class="row mix-grid">
						@if($inventories)
						@foreach($inventories as $inventory)
						<div class="invJobs_{{$inventory->job_id}}  jobCalss col-md-3 col-sm-4 mix category_1">
							<div class="mix-inner" style="width:247px; height:187px;">
								@if($inventory->inv_item_images!='')
								<img class="img-responsive" src="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" alt="">
								@else
								<img class="img-responsive" src="{{ URL::asset('without-flash-uploader/images/noImage.jpg') }}" alt="No Image">
								@endif
								<div class="mix-details">
									<h4>{{$inventory->itds_name}}</h4>
									<a href="{{ URL::to('/details-inventory/'.$inventory->id)  }}" class="mix-link"><i class="fa fa-link"></i></a>
									@if($inventory->inv_item_images!='')
									<a class="mix-preview fancybox-button" href="{{ URL::asset('without-flash-uploader/images/'.$inventory->inv_item_images) }}" title="Inventory Id: {{$inventory->id}}" data-rel="fancybox-button"><i class="fa fa-search"></i></a>
									@endif
								</div>
							</div>
						</div>
						@endforeach
						@endif

					</div>
				</div>
			</div>


						<!-- END DASHBOARD BOXES-->
{{ HTML::script('includes/assets/plugins/jquery-mixitup/jquery.mixitup.min.js') }}
{{ HTML::script('includes/assets/plugins/fancybox/source/jquery.fancybox.pack.js') }}
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
 
{{ HTML::script('includes/js/Home.js') }}
	<script>
		jQuery(document).ready(function() {       
		   Portfolio.init();
		});
	</script>			
@stop