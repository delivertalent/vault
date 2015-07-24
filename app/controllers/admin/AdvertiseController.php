<?php

class AdvertiseController extends BaseController {

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

	public function advertiseList()
	{
		//
		if(Auth::check()){
			$title = "Advertises";
			
			$advertises = DB::table('advertises')->get();
			$view = View::make('adminTemplate.advertises.advertise')
				  ->with('menu', 'Configuration')
				  ->with('submenu', 'advertise')			
				  ->with('advertises', $advertises)		
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function saveAdvertise(){
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, customer_first_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			/*#Check Duplicate Email
			$count = DB::table('customers')->where('customer_email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email*/
				$invImage=Input::get('advertise_image');
				$invImage = rtrim($invImage, ",");

				$advertise = new Advertise;
				$advertise->advertise_image = $invImage;
				if($advertise->save()){
					return Response::json(array('status' => 'success', 'add_images' => $invImage),200);								
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


			$advertise = Advertise::find(Input::get('id'));
			$advertise->advertise_image = Input::get('advertise_image');
			if($advertise->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getAdvertise()
    {
       if(Input::get('id') != "") {
   			$customer = Advertise::find(Input::get('id'));
	        return Response::json($customer);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteAdvertise()
    {   
		Advertise::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================



}