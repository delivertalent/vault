@if($jobs)
	<option value="">Select Job Name</option>
	@foreach($jobs as $job)
		<option value="{{$job->id}}">{{$job->job_name}}</option>
	@endforeach
@else
	<option value="">No job Found</option>
@endif