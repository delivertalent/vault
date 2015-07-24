<?php

class BinlrtsController extends BaseController {

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

	public function binlrtList()
	{
		//
		if(Auth::check()){
			$title = "Binlrts";
			
			$binlrts = DB::table('binlrts')
						->select('binlrts.id',
					    'binlrts.binlrt_name',
					    'warehouses.warehouse_name',
					    'bins.bin_name')
				->leftJoin('warehouses', 'warehouses.id', '=', 'binlrts.binlrt_warehouse')
				->leftJoin('bins', 'bins.id', '=', 'binlrts.binlrt_bin')
				->orderBy('binlrts.id', 'asc')
				->get();

			$warehouses = DB::table('warehouses')->get();
			$bins = DB::table('bins')->get();
			$view = View::make('adminTemplate.bins.binlrt')
				  ->with('menu', 'Configuration')
				  ->with('submenu', 'binlrts')			
				  ->with('warehouses', $warehouses)			
				  ->with('binlrts', $binlrts)		
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function saveBinlrt(){
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, customer_first_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			/*#Check Duplicate Email
			$count = DB::table('customers')->where('customer_email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email*/


			$binlrt = new Binlrt;
			$binlrt->binlrt_name = Input::get('binlrt_name');
			$binlrt->binlrt_bin = Input::get('binlrt_bin');
			$binlrt->binlrt_warehouse = Input::get('binlrt_warehouse');

			if($binlrt->save()){
				$isertedID = $binlrt->id;
				$warehouses = DB::table('warehouses')->where('id', Input::get('binlrt_warehouse'))
												     ->first();

				$bins = DB::table('bins')->where('id', Input::get('binlrt_bin'))
										 ->first();								
				
				return Response::json(array('status' => 'success', 'isertedID' => $isertedID, 'warehouses' => $warehouses, 'bins' => $bins),200);	
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


			$binlrt = Binlrt::find(Input::get('id'));
			$binlrt->binlrt_name = Input::get('binlrt_name');
			$binlrt->binlrt_bin = Input::get('binlrt_bin');
			$binlrt->binlrt_warehouse = Input::get('binlrt_warehouse');

			if($binlrt->save()){
				$warehouses = DB::table('warehouses')->where('id', Input::get('binlrt_warehouse'))
												     ->first();

				$bins = DB::table('bins')->where('id', Input::get('binlrt_bin'))
										 ->first();	

				return Response::json(array('status' => 'updated', 'warehouses' => $warehouses, 'bins' => $bins),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getBinlrt()
    {
       if(Input::get('id') != "") {
   			$binlrt = Binlrt::find(Input::get('id'));
	        return Response::json($binlrt);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteBinlrt()
    {   
		Binlrt::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================

//========================================================================

    #Warehouse Bin BinLrt List.
	public function binBinLrt()
    {   
		if(Input::get('binID') != "") {
			$binBinLrts = DB::table('binlrts')
								->select('binlrts.id',
	    							     'binlrts.binlrt_name')
								->where('binlrt_bin', Input::get('binID'))
								->get();

			//return Response::json(array('warehousebin' => $warehousebin),200);
			$view = View::make('adminTemplate.bins.binBinLrt')		
				  ->with('binBinLrts', $binBinLrts);
			return $view;
		}
        
    }

//========================================================================

}