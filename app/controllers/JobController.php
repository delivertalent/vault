<?php

class JobController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function jobList()
	{
		//
		if(Auth::check()){
			$title = "Jobs";
			$designerID=Auth::user()->id;
			$designerInfo = User::find($designerID);
			$states = DB::table('us_states')->select('state_code','state_full')->orderBy('state_full', 'asc')->get();

			$customers = DB::table('customers')->select('id','customer_first_name','customer_last_name')
												->where('customer_firm_id', $designerID)
												->orderBy('id', 'asc')->get();

			$adiDesigners = DB::table('aditional_designers')->select('id','designer_name')
														 ->where('firm_id', $designerID)
														 ->orderBy('designer_name', 'asc')->get();
			
			$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();
			$jobs = DB::table('jobs')->select('jobs.id',
								    'jobs.job_name',
								    'jobs.job_status',
								    'jobs.job_client_id',
								    'customers.customer_last_name',
								    'aditional_designers.designer_name')
							->leftJoin('customers', 'customers.id', '=', 'jobs.job_customer_id')
							->leftJoin('aditional_designers', 'aditional_designers.id', '=', 'jobs.job_designer_id')
							->where('job_client_id', $designerID)->get();


			$view = View::make('jobs.job')
				  ->with('menu', 'Jobs')
				  ->with('submenu', '')		
				  ->with('designerInfo', $designerInfo)		
				  ->with('advImage', $advImage)		
				  ->with('states', $states)		
				  ->with('jobs', $jobs)		
				  ->with('adiDesigners', $adiDesigners)		
				  ->with('customers', $customers)		
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function saveJob(){
		$designerID=Auth::user()->id;
		if(Input::get('id') == ""){
			#Add Designer information
			# Parameter List:
            #job_name, job_status, job_customer_id, job_designer_id, job_install_date, job_address1, job_address2, job_city,
            #job_state_id, job_zip, job_development_name, job_gated,job_alarm, job_condo,job_stairs , job_elevator, job_house_sqft, job_comments, 
			$job_customer_id = Input::get('job_customer_id');
			if(Input::get('job_customer_id') =='' && Input::get('customer_first_name')!='' ){
					$count = DB::table('customers')->count();
					$tdesignerID =$designerID;
					if (Input::has('job_client_id'))
					{
					 $tdesignerID = Input::get('job_client_id');
					}

					$customer_id = date('y').$tdesignerID.$count+1;

					$customer = new Customer;
					$customer->customer_firm_id = $tdesignerID;
					$customer->customer_id = $customer_id;
					$customer->customer_first_name = Input::get('customer_first_name');
					$customer->customer_last_name = Input::get('customer_last_name');
					$customer->customer_email = '-';
					$customer->customer_phone = Input::get('customer_phone');

					if($customer->save()){
						$job_customer_id  = $customer->id;
						
					}
			}

			$job = new Job;
			$job->job_client_id = $designerID;
			if (Input::has('job_client_id'))
			{
			 $job->job_client_id = Input::get('job_client_id');
			}			
			
			$job->job_name = Input::get('job_name');
			$job->job_status = Input::get('job_status');
			$job->job_customer_id = $job_customer_id;
			$job->job_designer_id = Input::get('job_designer_id');
			$job->job_install_date = Input::get('job_install_date');
			$job->job_address1 = Input::get('job_address1');
			$job->job_address2 = Input::get('job_address2');

			$job->job_city = Input::get('job_city');
			$job->job_state_id = Input::get('job_state_id');
			$job->job_zip = Input::get('job_zip');
			$job->job_development_name = Input::get('job_development_name');

			$job->job_gated = Input::get('job_gated');
			$job->job_alarm = Input::get('job_alarm');
			$job->job_condo = Input::get('job_condo');
			$job->job_stairs = Input::get('job_stairs');
			$job->job_elevator = Input::get('job_elevator');

			$job->job_house_sqft = Input::get('job_house_sqft');
			$job->job_comments = Input::get('job_comments');

			if($job->save()){
				$isertedID = $job->id;
				$toemail ="admin@vaultmovingandstorage.com";

				$customerName = DB::table('customers')->where('id', $job_customer_id)->pluck('customer_last_name');
				$designerName = DB::table('aditional_designers')->where('id', Input::get('job_designer_id'))->pluck('designer_name');

				$designerInfo = User::find($designerID);
				
				//now sending email to registered client
		    	$headers = "MIME-Version: 1.0" . "\r\n";
			    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			    $headers .= "From: vault@ncbeta.net <noreply@ncbeta.net>" . "\r\n";
			    
			    $email_sub = "New Job Notification: ".$isertedID;


		 		$email_body = "Client Name: ".$designerInfo->last_name.',<br /><br />';
				$email_body .= "Job Id: ".$isertedID.'<br />';
				$email_body .= "Job Name: ".Input::get('job_name').'<br />';
				$email_body .= "Est. Install Date: ".Input::get('job_install_date').'<br />';
				
				$email_body .= "Please save this email for future reference.<br/><br/>";
				$email_body .= '<hr /><br /><br />';
				  
				mail($toemail,$email_sub,$email_body,$headers);




				return Response::json(array('status' => 'success', 'isertedID' => $isertedID, 'customerName' => $customerName, 'designerName' => $designerName),200);	
			}
		}
		else
		{
			#update customer information.
			#parameter List: did, firm_name, customer_first_name, customer_last_name, primary_address, primary_address_two, city, state, phone, email

			#Check Duplicate Email
			/*$count = DB::table('customers')->where('email', Input::get('email'))
									   ->where('id','!=', Input::get('id'))
									   ->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}*/
			#End of Check Duplicate Email

			$job_customer_id = Input::get('job_customer_id');
			if(Input::get('job_customer_id') =='' && Input::get('customer_first_name')!='' ){
					$count = DB::table('customers')->count();

					$tdesignerID =$designerID;
					if (Input::has('job_client_id'))
					{
					 $tdesignerID = Input::get('job_client_id');
					}
					$customer_id = date('y').$tdesignerID.$count+1;

					$customer = new Customer;
					$customer->customer_firm_id = $tdesignerID;
					$customer->customer_id = $customer_id;
					$customer->customer_first_name = Input::get('customer_first_name');
					$customer->customer_last_name = Input::get('customer_last_name');
					$customer->customer_email = '-';
					$customer->customer_phone = Input::get('customer_phone');

					if($customer->save()){
						$job_customer_id  = $customer->id;
						
					}
			}


			$job = Job::find(Input::get('id'));
			$job->job_name = Input::get('job_name');
			$job->job_status = Input::get('job_status');
			$job->job_customer_id = $job_customer_id;
			$job->job_designer_id = Input::get('job_designer_id');
			$job->job_install_date = Input::get('job_install_date');
			$job->job_address1 = Input::get('job_address1');
			$job->job_address2 = Input::get('job_address2');

			$job->job_city = Input::get('job_city');
			$job->job_state_id = Input::get('job_state_id');
			$job->job_zip = Input::get('job_zip');
			$job->job_development_name = Input::get('job_development_name');

			$job->job_gated = Input::get('job_gated');
			$job->job_alarm = Input::get('job_alarm');
			$job->job_condo = Input::get('job_condo');
			$job->job_stairs = Input::get('job_stairs');
			$job->job_elevator = Input::get('job_elevator');

			$job->job_house_sqft = Input::get('job_house_sqft');
			$job->job_comments = Input::get('job_comments');

			if($job->save()){
				$customerName = DB::table('customers')->where('id', $job_customer_id)->pluck('customer_last_name');
				$designerName = DB::table('aditional_designers')->where('id', Input::get('job_designer_id'))->pluck('designer_name');

				$designerInfo = User::find($designerID);
				$isertedID = Input::get('id');
				$toemail ="admin@vaultmovingandstorage.com";
				//now sending email to registered client
		    	$headers = "MIME-Version: 1.0" . "\r\n";
			    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			    $headers .= "From: vault@ncbeta.net <noreply@ncbeta.net>" . "\r\n";
			    
			    $email_sub = "Job Update Notification: ".$isertedID;


		 		$email_body = "Client Name: ".$designerInfo->last_name.',<br /><br />';
				$email_body .= "Job Id: ".$isertedID.'<br />';
				$email_body .= "Job Name: ".Input::get('job_name').'<br />';
				$email_body .= "Est. Install Date: ".Input::get('job_install_date').'<br />';
				
				$email_body .= "Please save this email for future reference.<br/><br/>";
				$email_body .= '<hr /><br /><br />';
				  
				mail($toemail,$email_sub,$email_body,$headers);

				return Response::json(array('status' => 'updated', 'customerName' => $customerName, 'designerName' => $designerName),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getJob()
    {
       if(Input::get('id') != "") {
   						$jobs = DB::table('jobs')->select('jobs.*',
								    'customers.customer_first_name',
								    'customers.customer_last_name',
								    'customers.customer_phone')
							->leftJoin('customers', 'customers.id', '=', 'jobs.job_customer_id')
							->where('jobs.id', Input::get('id'))->first();
	        return Response::json($jobs);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteJob()
    {   
		DB::table('inventories')->where('job_id', Input::get('id'))->delete();
		Job::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================

	public function jobDetails($jobid, $designerID) {
		if (Auth::check()){
			$userid = Auth::user()->id; 


			$states = DB::table('us_states')->select('state_code','state_full')->orderBy('state_full', 'asc')->get();

			/*$customers = DB::table('customers')->select('id','customer_name','customer_first_name','customer_last_name')
												->where('customer_firm_id', $designerID)
												->orderBy('id', 'asc')->get();

			$adiDesigners = DB::table('aditional_designers')->select('id','designer_name')
														 ->where('firm_id', $designerID)
														 ->orderBy('designer_name', 'asc')->get();	*/	
														 	
			$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();											 
			$jobs = DB::table('jobs')->select('jobs.id',
								    'jobs.job_name',
								    'jobs.job_status',
								    'jobs.job_install_date',
								    'jobs.job_development_name',
								    'jobs.job_city',
								    'users.firm_name',
								    'customers.customer_last_name',
								    'aditional_designers.designer_name')
							->leftJoin('users', 'users.id', '=', 'jobs.job_client_id')
							->leftJoin('customers', 'customers.id', '=', 'jobs.job_customer_id')
							->leftJoin('aditional_designers', 'aditional_designers.id', '=', 'jobs.job_designer_id')
							->where('jobs.id', $jobid)->first();


			$inventories = DB::table('inventories')->select('inventories.id',
								    'inventories.inv_pono',
								    'inventories.inv_mfg',
								    'inventories.inv_item_status',
								    'inventories.inv_item_images',
								    'inventories.inv_qrcode',
								    'inventories.inv_note',
								    'itemdescriptions.itds_name',
								    'rooms.room_name',
								    'inventory_category.invcat_name',
								    'manufacturers.manuf_name',
								    'inventoryimages.img_invid')
							->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
							->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
							->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
							->leftJoin('manufacturers', 'manufacturers.id', '=', 'inventories.inv_manufacture')		
						    ->leftJoin('inventoryimages', 'inventories.inv_item_images', '=', 'inventoryimages.id')
      			
							->where('Job_id', $jobid)->get();


			$itemdescriptions = DB::table('itemdescriptions')->get();	
			$manufacturers = DB::table('manufacturers')->get();	
			$carriers = DB::table('carriers')->get();	
			$inventorycategories = DB::table('inventory_category')->get();	
			$rooms = DB::table('rooms')->get();	
			$warehouses = DB::table('warehouses')->get();	
			$bins = DB::table('bins')->get();	
			$binlrts = DB::table('binlrts')->get();	
			
			$view = View::make('jobs.jobdetails') 
			->with('title', 'Job Details')
			->with('menu', 'Jobs')
			->with('submenu', '')
			->with('jobs', $jobs)

			->with('itemdescriptions', $itemdescriptions)
			->with('manufacturers', $manufacturers)
			->with('carriers', $carriers)
			->with('inventorycategories', $inventorycategories)
			->with('rooms', $rooms)
			->with('warehouses', $warehouses)
			->with('bins', $bins)
			->with('binlrts', $binlrts)
			->with('advImage', $advImage)


			->with('inventories', $inventories)
			->with('states', $states)
			->with('jobid', $jobid)
			->with('designerID', $designerID);
			return $view;
	    }
	}


//========================================================================

    #Client Job List.
	public function getJobList()
    {   
		if(Input::get('firm_id') != "") {
			$jobs = DB::table('jobs')
								->select('jobs.id',
	    							     'jobs.job_name')
								->where('job_client_id', Input::get('firm_id'))
								->get();

			//return Response::json(array('warehousebin' => $warehousebin),200);
			$view = View::make('adminTemplate.adminjob.jobList')		
				  ->with('jobs', $jobs);
			return $view;
		}
        
    }
        public function get_customer()
        {
        	$userid = Auth::user()->id; 
        	$city=Input::get('term');
            $sql = DB::table('customers')
                    ->where('customer_firm_id', $userid)
                    ->where('customers.customer_first_name', 'LIKE', $city.'%')
                    ->lists('customer_first_name');
            $results = array();
            foreach($sql as $value)
            {
                $results[] = $value;
            }
            return Response::json($results,200);
        }

        public function admin_get_customer()
        {
        	$userid = Input::get('country'); 
        	$city=Input::get('term');
            $sql = DB::table('customers')
                    ->where('customer_firm_id', $userid)
                    ->where('customers.customer_first_name', 'LIKE', $city.'%')
                    ->lists('customer_first_name');
            $results = array();
            foreach($sql as $value)
            {
                $results[] = $value;
            }
            return Response::json($results,200);
        }



        public function get_namePhone()
        {
        	$userid = Auth::user()->id; 

			if (Input::has('glodeid'))
			{
			 $userid = Input::get('glodeid');
			}	

        	$city=Input::get('id');

            $results = DB::table('customers')
            		->select('customers.id','customers.customer_last_name','customers.customer_phone')
                    ->where('customer_firm_id', $userid)
                    ->where('customers.customer_first_name', $city)
                    ->first();
            if($results){
            	return Response::json(array('status' => 'success', 'id' => $results->id,'last_name' => $results->customer_last_name,'customer_phone' => $results->customer_phone ),200);
            } 
            else       
            return Response::json(array('status' => 'Nothing'),200);
        }

//========================================================================
}