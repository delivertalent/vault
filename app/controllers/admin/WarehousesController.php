<?php

class WarehousesController extends BaseController {

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

	public function warehoueList()
	{
		//
		if(Auth::check()){
			$title = "Warehouses";
			
			$warehoues = DB::table('warehouses')
						->select('warehouses.id',
					    'warehouses.warehouse_name')
				->orderBy('warehouses.id', 'asc')
				->get();

			$warehouselocations = DB::table('warehouse_locations')->get();
			$view = View::make('adminTemplate.warehoues.warehoue')
				  ->with('menu', 'Configuration')
				  ->with('submenu', 'warehouses')					
				  ->with('warehoues', $warehoues)		
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function saveWarehoue(){
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, customer_first_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			/*#Check Duplicate Email
			$count = DB::table('customers')->where('customer_email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email*/


			$warehoue = new Warehouse;
			$warehoue->warehouse_name = Input::get('warehouse_name');

			if($warehoue->save()){
				$isertedID = $warehoue->id;
				return Response::json(array('status' => 'success', 'isertedID' => $isertedID),200);	
			}
		}
		else
		{
			$warehoue = Warehouse::find(Input::get('id'));
			$warehoue->warehouse_name = Input::get('warehouse_name');
			if($warehoue->save()){				
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getWarehoue()
    {
       if(Input::get('id') != "") {
   			$warehoue = Warehouse::find(Input::get('id'));
	        return Response::json($warehoue);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteWarehoue()
    {   
		Warehouse::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================



}