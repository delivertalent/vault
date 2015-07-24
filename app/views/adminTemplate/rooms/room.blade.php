@extends('layouts.master')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Room</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							{{ HTML::link('/admin/dashboard', 'Dashboard') }} 
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<i class="fa fa-cogs"></i>
							<a href="javaScript:void(0);">Configuration</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="javaScript:void(0);">Room</a>
							<i class="fa fa-angle-right"></i>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box green ">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-globe"></i>Manage Rooms</div>
							<div class="actions">
								<button type="button" id="btnAddUser" class="btn blue"><i class="fa fa-plus"></i> Add New</button>
								<!--<a class="btn default" data-toggle="modal" href="#responsive">View Demo</a>-->
							</div>
						</div>
						<div class="portlet-body">
							<!--<div class="table-toolbar">
								<div class="btn-group">
									<button id="sample_editable_1_new" class="btn green">
									Add New <i class="fa fa-plus"></i>
									</button>
								</div>
							</div>-->
							<table class="table table-striped table-bordered table-hover" id="sample_2">
								<thead>
									<tr>
										<th>ID</th>
										<th>Rooms</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($rooms as $room)
									<tr class="odd gradeX">
										<td>{{ $room->id }}</td>
										<td>{{ $room->room_name }}</td>
										<td>
											<!-- <a href ='javaScript:void(0)'  class="btn mini blue" alt="Edit"><i class="fa fa-edit"></i></a> -->
											<a class="btn btn-xs blue btn-editable edit" data-id="1" id="edit_{{$room->id}}" href="javaScript:void(0);"><i class="fa fa-pencil"></i>Edit</a>
											<a class="btn btn-xs red btn-removable del" data-id="1" id="del_{{$room->id}}" href="javaScript:void(0);"><i class="fa fa-times"></i>Delete</a>
										</td>
									</tr>		
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->


	<!-- /.modal -->
		<div id="responsive" data-backdrop="static" class="modal fade" tabindex="-1" aria-hidden="true">
			<div id="designerModal" class="modal-dialog">
				<div class="modal-content">
					<form action="#" id="form_sample_2" class="form-horizontal">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 id="modatTitle" class="modal-title">Add Rooms</h4>
					</div>
					<div class="modal-body">
						
								<div class="col-md-12 scrollFlug">
									<div class="form-body">
										<div class="row">
												<div class="alert alert-danger display-hide">
													<button class="close" data-close="alert"></button>
													You have some form errors. Please check below.
												</div>
												<div class="alert alert-success display-hide">
													<button class="close" data-close="alert"></button>
													Your form validation is successful!
												</div> 
										</div> 
										<div class="row">
											<div class="form-group col-md-11">
												<label class="control-label" for="room_name">Room<span class="required">*</span></label>
												<input id="room_name" data-required="1"  name="room_name" class="form-control" type="text" placeholder="Room">
											</div>
										</div>
										<input type="hidden" name="id" id="did" value="">									
										<input type="hidden" name="rowPos" id="rowPos" value="">									
									</div>
								</div>
							
						
					</div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn default">Close</button>
						<button type="submit" class="btn green" id="btnSave">Save</button>
					</div>
				</form>
				</div>
			</div>
		</div>
	
		<!-- /.modal -->
	
{{ HTML::script('includes/assets/plugins/select2/select2.min.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/jquery.dataTables.js') }}
{{ HTML::script('includes/assets/plugins/data-tables/DT_bootstrap.js') }}
{{ HTML::script('includes/js/adminjs/Room.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop