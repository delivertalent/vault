<select id="editInline" name="editInline">
@if($rooms)
	@foreach($rooms as $room)
		<option value="{{$room->id}}">{{$room->room_name}}</option>
	@endforeach
@else
<option value="">No Room is Found!!</option>
@endif
</select>