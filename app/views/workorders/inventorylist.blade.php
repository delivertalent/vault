<table class="table table-bordered table-striped table-condensed flip-content" id="tdEmergencyData" data-set="#tdEmergencyData .checkboxes">
	<thead>
		<tr>
			<th class="table-checkbox"><input type="checkbox" name="selector[]" id="selectALL" class="" value="" />Select</th>
			<th>Ids</th>
			<th>Image</th>
			<th>PO#</th>
			<th>Description</th>
			<th>Room</th>
			<th>Manufacturer</th>
			<th>Mfg #</th>
			<th>Category </th>
			<th>Status</th>
			<th>QR Code</th>
			<th>Notes</th>
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
				<td><input type="checkbox" name="selector[]" class="checkboxes" value="{{ $inventory->id }}" /></td>
				<td>{{ $inventory->id }}</td>
				<td> @if($inventory->inv_item_images!='')<img width="50" height="50" src="{{ URL::asset('without-flash-uploader/images/thumb/'.$inventory->inv_item_images) }}" alt="">@endif</td>
				<td>{{ $inventory->inv_pono }}</td>
				<td>{{ $inventory->itds_name }}</td>
				<td>{{ $inventory->room_name }}</td>
				<td>{{ $inventory->manuf_name }}</td>
				<td>{{ $inventory->inv_mfg }}</td>
				<td>{{ $inventory->invcat_name }}</td>
				<td>{{ $status }}</td>
				<td> @if($inventory->inv_qrcode!='')<img width="50" height="50" src="{{ URL::asset($inventory->inv_qrcode) }}" alt="">@endif</td>
				<td>{{ $inventory->inv_note }}</td>
			</tr>		
			@endforeach
		@endif

	</tbody>
</table>
