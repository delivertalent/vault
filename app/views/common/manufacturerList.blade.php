<select id="editInline" name="editInline">
@if($manufacturers)
	@foreach($manufacturers as $manufacturer)
		<option value="{{$manufacturer->id}}">{{$manufacturer->manuf_name}}</option>
	@endforeach
@else
<option value="">No Manufacturer is Found!!</option>
@endif
</select>