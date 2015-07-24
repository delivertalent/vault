	@if($inventories)
	@foreach($inventories as $inventory)
	<div class="invJobs_{{$inventory->job_id}}  jobCalss col-md-3 col-sm-4 mix category_1" style="display:block; opacity:100">
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
	@else
	<h4 style="color:red; text-align: center;"><b>No Items  Found!</b></h4>
	@endif