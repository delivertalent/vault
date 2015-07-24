<?php

class JobinventoryController extends BaseController {
	

	public function jobDetails($jobid, $designerID) {
		if (Auth::check()){
			$userid = Auth::user()->id; 


			$states = DB::table('us_states')->select('state_code','state_full')->orderBy('state_full', 'asc')->get();

			/*$customers = DB::table('customers')->select('id','customer_name','customer_first_name','customer_last_name')
												->where('customer_firm_id', $designerID)
												->orderBy('id', 'asc')->get();

			$adiDesigners = DB::table('aditional_designers')->select('id','designer_name')
														 ->where('firm_id', $designerID)
														 ->orderBy('designer_name', 'asc')->get();	*/		

			$jobs = DB::table('jobs')->select('jobs.id',
								    'jobs.job_name',
								    'jobs.job_status',
								    'jobs.job_install_date',
								    'jobs.job_development_name',
								    'jobs.job_city',
								    'users.firm_name',
								    'customers.customer_last_name',
								    'aditional_designers.designer_name')
							->leftJoin('users', 'users.id', '=', 'jobs.job_client_id')
							->leftJoin('customers', 'customers.id', '=', 'jobs.job_customer_id')
							->leftJoin('aditional_designers', 'aditional_designers.id', '=', 'jobs.job_designer_id')
							->where('jobs.id', $jobid)->first();


			$inventories = DB::table('inventories')->select('inventories.id',
								    'inventories.inv_pono',
								    'inventories.inv_mfg',
								    'inventories.inv_item_status',
								    'inventories.inv_item_images',
								    'inventories.inv_qrcode',
								    'inventories.inv_note',
								    'inventories.Job_id',
								    'jobs.job_name',
								    'itemdescriptions.itds_name',
								    'rooms.room_name',
								    'bins.bin_name',
								    'binlrts.binlrt_name',
								    'inventory_category.invcat_name',
								    'manufacturers.manuf_name')
							->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
							->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
							->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
							->leftJoin('manufacturers', 'manufacturers.id', '=', 'inventories.inv_manufacture')	
							->leftJoin('jobs', 'jobs.id', '=', 'inventories.Job_id')		     	
							->leftJoin('bins', 'bins.id', '=', 'inventories.inv_bin')		     	
							->leftJoin('binlrts', 'binlrts.id', '=', 'inventories.inv_binltr')
      			
							->where('Job_id', $jobid)->get();


			$itemdescriptions = DB::table('itemdescriptions')->get();	
			$manufacturers = DB::table('manufacturers')->get();	
			$carriers = DB::table('carriers')->get();	
			$inventorycategories = DB::table('inventory_category')->get();	
			$rooms = DB::table('rooms')->get();	
			$warehouses = DB::table('warehouses')->get();	
			$bins = DB::table('bins')->get();	
			$binlrts = DB::table('binlrts')->get();	
			$storagePrices = DB::table('storage_prices')->get();
			
			$view = View::make('adminTemplate.jobiventories.jobiventory') 
			->with('title', 'Job Details')
			->with('menu', 'Jobs')
			->with('submenu', '')
			->with('jobs', $jobs)

			->with('itemdescriptions', $itemdescriptions)
			->with('manufacturers', $manufacturers)
			->with('carriers', $carriers)
			->with('inventorycategories', $inventorycategories)
			->with('rooms', $rooms)
			->with('warehouses', $warehouses)
			->with('bins', $bins)
			->with('binlrts', $binlrts)
			->with('storagePrices', $storagePrices)


			->with('inventories', $inventories)
			->with('states', $states)
			->with('jobid', $jobid)
			->with('designerID', $designerID);
			return $view;
	    }
	}
}