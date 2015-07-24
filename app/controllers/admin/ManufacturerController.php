<?php

class ManufacturerController extends BaseController {

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

	public function manufacturerList()
	{
		//
		if(Auth::check()){
			$title = "Manufacture";
			
			$manufacturers = DB::table('manufacturers')->get();
			$view = View::make('adminTemplate.manufacturer.manufacturer')
				  ->with('menu', 'Configuration')
				  ->with('submenu', 'manufacturer')			
				  ->with('manufacturers', $manufacturers)		
			      ->with('title',$title);
			return $view;			
		}		
	}

	public function manufacturerInline()
	{
		if(Auth::check()){
			
			$manufacturers = DB::table('manufacturers')->get();
			$view = View::make('common.manufacturerList')		
				  ->with('manufacturers', $manufacturers);
			return $view;			
		}		
	}


	public function saveManufacturer(){
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, customer_first_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			/*#Check Duplicate Email
			$count = DB::table('customers')->where('customer_email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email*/


			$manufacturer = new Manufacturer;
			$manufacturer->manuf_name = Input::get('manuf_name');

			if($manufacturer->save()){
				$isertedID = $manufacturer->id;
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


			$manufacturer = Manufacturer::find(Input::get('id'));
			$manufacturer->manuf_name = Input::get('manuf_name');
			if($manufacturer->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getManufacturer()
    {
       if(Input::get('id') != "") {
   			$customer = Manufacturer::find(Input::get('id'));
	        return Response::json($customer);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteManufacturer()
    {   
		Manufacturer::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================



}