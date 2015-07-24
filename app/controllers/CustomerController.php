<?php

class CustomerController extends BaseController {

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

	public function customerList()
	{
		//
		if(Auth::check()){
			$title = "Customers";
			$designerID=Auth::user()->id;
			$designerInfo = User::find($designerID);
			$states = DB::table('us_states')->select('state_code','state_full')->orderBy('state_full', 'asc')->get();
			$customers = DB::table('customers')->where('customer_firm_id', $designerID)->get();
			$view = View::make('customer.customers')
				  ->with('menu', 'Customers')
				  ->with('submenu', '')		
				  ->with('designerInfo', $designerInfo)		
				  ->with('states', $states)		
				  ->with('customers', $customers)		
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function saveCustomer(){
		$designerID=Auth::user()->id;
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, customer_first_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			/*#Check Duplicate Email
			$count = DB::table('customers')->where('customer_email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email*/
			$count = DB::table('customers')->count();

			$customer_id = date('y').$designerID.$count+1;

			$customer = new Customer;
			$customer->customer_firm_id = $designerID;
			$customer->customer_id = $customer_id;
			$customer->customer_first_name = Input::get('customer_first_name');
			$customer->customer_last_name = Input::get('customer_last_name');
			$customer->customer_primary = Input::get('customer_primary');
			$customer->customer_address2 = Input::get('customer_address2');
			$customer->customer_email = Input::get('customer_email');

			$customer->customer_phone = Input::get('customer_phone');
			$customer->customer_city = Input::get('customer_city');
			$customer->customer_state = Input::get('customer_state');
			$customer->customer_zip = Input::get('customer_zip');

			if($customer->save()){
				$isertedID = $customer->id;
				return Response::json(array('status' => 'success', 'isertedID' => $isertedID, 'customer_id' => $customer_id),200);	
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


			$customer = Customer::find(Input::get('id'));
			$customer->customer_first_name = Input::get('customer_first_name');
			$customer->customer_last_name = Input::get('customer_last_name');
			$customer->customer_primary = Input::get('customer_primary');
			$customer->customer_address2 = Input::get('customer_address2');
			$customer->customer_email = Input::get('customer_email');
			$customer->customer_phone = Input::get('customer_phone');
			$customer->customer_city = Input::get('customer_city');
			$customer->customer_state = Input::get('customer_state');
			$customer->customer_zip = Input::get('customer_zip');
			if($customer->save()){
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

     #Designer Details Information.
	public function detailCustomer($customerID)
    {   
		if (Auth::check()){
			$userid = Auth::user()->id; 
			# role_id =1 admin User
			# role_id =2 Designer
			
			$thiscustomers = DB::table('customers')->select('customers.id',
									'customers.customer_first_name',
								    'customers.customer_last_name',
								    'customers.customer_email',
								    'customers.customer_phone',
								    'customers.customer_city',
								    'customers.customer_zip',
								    'customers.customer_primary',
								    'customers.customer_address2',
								    'customers.customer_firm_id',
								    'us_states.state_full')
							->leftJoin('us_states', 'us_states.state_code', '=', 'customers.customer_state')
							->where('id', $customerID)->first();	


			$states = DB::table('us_states')->select('state_code','state_full')->orderBy('state_full', 'asc')->get();

			$customers = DB::table('customers')->select('id','customer_first_name','customer_last_name')
												->where('customer_firm_id', $userid)
												->orderBy('id', 'asc')->get();

			$adiDesigners = DB::table('aditional_designers')->select('id','designer_name')
														 ->where('firm_id', $userid)
														 ->orderBy('designer_name', 'asc')->get();



			$jobs = DB::table('jobs')->select('jobs.id',
									'jobs.job_client_id',
								    'jobs.job_name',
								    'jobs.job_status',
								    'customers.customer_last_name',
								    'aditional_designers.designer_name')
							->leftJoin('customers', 'customers.id', '=', 'jobs.job_customer_id')
							->leftJoin('aditional_designers', 'aditional_designers.id', '=', 'jobs.job_designer_id')
							->where('job_client_id', $userid)->where('job_customer_id', $customerID)->orderBy('id', 'desc')->get();



			$view = View::make('customer.customerdetails') 
			->with('title', 'Clients Details')
			->with('menu', 'Customers')
			->with('submenu', '')
			->with('userid', $userid)
			->with('states', $states)
			->with('customers', $customers)
			->with('adiDesigners', $adiDesigners)
			->with('jobs', $jobs)
			->with('thiscustomers', $thiscustomers);
			return $view;
	    }
        
    }  

}