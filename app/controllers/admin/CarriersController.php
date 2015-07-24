<?php

class CarriersController extends BaseController {

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

	public function carrierList()
	{
		//
		if(Auth::check()){
			$title = "Carriers";
			
			$carriers = DB::table('carriers')->get();
			$view = View::make('adminTemplate.carriers.carrier')
				  ->with('menu', 'Configuration')
				  ->with('submenu', 'carrier')			
				  ->with('carriers', $carriers)		
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function saveCarrier(){
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, customer_first_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			/*#Check Duplicate Email
			$count = DB::table('customers')->where('customer_email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email*/


			$carrier = new Carrier;
			$carrier->carrier_name = Input::get('carrier_name');

			if($carrier->save()){
				$isertedID = $carrier->id;
				return Response::json(array('status' => 'success', 'isertedID' => $isertedID),200);	
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


			$carrier = Carrier::find(Input::get('id'));
			$carrier->carrier_name = Input::get('carrier_name');
			if($carrier->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getCarrier()
    {
       if(Input::get('id') != "") {
   			$customer = Carrier::find(Input::get('id'));
	        return Response::json($customer);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteCarrier()
    {   
		Carrier::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================



}