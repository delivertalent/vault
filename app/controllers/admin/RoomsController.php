<?php

class RoomsController extends BaseController {

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

	public function roomList()
	{
		//
		if(Auth::check()){
			$title = "Room";
			
			$rooms = DB::table('rooms')->get();
			$view = View::make('adminTemplate.rooms.room')
				  ->with('menu', 'Configuration')
				  ->with('submenu', 'room')			
				  ->with('rooms', $rooms)		
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function roomInline()
	{
		//
		if(Auth::check()){
			
			$rooms = DB::table('rooms')->get();
			$view = View::make('common.roomsList')		
				  ->with('rooms', $rooms);
			return $view;			
		}		
	}

	public function saveRoom(){
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, customer_first_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			/*#Check Duplicate Email
			$count = DB::table('customers')->where('customer_email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email*/


			$room = new Room;
			$room->room_name = Input::get('room_name');

			if($room->save()){
				$isertedID = $room->id;
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


			$room = Room::find(Input::get('id'));
			$room->room_name = Input::get('room_name');
			if($room->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getRoom()
    {
       if(Input::get('id') != "") {
   			$room = Room::find(Input::get('id'));
	        return Response::json($room);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteRoom()
    {   
		Room::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================



}