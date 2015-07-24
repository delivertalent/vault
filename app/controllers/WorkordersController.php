<?php

class WorkordersController extends BaseController {


	public function workorders()
	{
		if (Auth::check()){
			$designerID=Auth::user()->id;
			$title = "Work Orders";
			$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();
			$workorders = DB::table('workorders')->select('workorders.*','jobs.job_name')
									->leftJoin('jobs', 'jobs.id', '=', 'workorders.wo_jobid')
									->where('wo_firmid', $designerID)
									->orderBy('workorders.id', 'desc')
									->where('workorders.wo_status', '!=', 5)
									->get();


			$jobs = DB::table('jobs')->select('jobs.id','jobs.job_name')
							->where('job_client_id', $designerID)->orderBy('id', 'desc')->get();

			$rooms = DB::table('rooms')->get();	
			$inventorycategories = DB::table('inventory_category')->get();
							
			$view = View::make('workorders.index')
				  ->with('menu', 'workorders')
				  ->with('submenu', '')		
				  ->with('advImage', $advImage)		
				  ->with('workorders', $workorders)		
				  ->with('jobs', $jobs)		
				  ->with('rooms', $rooms)		
				  ->with('inventorycategories', $inventorycategories)		
			      -> with('title',$title);
			return $view;
		}
	}

public function workordersForm(){
		if (Auth::check()){
			$designerID=Auth::user()->id;
			$title = "Work Orders";
			$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();
			$workorders = DB::table('workorders')->select('workorders.*','jobs.job_name')
									->leftJoin('jobs', 'jobs.id', '=', 'workorders.wo_jobid')
									->where('wo_firmid', $designerID)
									->orderBy('workorders.id', 'desc')
									->where('workorders.wo_status', '!=', 5)
									->get();


			$jobs = DB::table('jobs')->select('jobs.id','jobs.job_name')
							->where('job_client_id', $designerID)->orderBy('id', 'desc')->get();

			$rooms = DB::table('rooms')->get();	
			$inventorycategories = DB::table('inventory_category')->get();
							
			$view = View::make('workorders.indexform')
				  ->with('menu', 'workorders')
				  ->with('submenu', '')		
				  ->with('advImage', $advImage)		
				  ->with('workorders', $workorders)		
				  ->with('jobs', $jobs)		
				  ->with('rooms', $rooms)		
				  ->with('inventorycategories', $inventorycategories)		
			      -> with('title',$title);
			return $view;
		}
}

	public function inventorylist(){
			$jobid=Input::get('id');
			$inv_category = Input::get('inv_category');
			$inv_room = Input::get('inv_room');
			$inv_item_status = Input::get('inv_item_status');


			$query = DB::table('inventories')->select('inventories.id',
								    'inventories.inv_pono',
								    'inventories.inv_mfg',
								    'inventories.inv_item_status',
								    'inventories.inv_item_images',
								    'inventories.inv_qrcode',
								    'inventories.inv_note',
								    'itemdescriptions.itds_name',
								    'rooms.room_name',
								    'inventory_category.invcat_name',
								    'manufacturers.manuf_name')
							->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
							->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
							->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
							->leftJoin('manufacturers', 'manufacturers.id', '=', 'inventories.inv_manufacture')		     			
							->where('Job_id', $jobid)->where('inv_delivery_status','!=', 4)->where('inv_woid', 0);


						if (isset($inv_category) && $inv_category!='')
						    $query->where('inventories.inv_category',$inv_category);

						if (isset($inv_room) && $inv_room!='')
						    $query->where('inventories.inv_room',$inv_room);

						if (isset($inv_item_status) && $inv_item_status!='')
						    $query->where('inventories.inv_item_status',$inv_item_status);


			$inventories = 	$query->get();


			$view = View::make('workorders.inventorylist')
				  ->with('inventories', $inventories);
			return $view;	  
	}

	public function saveWorkorder(){

			$designerID=Auth::user()->id;
			if (Input::has('fromAdmin')){
			   $designerID = Input::get('wo_firmid');
			}

			$workorders = new Workorder;			
			
			$workorders->wo_jobid = Input::get('job_name');
			$workorders->wo_firmid = $designerID;
			$workorders->wo_status = 1;
			$workorders->wo_delivery_date = Input::get('wo_delivery_date');
			$workorders->wo_delivery_time = Input::get('wo_delivery_time');
			$workorders->notes = Input::get('notes');
			$workorders->wo_requests = Input::get('wo_requests');

			if($workorders->save()){
				$isertedID = $workorders->id;
				$inventories = Input::get('inventory');
				if($inventories){
					foreach ($inventories as $inventory) {
						if($inventory!=''){
							DB::table('inventories')->where('id', $inventory)->update(array('inv_woid' => $isertedID));
						}
					}
				}

				$job_name = DB::table('jobs')->where('id', Input::get('job_name'))->pluck('job_name');
				$designer_name = DB::table('users')->where('id', $designerID)->pluck('firm_name');

				//$toemail ="admin@vaultmovingandstorage.com";
				$toemail ="admin@vaultmovingandstorage.com";
				//now sending email to registered client
		    	$headers = "MIME-Version: 1.0" . "\r\n";
			    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			    $headers .= "From: admin@vaultmovingandstorage.com <admin@vaultmovingandstorage.com>" . "\r\n";
			    
			    $email_sub = "New Work Order: ".$isertedID;


		 		$email_body = "Design Firm: ".$designer_name.',<br /><br />';
				$email_body .= "Job Id: ".Input::get('job_name').'<br />';
				$email_body .= "Job Name: ".$job_name.'<br />';
				$email_body .= "Work Order ID: ".$isertedID.'<br />';
				
				$email_body .= "Please save this email for future reference.<br/><br/>";
				$email_body .= '<hr /><br /><br />';
				  
				mail($toemail,$email_sub,$email_body,$headers);				

				if (Input::has('fromAdmin')){
				   return Response::json(array('status' => 'success', 'isertedID' => $isertedID, 'job_name' => $job_name, 'designer_name' => $designer_name),200);
				}
				else{
					return Response::json(array('status' => 'success', 'isertedID' => $isertedID, 'job_name' => $job_name),200);
				}
			}
	}


	public function workorderDetails($woID){
			$title = "Work Order Details";
			$designerID=Auth::user()->id;
			$workorders = DB::table('workorders')->select('workorders.*',
								    'jobs.job_name')
							->leftJoin('jobs', 'workorders.wo_jobid', '=', 'jobs.id')
							->where('workorders.id', $woID)->where('wo_firmid', $designerID)->first();	

			$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();
			$inventories = DB::table('inventories')->select('inventories.id',
								    'inventories.inv_pono',
								    'inventories.inv_mfg',
								    'inventories.inv_item_status',
								    'inventories.inv_item_images',
								    'inventories.inv_qrcode',
								    'inventories.inv_note',
								    'inventories.inv_woid',
								    'itemdescriptions.itds_name',
								    'rooms.room_name',
								    'inventory_category.invcat_name',
								    'manufacturers.manuf_name')
							->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
							->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
							->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
							->leftJoin('manufacturers', 'manufacturers.id', '=', 'inventories.inv_manufacture')		     			
							->where('Job_id', $workorders->wo_jobid)->where('inv_woid', 0)->orWhere('inv_woid', $woID)
							->orderBy('inventories.inv_woid', 'desc')->orderBy('inventories.id', 'asc')->get();

			$view = View::make('workorders.workorderdetails')
				  ->with('menu', 'workorders')
				  ->with('submenu', '')	
				  ->with('title',$title)
				  ->with('advImage', $advImage)	
				  ->with('inventories',$inventories)
				  ->with('workorders', $workorders);
			return $view;	
	}

	public function updateWorkorder(){

			$workorders = Workorder::find(Input::get('id'));

			$workorders->wo_delivery_date = Input::get('wo_delivery_date');
			$workorders->wo_delivery_time = Input::get('wo_delivery_time');
			$workorders->notes = Input::get('notes');
			$workorders->wo_requests = Input::get('wo_requests');
			if (Input::has('fromtAdmin') || Input::has('fromtManager') ){
			$workorders->wo_status = Input::get('wo_status');	
			}

			if($workorders->save()){
				if(Input::has('fromtManager')){
					return Response::json(array('status' => 'success'),200);
				}
				else{
					$isertedID = Input::get('id');
					$inventories = Input::get('inventory');
					DB::table('inventories')->where('inv_woid', $isertedID)->update(array('inv_woid' => 0));
					if($inventories){
						foreach ($inventories as $inventory) {
							if($inventory!=''){
								DB::table('inventories')->where('id', $inventory)->update(array('inv_woid' => $isertedID));
							}
						}
					}
					return Response::json(array('status' => 'success'),200);
				}
			}
	}

	public function adminWorkorders()
	{
		if (Auth::check()){
			$title = "Work Orders";

			$workorders = DB::table('workorders')->select('workorders.*','jobs.job_name','users.firm_name')
									->leftJoin('jobs', 'jobs.id', '=', 'workorders.wo_jobid')
									->leftJoin('users', 'users.id', '=', 'workorders.wo_firmid')
									->orderBy('workorders.id', 'desc')
									->where('workorders.wo_status', '!=', 5)
									->get();

			$designers = DB::table('users')->select('id','firm_name')->where('role_id', 2)->where('status', 1)->get();					
			// $jobs = DB::table('jobs')->select('jobs.id','jobs.job_name')
			// 				->where('job_client_id', $designerID)->orderBy('id', 'desc')->get();

			$rooms = DB::table('rooms')->get();	
			$inventorycategories = DB::table('inventory_category')->get();	
							
			$view = View::make('adminTemplate.adminworkorders.index')
				  ->with('menu', 'workorders')
				  ->with('submenu', '')		
				  ->with('workorders', $workorders)			
				  ->with('designers', $designers)			
				  ->with('rooms', $rooms)			
				  ->with('inventorycategories', $inventorycategories)			
			      -> with('title',$title);
			return $view;
		}
	}



	public function adminClosedWorkorders()
	{
		if (Auth::check()){
			$title = "Closed Work Orders";

			$workorders = DB::table('workorders')->select('workorders.*','jobs.job_name','users.firm_name')
									->leftJoin('jobs', 'jobs.id', '=', 'workorders.wo_jobid')
									->leftJoin('users', 'users.id', '=', 'workorders.wo_firmid')
									->orderBy('workorders.id', 'desc')
									->where('workorders.wo_status', 5)
									->get();

			$designers = DB::table('users')->select('id','firm_name')->where('role_id', 2)->where('status', 1)->get();					
			// $jobs = DB::table('jobs')->select('jobs.id','jobs.job_name')
			// 				->where('job_client_id', $designerID)->orderBy('id', 'desc')->get();

			$rooms = DB::table('rooms')->get();	
			$inventorycategories = DB::table('inventory_category')->get();	
							
			$view = View::make('adminTemplate.adminworkorders.closedworkorder')
				  ->with('menu', 'closedWorkorders')
				  ->with('submenu', '')		
				  ->with('workorders', $workorders)			
				  ->with('designers', $designers)			
				  ->with('rooms', $rooms)			
				  ->with('inventorycategories', $inventorycategories)			
			      -> with('title',$title);
			return $view;
		}
	}


	public function adminWorkorderDetails($woID){
			$title = "Work Order Details";
			$designerID=Auth::user()->id;
			$workorders = DB::table('workorders')->select('workorders.*',
								    'jobs.job_name','users.firm_name',
								    'users.first_name','users.last_name','users.phone',
								    'jobs.job_address1','jobs.job_city', 'jobs.job_zip',
								    'us_states.state_full'
								    )
							->leftJoin('users', 'users.id', '=', 'workorders.wo_firmid')
							->leftJoin('jobs', 'workorders.wo_jobid', '=', 'jobs.id')
							->leftJoin('us_states', 'us_states.state_code', '=', 'jobs.job_state_id')
							->where('workorders.id', $woID)->first();	


			$inventories = DB::table('inventories')->select('inventories.id',
								    'inventories.inv_pono',
								    'inventories.inv_mfg',
								    'inventories.inv_item_status',
								    'inventories.inv_item_images',
								    'inventories.inv_qrcode',
								    'inventories.inv_note',
								    'inventories.inv_woid',
								    'itemdescriptions.itds_name',
								    'rooms.room_name',
								    'bins.bin_name',
								    'binlrts.binlrt_name',
								    'inventory_category.invcat_name',
								    'manufacturers.manuf_name')
							->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
							->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
							->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
							->leftJoin('manufacturers', 'manufacturers.id', '=', 'inventories.inv_manufacture')		 
							->leftJoin('bins', 'bins.id', '=', 'inventories.inv_bin')		     	
							->leftJoin('binlrts', 'binlrts.id', '=', 'inventories.inv_binltr')    			
							->where('Job_id', $workorders->wo_jobid)->where('inv_woid', $woID)->get();

			$view = View::make('adminTemplate.adminworkorders.workorderdetails')
				  ->with('menu', 'workorders')
				  ->with('submenu', '')	
				  ->with('title',$title)
				  ->with('inventories',$inventories)
				  ->with('workorders', $workorders);
			return $view;	
	}	

	public function managerWorkorders()
	{
		if (Auth::check()){
			$title = "Work Orders";

			$workorders = DB::table('workorders')->select('workorders.*','jobs.job_name','users.firm_name')
									->leftJoin('jobs', 'jobs.id', '=', 'workorders.wo_jobid')
									->leftJoin('users', 'users.id', '=', 'workorders.wo_firmid')
									->orderBy('workorders.id', 'desc')
									->where('workorders.wo_status', '!=', 5)
									->get();

			$designers = DB::table('users')->select('id','firm_name')->where('role_id', 2)->where('status', 1)->get();					
			// $jobs = DB::table('jobs')->select('jobs.id','jobs.job_name')
			// 				->where('job_client_id', $designerID)->orderBy('id', 'desc')->get();
							
			$view = View::make('managerTemplate.managerworkorders.index')
				  ->with('menu', 'workorders')
				  ->with('submenu', '')		
				  ->with('workorders', $workorders)			
				  ->with('designers', $designers)			
			      -> with('title',$title);
			return $view;
		}
	}

	public function managerWorkorderDetails($woID){
			$title = "Work Order Details";
			$designerID=Auth::user()->id;
			$workorders = DB::table('workorders')->select('workorders.*',
								    'jobs.job_name','users.firm_name',
								    'users.first_name','users.last_name','users.phone',
								    'jobs.job_address1','jobs.job_city', 'jobs.job_zip',
								    'us_states.state_full'
								    )
							->leftJoin('users', 'users.id', '=', 'workorders.wo_firmid')
							->leftJoin('jobs', 'workorders.wo_jobid', '=', 'jobs.id')
							->leftJoin('us_states', 'us_states.state_code', '=', 'jobs.job_state_id')
							->where('workorders.id', $woID)->first();	


			$inventories = DB::table('inventories')->select('inventories.id',
								    'inventories.inv_pono',
								    'inventories.inv_mfg',
								    'inventories.inv_item_status',
								    'inventories.inv_item_images',
								    'inventories.inv_qrcode',
								    'inventories.inv_note',
								    'inventories.inv_woid',
								    'inventories.inv_delivery_status',
								    'itemdescriptions.itds_name',
								    'rooms.room_name',
								    'bins.bin_name',
								    'binlrts.binlrt_name',
								    'inventory_category.invcat_name',
								    'manufacturers.manuf_name')
							->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
							->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
							->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
							->leftJoin('manufacturers', 'manufacturers.id', '=', 'inventories.inv_manufacture')		
							->leftJoin('bins', 'bins.id', '=', 'inventories.inv_bin')		     	
							->leftJoin('binlrts', 'binlrts.id', '=', 'inventories.inv_binltr')     			
							->where('Job_id', $workorders->wo_jobid)->Where('inv_woid', $woID)->get();

			$view = View::make('managerTemplate.managerworkorders.workorderdetails')
				  ->with('menu', 'workorders')
				  ->with('submenu', '')	
				  ->with('title',$title)
				  ->with('inventories',$inventories)
				  ->with('workorders', $workorders);
			return $view;	
	}	


}