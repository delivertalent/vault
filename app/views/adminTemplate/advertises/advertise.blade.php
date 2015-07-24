@extends('layouts.master')
@section('content')
{{ HTML::style('includes/assets/plugins/select2/select2_metro.css') }}
{{ HTML::style('includes/assets/plugins/data-tables/DT_bootstrap.css') }}


			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">Advertise</h3>
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
							<a href="javaScript:void(0);">Advertise</a>
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
							<div class="caption"><i class="fa fa-globe"></i>Manage Advertise</div>
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
										<th>Advertise Images</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($advertises as $advertise)
									<tr class="odd gradeX">
										<td><img width="530" height="70" src="{{ URL::asset('without-flash-uploader/images_ad/thumb/'.$advertise->advertise_image) }}" alt=""></td>
										<td>
											<!-- <a href ='javaScript:void(0)'  class="btn mini blue" alt="Edit"><i class="fa fa-edit"></i></a> -->
											<a class="btn btn-xs red btn-removable del" data-id="1" id="del_{{$advertise->id}}" href="javaScript:void(0);"><i class="fa fa-times"></i>Delete</a>
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
						<h4 id="modatTitle" class="modal-title">Add Advertise Imames</h4>
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
<div class="form-group">

														<label class="control-label" for=""></label>
								                        <center>
								                            <div style="margin-top: 10px; position: relative; z-index: 50;">
								                                <img id="loading" src="../without-flash-uploader/loading.gif" style="display:none;">
								                                <script>
								                                    var upload_button_name  = 'Upload Advertise';
								                                </script>
								                            </div>

								                        </center> 
														
								                        <link href="../without-flash-uploader/fileuploader.css" rel="stylesheet" type="text/css">      
								                        <style>
								                            .qq-upload-list li{display:none;}
								                        </style>
								                        <div id="file-uploader-demo1"></div>  
								                         
								                        <script src="../without-flash-uploader/fileuploader_ad.js" type="text/javascript"></script>
								                        <script>        
								                            function createUploader(){  
								                                var img_job_id =555; 
								                                var imgNameVal = $('#advertise_image').val();

								                                var uploader = new qq.FileUploader({   
								                                    element: document.getElementById('file-uploader-demo1'), 
								                                    onProgress: function(id, fileName, loaded, total){$('#loading').show();},
								                                    onComplete: function(id, fileName, responseJSON)
								                                    { 
								                                        filenameServer = ''+responseJSON['filename']+''; 
								                                        imgNameVal = imgNameVal+filenameServer+',';   
								                                        $('#advertise_image').val(responseJSON['filename']);
								                                        $('#loading').hide();
								                                        $("#image").append($(document.createElement("img")).attr({src:"../without-flash-uploader/images_ad/thumb/"+filenameServer,id:"jcrop",height: 70, width: 530, style:"margin:5px;"})).show();                
								                                    },
								                                    allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
								                                     params: {
																            param1: img_job_id
																        },
								                                    action: '../without-flash-uploader/php_advertise.php'
								                                });           
								                            } 
								                            window.onload = createUploader;       
								                        </script>  

								                        <div class="clear"></div>
								                        <small>Image size should be 530px X 70px</small>
								                        <br/>
								                        <div id="upload">
								                            <input type="hidden" class="normal_input2" name="advertise_image" value="" id="advertise_image"/>
								                        </div>

								                        <div class="foto_box" id="image"></div>	
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
{{ HTML::script('includes/js/adminjs/Advertise.js') }}
	<script>
		jQuery(document).ready(function() {       
		   TableManaged.init();
		});
	</script>			
@stop