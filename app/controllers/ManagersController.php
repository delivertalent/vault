<?php

class ManagersController extends BaseController {

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

	public function managerList()
	{
		//
		if(Auth::check()){
			$title = "Warehouse Manager";
			$managerLists = DB::table('users')->where('role_id', 3)->get();
			$view = View::make('adminTemplate.managers.manager')
				  ->with('menu', 'warManager')
				  ->with('submenu', '')		
				  ->with('managerLists', $managerLists)			
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function savemanager(){
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, firm_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			#Check Duplicate Email
			$count = DB::table('users')->where('email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email

			$newPassword = Input::get('mpassword');
			if($newPassword==''){
				$newPassword = str_random(6);
			}

			$w_mamager = new User;
			$w_mamager->firm_name = "Warehouse Manager";
			$w_mamager->first_name = Input::get('first_name');
			$w_mamager->last_name = Input::get('last_name');
			$w_mamager->primary_address = Input::get('primary_address');
			$w_mamager->primary_address_two = Input::get('primary_address_two');

			$w_mamager->phone = Input::get('phone');
			$w_mamager->email = Input::get('email');
			$w_mamager->password = Hash::make($newPassword);
			$w_mamager->status = 3;
			$w_mamager->role_id = 3;

			if($w_mamager->save()){
				$isertedID = $w_mamager->id;

					$link =  route('login');
			        $data = array('userName'  => $w_mamager->last_name, 
			        			  'userEmail'  => $w_mamager->email, 
			        			  'userPassword'  => $newPassword, 
			        			  'link'  => $link 
			        			  );
			        $subject = 'Vault: Warehouse Manager Account Created Successfully';


//now sending email to registered client
		    	$headers = "MIME-Version: 1.0" . "\r\n";
			    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			    $headers .= "From: vault@ncbeta.net <noreply@ncbeta.net>" . "\r\n";
			    
			    $email_sub = "Vault: Warehouse Manager Account Created Successfully";


		 		$email_body = "Dear ".$w_mamager->last_name.',<br /><br />';
				$email_body .= "Welcome to vault@ncbeta.net Please find your sign in credentials below".'<br /><br />';
				/*$email_body .= "Your user information:".'<br /><br />';*/
				$email_body .= "Email: ".$w_mamager->email.'<br />';
				$email_body .= "Password: ".$newPassword.'<br /><br />';
			    $email_body .= 'You can login below and change your password<br/>'; 
				$email_body .= 'URL: <a href="'.$link.'">'.$link.'</a><br />';
				$email_body .= "Please save this email for future reference.<br/><br/>";
				$email_body .= '<hr /><br /><br />';
				  
				mail($w_mamager->email,$email_sub,$email_body,$headers);

			        // sending mail:
			       /* Mail::send('emails.emailTemp', $data, function($message) use ($designer,$subject)
			            {
			                $message->to($designer->email , $designer->last_name)->subject($subject);
			            });*/
				return Response::json(array('status' => 'success','isertedID' => $isertedID),200);	
			}
		}
		else
		{
			#update designer information.
			#parameter List: did, firm_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email

			#Check Duplicate Email
			$count = DB::table('users')->where('email', Input::get('email'))
									   ->where('id','!=', Input::get('id'))
									   ->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email
			$newPassword = Input::get('mpassword');


			$w_mamager = User::find(Input::get('id'));
			$w_mamager->first_name = Input::get('first_name');
			$w_mamager->last_name = Input::get('last_name');
			$w_mamager->primary_address = Input::get('primary_address');
			$w_mamager->primary_address_two = Input::get('primary_address_two');
			$w_mamager->phone = Input::get('phone');
			$w_mamager->email = Input::get('email');
			#Check if admin set new password
			if($newPassword!=''){
				$w_mamager->password = Hash::make($newPassword);
			}
			#Save Warehouse Manager Information
			if($w_mamager->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getCustomer()
    {
       if(Input::get('id') != "") {
   			$customer = Customer::find(Input::get('id'));
	        return Response::json($customer);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteCustomer()
    {   
		Customer::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================

//========================================================================

    #Delete Designer Information.
	public function dashboard()
    {   
		$title = "Manager Dashboard";

			$newworkorders = DB::table('workorders')->whereIn('wo_status', array(2, 3))->count();
			$damaged = DB::table('inventories')->whereIn('inv_item_status', array(2, 3, 4))->count();

			$workorders = DB::table('workorders')->select('workorders.*','jobs.job_name','users.firm_name')
									->leftJoin('jobs', 'jobs.id', '=', 'workorders.wo_jobid')
									->leftJoin('users', 'users.id', '=', 'workorders.wo_firmid')
									->where('wo_status', 3)
									->orderBy('workorders.id', 'desc')->get();


		$view = View::make('managerTemplate.dashboard')
		->with('menu', 'Dashboard')
		->with('submenu', '')
		->with('workorders',$workorders)
		->with('newworkorders',$newworkorders)
		->with('damaged',$damaged)
		->with('title',$title);
		return $view;
        
    }

//========================================================================    

     #Inventory Information.
	public function inventories(){
			$clients = DB::table('users')->where('role_id', 2)->get();	
			$itemdescriptions = DB::table('itemdescriptions')->get();	
			$manufacturers = DB::table('manufacturers')->get();	
			$carriers = DB::table('carriers')->get();	
			$inventorycategories = DB::table('inventory_category')->get();	
			$rooms = DB::table('rooms')->get();	
			$warehouses = DB::table('warehouses')->get();	
			$bins = DB::table('bins')->get();	
			$binlrts = DB::table('binlrts')->get();	
			$storagePrices = DB::table('storage_prices')->get();	
			$searchJob = DB::table('jobs')->get();

			$view = View::make('managerTemplate.inventories.inventoryList')
					->with('title', 'Inventory List')
					->with('menu', 'inventorylist')
					->with('submenu', '')

			->with('clients', $clients)
			->with('itemdescriptions', $itemdescriptions)
			->with('manufacturers', $manufacturers)
			->with('carriers', $carriers)
			->with('inventorycategories', $inventorycategories)
			->with('rooms', $rooms)
			->with('warehouses', $warehouses)
			->with('bins', $bins)
			->with('searchJob', $searchJob)
			->with('binlrts', $binlrts)
			->with('storagePrices', $storagePrices);
			
			return $view;		
	}

   #Retrive the requisted designer information from database
	public function getInventory($id)
    {
       if($id != "") {
	$inventories = DB::table('inventories')->select('inventories.*',
												'itemdescriptions.itds_name',
												'rooms.room_name',
												'jobs.job_name',
												'jobs.job_client_id')
										  ->leftJoin('jobs', 'jobs.id', '=', 'inventories.job_id')
										  ->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
										  ->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
	                                      ->where('inventories.id', $id)->first();

			$designer_Fname = DB::table('users')->where('id', $inventories->job_client_id)->pluck('first_name');
			$designer_Lname = DB::table('users')->where('id', $inventories->job_client_id)->pluck('last_name');
			$designerFullname= $designer_Fname.' '.	$designer_Lname;                                      
			$storagePrices = DB::table('storage_prices')->get();
			$itemdescriptions = DB::table('itemdescriptions')->get();	
			$manufacturers = DB::table('manufacturers')->get();	
			$carriers = DB::table('carriers')->get();	
			$inventorycategories = DB::table('inventory_category')->get();	
			$rooms = DB::table('rooms')->get();	
			$warehouses = DB::table('warehouses')->get();	
			$bins = DB::table('bins')->where('bin_warehouse', $inventories->inv_warehouse)->get();	
			$binlrts = DB::table('binlrts')->where('binlrt_bin', $inventories->inv_bin)->get();	
			$incentoryImages = DB::table('inventoryimages')->where('img_invid', $id)->get();	


			$jobs = DB::table('jobs')->select('jobs.id','jobs.job_name')
						->where('jobs.job_status', '!=', 3 )
						->orderBy('jobs.id', 'desc')
						->get();


			$view = View::make('managerTemplate.inventories.inventory') 
			->with('title', 'Inventory Details')
			->with('menu', 'Jobs')
			->with('submenu', '')
			->with('storagePrices', $storagePrices)
			->with('itemdescriptions', $itemdescriptions)
			->with('manufacturers', $manufacturers)
			->with('carriers', $carriers)
			->with('inventorycategories', $inventorycategories)
			->with('rooms', $rooms)
			->with('warehouses', $warehouses)
			->with('bins', $bins)
			->with('binlrts', $binlrts)
			->with('designerFullname', $designerFullname)
			->with('incentoryImages', $incentoryImages)
			->with('inventories', $inventories)
			->with('jobs', $jobs);
			return $view;	
        }
    }

}