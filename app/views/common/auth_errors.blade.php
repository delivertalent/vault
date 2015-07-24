@if($errors->has())
<div class="row">
	<div class="col-md-12">
		<div class="alert alert-error">
			<p>
				<ul>
				  {{ $errors->first('userid', '<li>:message</li>') }}
				  {{ $errors->first('email', '<li>:message</li>') }}
				  {{ $errors->first('password', '<li>:message</li>') }}
				</ul>
			</p>
		</div>
	</div>
</div>
@endif