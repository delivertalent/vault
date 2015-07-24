<?php

class ClientController extends BaseController {

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

	public function clientList()
	{
		//
		if(Auth::check()){
			$title = "Customers";
			$designerID=Auth::user()->id;
			$designerInfo = User::find($designerID);
			$states = DB::table('us_states')->select('state_code','state_full')->orderBy('state_full', 'asc')->get();
			$clients = DB::table('clients')->where('client_firm_id', $designerID)->get();
			$view = View::make('client.clients')
				  ->with('menu', 'Clients')
				  ->with('submenu', '')		
				  ->with('designerInfo', $designerInfo)		
				  ->with('states', $states)		
				  ->with('clients', $clients)		
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function saveClient(){
		$designerID=Auth::user()->id;
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, client_first_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			/*#Check Duplicate Email
			$count = DB::table('clients')->where('client_email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email*/
			$count = DB::table('clients')->count();

			$client_id = date('y').$designerID.$count+1;

			$client = new Client;
			$client->client_firm_id = $designerID;
			$client->client_id = $client_id;
			$client->client_name = Input::get('client_name');
			$client->client_first_name = Input::get('client_first_name');
			$client->client_last_name = Input::get('client_last_name');
			$client->client_primary = Input::get('client_primary');
			$client->clients_address2 = Input::get('clients_address2');
			$client->client_email = Input::get('client_email');

			$client->client_phone = Input::get('client_phone');
			$client->client_city = Input::get('client_city');
			$client->client_state = Input::get('client_state');
			$client->client_zip = Input::get('client_zip');

			if($client->save()){
				$isertedID = $client->id;
				return Response::json(array('status' => 'success', 'isertedID' => $isertedID, 'client_id' => $client_id),200);	
			}
		}
		else
		{
			#update client information.
			#parameter List: did, firm_name, client_first_name, client_last_name, primary_address, primary_address_two, city, state, phone, email

			#Check Duplicate Email
			/*$count = DB::table('clients')->where('email', Input::get('email'))
									   ->where('id','!=', Input::get('id'))
									   ->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}*/
			#End of Check Duplicate Email


			$client = Client::find(Input::get('id'));
			$client->client_first_name = Input::get('client_first_name');
			$client->client_last_name = Input::get('client_last_name');
			$client->client_primary = Input::get('client_primary');
			$client->clients_address2 = Input::get('clients_address2');
			$client->client_email = Input::get('client_email');
			$client->client_phone = Input::get('client_phone');
			$client->client_city = Input::get('client_city');
			$client->client_state = Input::get('client_state');
			$client->client_zip = Input::get('client_zip');
			if($client->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getClient()
    {
       if(Input::get('id') != "") {
   			$client = Client::find(Input::get('id'));
	        return Response::json($client);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteClient()
    {   
		Client::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================



}