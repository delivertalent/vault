@extends('layouts/default')

@section('content')

	<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					Checklist <small>copy task</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="#">Home</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Checklist</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Task</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">Copy</a>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row profile">
				<div class="col-md-12">
					@if(Session::has('message'))
			            <div class="alert alert-{{ Session::get('alertType') }}">
			                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			                <p>{{ Session::get('message') }}</p>
			            </div>
			        @endif
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i>Form :: Copy a task
							</div>
						</div>
						<div class="portlet-body form">
							<!-- BEGIN FORM-->							
							{{ Form::model($task, array('route' => 'create-new-task', 'class' => 'form-horizontal')) }}
								<div class="form-body">
									<div class="form-group">										
										{{ Form::label('checklist_id', 'Checklist Name', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">
											{{ Form::select('checklist_id', array('' => '-- Select Checklist --')+$checklist, null, array('class' => 'form-control select2me', 'readonly' => '', 'required' => 'required')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('title', 'Task Name', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::text('title', null, array('placeholder' => 'Type task name', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('start_date', 'Start Date', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											<div data-date-format="yyyy-mm-dd" class="input-group date date-picker">
												{{ Form::text('start_date', null, array('readonly' => '', 'class' => 'form-control')) }}
												<!-- <input type="text" name="datepicker" readonly="" class="form-control"> -->
												<span class="input-group-btn">
												<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('due_date', 'Due Date', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											<div data-date-format="yyyy-mm-dd" class="input-group date date-picker">
												{{ Form::text('due_date', null, array('readonly' => '', 'class' => 'form-control')) }}
												<!-- <input type="text" name="datepicker" readonly="" class="form-control"> -->
												<span class="input-group-btn">
												<button type="button" class="btn default"><i class="fa fa-calendar"></i></button>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('user_id', 'Assigned To', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">
											{{ Form::select('user_id', array('' => '-- Select Employee Name --')+$users, null, array('class' => 'form-control select2me', 'required' => 'required')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('link_to_folder', 'Link To Folder', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-6">											
											{{ Form::text('link_to_folder', null, array('rows' => '3','placeholder' => 'Paste necessary doc links', 'required' => 'required', 'class' => 'form-control input-circle')) }}
										</div>
									</div>
									<div class="form-group">										
										{{ Form::label('description', 'Description', array('class' => 'col-md-3 control-label')) }}
										<div class="col-md-9">
											<div id="editor1_error"></div>											
											{{ Form::textarea('description', null, array('class' => 'wysihtml5 form-control', 'rows' => '6', 'data-error-container' => '#editor1_error')) }}
										</div>
									</div>
								</div>
								<div class="form-actions fluid">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-circle blue" type="submit">Copy</button>
										<button class="btn btn-circle default" type="reset">Reset</button>
									</div>
								</div>
							{{ Form::close() }}
							<!-- END FORM-->
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>

@stop