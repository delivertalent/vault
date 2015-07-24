<select id="editInline" name="editInline">
@if($inventorycategoryes)
	@foreach($inventorycategoryes as $inventorycategory)
		<option value="{{$inventorycategory->id}}">{{$inventorycategory->invcat_name}}</option>
	@endforeach
@else
<option value="">No Category is Found!!</option>
@endif
</select>