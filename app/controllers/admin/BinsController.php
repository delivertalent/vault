<?php

class BinsController extends BaseController {

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

	public function binList()
	{
		//
		if(Auth::check()){
			$title = "Bins";
			
			$bins = DB::table('bins')
						->select('bins.id',
					    'bins.bin_name',
					    'warehouses.warehouse_name')
				->leftJoin('warehouses', 'warehouses.id', '=', 'bins.bin_warehouse')
				->orderBy('bins.id', 'asc')
				->get();

			$warehouses = DB::table('warehouses')->get();
			$view = View::make('adminTemplate.bins.bin')
				  ->with('menu', 'Configuration')
				  ->with('submenu', 'bins')			
				  ->with('warehouses', $warehouses)			
				  ->with('bins', $bins)		
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function saveBin(){
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, customer_first_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			/*#Check Duplicate Email
			$count = DB::table('customers')->where('customer_email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email*/


			$bin = new Bin;
			$bin->bin_warehouse = Input::get('bin_warehouse');
			$bin->bin_name = Input::get('bin_name');

			if($bin->save()){
				$isertedID = $bin->id;
				$warehouses = DB::table('warehouses')
												->where('id', Input::get('bin_warehouse'))
												->first();
				return Response::json(array('status' => 'success', 'isertedID' => $isertedID, 'warehouses' => $warehouses),200);	
			}
		}
		else
		{
			$bin = Bin::find(Input::get('id'));
			$bin->bin_warehouse = Input::get('bin_warehouse');
			$bin->bin_name = Input::get('bin_name');
			if($bin->save()){
				$warehouses = DB::table('warehouses')
												->where('id', Input::get('bin_warehouse'))
												->first();				
				return Response::json(array('status' => 'updated', 'warehouses' => $warehouses),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getBin()
    {
       if(Input::get('id') != "") {
   			$bin = Bin::find(Input::get('id'));
	        return Response::json($bin);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteBin()
    {   
		Bin::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================

//========================================================================

    #Warehouse Bin List.
	public function warehousebinList()
    {   
		if(Input::get('warehouseID') != "") {
			$warehousebins = DB::table('bins')
								->select('bins.id',
	    							     'bins.bin_name')
								->where('bin_warehouse', Input::get('warehouseID'))
								->get();

			//return Response::json(array('warehousebin' => $warehousebin),200);
			$view = View::make('adminTemplate.bins.binwarehouselist')		
				  ->with('warehousebins', $warehousebins);
			return $view;
		}
        
    }

//========================================================================

}