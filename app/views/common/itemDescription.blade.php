<select id="editInline" name="editInline">
@if($itemdescriptions)
	@foreach($itemdescriptions as $itemdescription)
		<option value="{{$itemdescription->id}}">{{$itemdescription->itds_name}}</option>
	@endforeach
@else
<option value="">No Description is Found!!</option>
@endif
</select>