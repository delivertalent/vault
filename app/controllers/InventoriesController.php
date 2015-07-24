<?php

class InventoriesController extends BaseController {

	public function saveInventory(){
		$designerID=Auth::user()->id;
		if(Input::get('id') == ""){
			#Add Designer information
			# Parameter List:
            #inv_description inv_pono inv_category inv_received inv_delivered inv_quantity
            #inv_size inv_manufacture inv_carrier inv_room inv_storage_price inv_mfg inv_item_status
            #inv_delivery_status inv_warehouse inv_bin inv_binltr inv_note
			


			$inventory = new Inventory;			
			
			$inventory->inv_description = Input::get('inv_description');
			$inventory->inv_pono = Input::get('inv_pono');
			$inventory->inv_category = Input::get('inv_category');
			$inventory->inv_received = Input::get('inv_received');
			$inventory->inv_delivered = Input::get('inv_delivered');
			$inventory->inv_quantity = Input::get('inv_quantity');
			$inventory->inv_size = addslashes(Input::get('inv_size'));

			$inventory->inv_manufacture = Input::get('inv_manufacture');
			$inventory->inv_carrier = Input::get('inv_carrier');
			$inventory->inv_room = Input::get('inv_room');

			$inventory->inv_storage_price = Input::get('inv_storage_price');
			$inventory->inv_mfg = Input::get('inv_mfg');
			$inventory->inv_qb = Input::get('inv_qb');
			$inventory->inv_item_status = Input::get('inv_item_status');
			$inventory->inv_delivery_status = Input::get('inv_delivery_status');
			$inventory->inv_warehouse = Input::get('inv_warehouse');

			$inventory->inv_bin = Input::get('inv_bin');
			$inventory->inv_binltr = Input::get('inv_binltr');
			$inventory->inv_note = Input::get('inv_note');
			$inventory->inv_private_note = Input::get('inv_private_note');
			$inventory->firm_id = Input::get('firm_id');
			$inventory->job_id = Input::get('job_id');

			if($inventory->save()){

			$designer = User::find(Input::get('firm_id'));
			$designer->email_alerts = 1;
			$designer->save();
			
			$isertedID = $inventory->id;

			$itds_name = DB::table('itemdescriptions')->where('id', Input::get('inv_description'))->pluck('itds_name');
			$room_name = DB::table('rooms')->where('id', Input::get('inv_room'))->pluck('room_name');
			$manuf_name = DB::table('manufacturers')->where('id', Input::get('inv_manufacture'))->pluck('manuf_name');
			$invcat_name = DB::table('inventory_category')->where('id', Input::get('inv_category'))->pluck('invcat_name');

			$bins = DB::table('bins')->where('id', Input::get('inv_bin'))->pluck('bin_name');
			$binlrts = DB::table('binlrts')->where('id', Input::get('inv_binltr'))->pluck('binlrt_name');
			$jobs_name = DB::table('jobs')->where('id', Input::get('job_id'))->pluck('job_name');



			$featureImage ='';
			if(Input::get('show_image_name')!=""){
				$invImages=Input::get('show_image_name');
				rtrim($invImages, ",");
				$invImages = explode(",", $invImages);

				$counti=0;
				$featureImage ='';
				foreach($invImages as $invImage){
					if($invImage!=''){
						$imgInv = new Inventoryimage;
						$imgInv->img_jobid = Input::get('job_id');
						$imgInv->img_invid = $isertedID;	
						$imgInv->img_name = $invImage;
						$imgInv->save();
						if($counti==0){
							DB::table('inventories')->where('id', $isertedID)->update(array('inv_item_images' => $invImage));
							$featureImage=$invImage;
						}
						$counti++;
					}
				}
			}


/*Create QR Code*/

			$inventory_id = $isertedID;
			$inventory_job_id = Input::get('job_id');
			$inventory_job_name = $jobs_name;

			$inv_bin = Input::get('inv_bin');
			$inv_binltr= Input::get('inv_binltr');
			$job_client_id= Input::get('firm_id');

			$inv_bin_name = $bins;
			$inv_binltr_name = $binlrts;
			
			$designer_conmany = DB::table('users')->where('id', $job_client_id)->pluck('firm_name');
			$designer_Fname = DB::table('users')->where('id', $job_client_id)->pluck('first_name');
			$designer_Lname = DB::table('users')->where('id', $job_client_id)->pluck('last_name');
			$designer_FullName = $designer_Fname.' '.$designer_Lname;

			$job_customer_id = DB::table('jobs')->where('id', $inventory_job_id)->pluck('job_customer_id');

			$customerFullName = DB::table('customers')->where('id', $job_customer_id)->pluck(DB::raw('CONCAT(customer_first_name, " ", customer_last_name) AS full_name'));
/*
) Inventory #
2) Bin #
3) Bin Ltr
4) Designer Name
5) Job Name
*/
			$url='ID:'.$inventory_id.'Designer Name '.$designer_FullName.' Job Name:'.$inventory_job_name.' Bin:'.$inv_bin_name.'Bin Ltr:'.$inv_binltr_name;  
			$width = 200; 
			$height = 200; 
			$border = 1;
            $error = "L"; 
            $https = false; 
            $loadBalance = false;


			  $filename = "./qrcodes/".$inventory_id."_".$inventory_job_name.".png";
			  if (file_exists($filename))
			  {
			  	unlink($filename);
			  }

			    // build Google Charts URL:
			    // secure connection ?
			    $protocol = $https ? "https" : "http";
			    // load balancing
			    $host   = "chart.googleapis.com";
			    if ($loadBalance)
			      $host = abs(crc32($parameters) % 10).".chart.apis.google.com";
			    // safe URL
			    $url    = urlencode($url);
			    // put everything together
			    $qrUrl  = "$protocol://$host/chart?chs={$width}x{$height}&cht=qr&chld=$error|$border&chl=$url";
			    // get QR code from Google's servers
			    $qr     = file_get_contents($qrUrl);
			    // optimize PNG and save locally
			    $imgIn  = imagecreatefromstring($qr);
			    $imgOut = imagecreate($width, $height);
			    imagecopy($imgOut, $imgIn, 0,0, 0,0, $width,$height);
			    imagepng($imgOut, $filename, 9, PNG_ALL_FILTERS);
			    imagedestroy($imgIn);
			    imagedestroy($imgOut);

			  $qrImage ='';
			  $inventory = Inventory::find($inventory_id);
			  $inventory->inv_qrcode = $filename;
			  if($inventory->save()){
				$qrImage = $filename;	
				}



/*End of Create QR Code*/


				return Response::json(array('status' => 'success', 'isertedID' => $isertedID, 'itds_name' => $itds_name, 'bins' => $bins,  'binlrts' => $binlrts,  'jobs_name' => $jobs_name,  
									'manuf_name' => $manuf_name, 'room_name' => $room_name, 'invcat_name' => $invcat_name, 'featureImage' => $featureImage, 'qrImage' => $qrImage, 'designer_FullName' => $designer_FullName, 'customerFullName' => $designer_conmany  ),200);	
			}
		}
		else
		{
			#update customer information.
			#parameter List: did, firm_name, customer_first_name, customer_last_name, primary_address, primary_address_two, city, state, phone, email



			$inventory = Inventory::find(Input::get('id'));
			$inventory->inv_description = Input::get('inv_description');
			$inventory->inv_pono = Input::get('inv_pono');
			$inventory->inv_category = Input::get('inv_category');
			$inventory->inv_received = Input::get('inv_received');
			$inventory->inv_delivered = Input::get('inv_delivered');
			$inventory->inv_quantity = Input::get('inv_quantity');
			$inventory->inv_size = Input::get('inv_size');

			$inventory->inv_manufacture = Input::get('inv_manufacture');
			$inventory->inv_carrier = Input::get('inv_carrier');
			$inventory->inv_room = Input::get('inv_room');
			
			$inventory->inv_storage_price = Input::get('inv_storage_price');
			$inventory->inv_mfg = Input::get('inv_mfg');
			$inventory->inv_qb = Input::get('inv_qb');
			$inventory->inv_item_status = Input::get('inv_item_status');
			$inventory->inv_delivery_status = Input::get('inv_delivery_status');
			$inventory->inv_warehouse = Input::get('inv_warehouse');

			$inventory->inv_bin = Input::get('inv_bin');
			$inventory->inv_binltr = Input::get('inv_binltr');
			$inventory->inv_note = Input::get('inv_note');
			$inventory->inv_private_note = Input::get('inv_private_note');

			if($inventory->save()){

			/*$itds_name = DB::table('itemdescriptions')->where('id', Input::get('inv_description'))->pluck('itds_name');
			$room_name = DB::table('rooms')->where('id', Input::get('inv_room'))->pluck('room_name');
			$manuf_name = DB::table('manufacturers')->where('id', Input::get('inv_manufacture'))->pluck('manuf_name');
			$invcat_name = DB::table('inventory_category')->where('id', Input::get('inv_category'))->pluck('invcat_name');*/
				if(Input::get('show_image_name')!=""){
					$invImages=Input::get('show_image_name');
					rtrim($invImages, ",");
					$invImages = explode(",", $invImages);

					$counti=0;
					foreach($invImages as $invImage){
						if($invImage !=''){
							$imgInv = new Inventoryimage;
							$imgInv->img_jobid = Input::get('job_id');
							$imgInv->img_invid = Input::get('id');	
							$imgInv->img_name = $invImage;
							$imgInv->save();
							if($counti==0){
								DB::table('inventories')->where('id', Input::get('id'))->update(array('inv_item_images' => $invImage));
							}
							$counti++;
						}
					}
				}
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

	public function searchInventoryAdmin(){
		$designerID=Auth::user()->id;
		$inventory_job_id = Input::get('jobSearch');
		$inv_category = Input::get('inv_category');
		$inv_room = Input::get('inv_room');
		$inv_item_status = Input::get('inv_item_status');
		$inv_idPo = Input::get('inv_idPo');
		$inv_sort = Input::get('inv_sort');
		$inv_sort_by = Input::get('inv_sort_by');

		//if($inventory_job_id!=''){
		$query = DB::table('inventories')->select('inventories.id',
								    'inventories.inv_pono',
								    'inventories.inv_mfg',
								    'inventories.inv_item_status',
								    'inventories.inv_item_images',
								    'inventories.inv_qrcode',
								    'inventories.inv_note',
								    'inventories.Job_id',
								    'inventories.inv_qb',
								    'inventories.inv_received',
								    'inventories.inv_quantity',
								    'inventories.inv_delivery_status',
								    'jobs.job_name',
								    'itemdescriptions.itds_name',
								    'rooms.room_name',
								    'warehouses.warehouse_name',
								    'bins.bin_name',
								    'binlrts.binlrt_name',
								    'inventory_category.invcat_name',
								    'manufacturers.manuf_name')
							->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
							->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
							->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
							->leftJoin('manufacturers', 'manufacturers.id', '=', 'inventories.inv_manufacture')	
							->leftJoin('jobs', 'jobs.id', '=', 'inventories.Job_id')
							->leftJoin('warehouses', 'warehouses.id', '=', 'inventories.inv_warehouse')
							->leftJoin('bins', 'bins.id', '=', 'inventories.inv_bin')		 
							->leftJoin('binlrts', 'binlrts.id', '=', 'inventories.inv_binltr');

						if (isset($inventory_job_id) && $inventory_job_id!='')
						    $query->where('inventories.job_id',$inventory_job_id);

						if (isset($inv_category) && $inv_category!='')
						    $query->where('inventories.inv_category',$inv_category);

						if (isset($inv_room) && $inv_room!='')
						    $query->where('inventories.inv_room',$inv_room);

						if (isset($inv_item_status) && $inv_item_status!='')
						    $query->where('inventories.inv_item_status',$inv_item_status);

						if (isset($inv_idPo) && $inv_idPo!='')
						    $query->where('inventories.id',$inv_idPo)->orWhere('inventories.inv_pono','LIKE', '%'.$inv_idPo.'%');

						if (isset($inv_sort) && $inv_sort!=''){
						    $query->orderBy($inv_sort, $inv_sort_by);
						}
						$inventories = $query->paginate(100);

						$searchJob = DB::table('jobs')->get();

					$view = View::make('adminTemplate.inventories.searchInventoryList')
					->with('inventories', $inventories);	
								return $view;	
								
	}

	public function searchInventoryManager(){
		$designerID=Auth::user()->id;
		$inventory_job_id = Input::get('jobSearch');
		$inv_category = Input::get('inv_category');
		$inv_room = Input::get('inv_room');
		$inv_item_status = Input::get('inv_item_status');
		$inv_idPo = Input::get('inv_idPo');
		$inv_sort = Input::get('inv_sort');
		$inv_sort_by = Input::get('inv_sort_by');

		//if($inventory_job_id!=''){
		$query = DB::table('inventories')->select('inventories.id',
								    'inventories.inv_pono',
								    'inventories.inv_mfg',
								    'inventories.inv_item_status',
								    'inventories.inv_item_images',
								    'inventories.inv_qrcode',
								    'inventories.inv_note',
								    'inventories.Job_id',
								    'inventories.inv_qb',
								    'jobs.job_name',
								    'itemdescriptions.itds_name',
								    'rooms.room_name',
								    'warehouses.warehouse_name',
								    'bins.bin_name',
								    'binlrts.binlrt_name',
								    'inventory_category.invcat_name',
								    'manufacturers.manuf_name')
							->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
							->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
							->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
							->leftJoin('manufacturers', 'manufacturers.id', '=', 'inventories.inv_manufacture')	
							->leftJoin('jobs', 'jobs.id', '=', 'inventories.Job_id')
							->leftJoin('warehouses', 'warehouses.id', '=', 'inventories.inv_warehouse')
							->leftJoin('bins', 'bins.id', '=', 'inventories.inv_bin')		 
							->leftJoin('binlrts', 'binlrts.id', '=', 'inventories.inv_binltr');

						if (isset($inventory_job_id) && $inventory_job_id!='')
						    $query->where('inventories.job_id',$inventory_job_id);

						if (isset($inv_category) && $inv_category!='')
						    $query->where('inventories.inv_category',$inv_category);

						if (isset($inv_room) && $inv_room!='')
						    $query->where('inventories.inv_room',$inv_room);

						if (isset($inv_item_status) && $inv_item_status!='')
						    $query->where('inventories.inv_item_status',$inv_item_status);

						if (isset($inv_idPo) && $inv_idPo!='')
						    $query->where('inventories.id',$inv_idPo)->orWhere('inventories.inv_pono','LIKE', '%'.$inv_idPo.'%');

						if (isset($inv_sort) && $inv_sort!=''){
						    $query->orderBy($inv_sort, $inv_sort_by);
						}
						$inventories = $query->paginate(100);

						$searchJob = DB::table('jobs')->get();

					$view = View::make('managerTemplate.inventories.searchInventoryList')
					->with('inventories', $inventories);	
								return $view;	
								
	}
	public function inventories(){
			

			$clients = DB::table('users')->where('role_id', 2)->get();	
			$itemdescriptions = DB::table('itemdescriptions')->get();	
			$manufacturers = DB::table('manufacturers')->get();	
			$carriers = DB::table('carriers')->get();	
			$inventorycategories = DB::table('inventory_category')->get();	
			$rooms = DB::table('rooms')->get();	
			$warehouses = DB::table('warehouses')->get();	
			$bins = DB::table('bins')->get();	
			$binlrts = DB::table('binlrts')->get();	
			$storagePrices = DB::table('storage_prices')->get();	
			$searchJob = DB::table('jobs')->get();	

			$view = View::make('adminTemplate.inventories.inventoryList')
					->with('title', 'Inventory List')
					->with('menu', 'inventorylist')
					->with('submenu', '')

			->with('clients', $clients)
			->with('itemdescriptions', $itemdescriptions)
			->with('manufacturers', $manufacturers)
			->with('carriers', $carriers)
			->with('inventorycategories', $inventorycategories)
			->with('rooms', $rooms)
			->with('warehouses', $warehouses)
			->with('bins', $bins)
			->with('searchJob', $searchJob)
			->with('binlrts', $binlrts)
			->with('storagePrices', $storagePrices);
			return $view;		
	}



	public function damagedInventories(){
			$roleID = Session::get('sessionRoleid');

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
							->whereIn('inventories.inv_item_status', array(2, 3, 4)) 	
							->where('inventories.inv_delivery_status', '!=', 4) 	
							->get();


			#if User is a Manager
			if($roleID==3){
				$view = View::make('managerTemplate.inventories.damageinventoryList')
						->with('title', 'Damaged Inventory List')
						->with('menu', 'Dashboard')
						->with('submenu', '')
					  	->with('inventories', $inventories);
				return $view;				
			}
			#if User is Admin
			else{
				$view = View::make('adminTemplate.inventories.damageinventoryList')
						->with('title', 'Damaged Inventory List')
						->with('menu', 'Dashboard')
						->with('submenu', '')
					  	->with('inventories', $inventories);
				return $view;				
			}				
		
	}

    #Retrive the requisted designer information from database
	public function getInventory($id)
    {
       if($id != "") {
	$inventories = DB::table('inventories')->select('inventories.*',
												'itemdescriptions.itds_name',
												'rooms.room_name',
												'jobs.job_name',
												'jobs.job_client_id',
												'jobs.job_customer_id')
										  ->leftJoin('jobs', 'jobs.id', '=', 'inventories.job_id')
										  ->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
										  ->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
	                                      ->where('inventories.id', $id)->first();

			$designerCompany = DB::table('users')->where('id', $inventories->job_client_id)->pluck('firm_name');
			$designer_Fname = DB::table('users')->where('id', $inventories->job_client_id)->pluck('first_name');
			$designer_Lname = DB::table('users')->where('id', $inventories->job_client_id)->pluck('last_name');
			$designerFullname= $designer_Fname.' '.	$designer_Lname; 

			//$customerFullName = DB::table('customers')->where('id', $inventories->job_customer_id)->pluck(DB::raw('CONCAT(customer_first_name, " ", customer_last_name) AS full_name'));



			$itemdescriptions = DB::table('itemdescriptions')->get();	
			$manufacturers = DB::table('manufacturers')->get();	
			$carriers = DB::table('carriers')->get();	
			$inventorycategories = DB::table('inventory_category')->get();	
			$rooms = DB::table('rooms')->get();	
			$warehouses = DB::table('warehouses')->get();	
			$bins = DB::table('bins')->where('bin_warehouse', $inventories->inv_warehouse)->get();	
			$binlrts = DB::table('binlrts')->where('binlrt_bin', $inventories->inv_bin)->get();	
			$incentoryImages = DB::table('inventoryimages')->where('img_invid', $id)->get();
			$storagePrices = DB::table('storage_prices')->get();	

			$jobs = DB::table('jobs')->select('jobs.id','jobs.job_name')
						->where('jobs.job_status', '!=', 3 )
						->orderBy('jobs.id', 'desc')
						->get();
			
			$view = View::make('adminTemplate.inventories.inventory') 
			->with('title', 'Inventory Details')
			->with('menu', 'Jobs')
			->with('submenu', '')
			->with('itemdescriptions', $itemdescriptions)
			->with('manufacturers', $manufacturers)
			->with('carriers', $carriers)
			->with('inventorycategories', $inventorycategories)
			->with('rooms', $rooms)
			->with('warehouses', $warehouses)
			->with('bins', $bins)
			->with('binlrts', $binlrts)
			->with('storagePrices', $storagePrices)
			->with('designerFullname', $designerFullname)
			->with('designerCompany', $designerCompany)
			->with('incentoryImages', $incentoryImages)
			->with('inventories', $inventories)
			->with('jobs', $jobs);
			return $view;	
        }
    }

    #Print the requisted inventory information
	public function printInventory($id)
    {
       if($id != "") {
	$inventories = DB::table('inventories')->select('inventories.*',
												'itemdescriptions.itds_name',
												'inventory_category.invcat_name',
												'rooms.room_name',
												'jobs.job_name',
												'jobs.job_client_id')
										  ->leftJoin('jobs', 'jobs.id', '=', 'inventories.job_id')
										  ->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
										  ->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
										  ->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
	                                      ->where('inventories.id', $id)->first();

			$designer_Fname = DB::table('users')->where('id', $inventories->job_client_id)->pluck('first_name');
			$designer_Lname = DB::table('users')->where('id', $inventories->job_client_id)->pluck('last_name');
			$designerFullname= $designer_Fname.' '.	$designer_Lname; 

			$manufacturers_name = DB::table('manufacturers')->where('id', $inventories->inv_manufacture)->pluck('manuf_name');
			$carriers_name = DB::table('carriers')->where('id', $inventories->inv_carrier)->pluck('carrier_name');

			$itemdescriptions = DB::table('itemdescriptions')->get();	
			$manufacturers = DB::table('manufacturers')->get();	
			$carriers = DB::table('carriers')->get();	
			$inventorycategories = DB::table('inventory_category')->get();	
			$rooms = DB::table('rooms')->get();	
			$warehouses = DB::table('warehouses')->get();	
			$bins = DB::table('bins')->where('bin_warehouse', $inventories->inv_warehouse)->get();	
			$binlrts = DB::table('binlrts')->where('binlrt_bin', $inventories->inv_bin)->get();	
			$incentoryImages = DB::table('inventoryimages')->where('img_invid', $id)->get();
			$storagePrices = DB::table('storage_prices')->get();	

			$jobs = DB::table('jobs')->select('jobs.id','jobs.job_name')
						->where('jobs.job_status', '!=', 3 )
						->orderBy('jobs.id', 'desc')
						->get();
			
			$view = View::make('adminTemplate.inventories.printInventory') 
			->with('title', 'Inventory Details')
			->with('menu', 'Jobs')
			->with('submenu', '')
			->with('itemdescriptions', $itemdescriptions)
			->with('manufacturers_name', $manufacturers_name)
			->with('carriers_name', $carriers_name)
			->with('inventorycategories', $inventorycategories)
			->with('rooms', $rooms)
			->with('warehouses', $warehouses)
			->with('bins', $bins)
			->with('binlrts', $binlrts)
			->with('storagePrices', $storagePrices)
			->with('designerFullname', $designerFullname)
			->with('incentoryImages', $incentoryImages)
			->with('inventories', $inventories)
			->with('jobs', $jobs);
			return $view;	
        }
    }


    public function inventoryJobidUpdate(){
    	$inventory_id = Input::get('inventoryID');
		$inventory_job_id = Input::get('updateJobID');
		$getFirmID = DB::table('jobs')->where('id', $inventory_job_id)->pluck('job_client_id');

		$inventory = Inventory::find($inventory_id);
		$inventory->job_id = $inventory_job_id;
		$inventory->firm_id = $getFirmID;
		if($inventory->save()){
				return Response::json(array('status' => 'updated', 'getFirmID' => $getFirmID),200);	
		}
		else{
			return Response::json(array('status' => 'Nothing to update'),200);	
		}			
    }


	public function createQr(){

			$inventory_id = Input::get('id');
			$inventory_job_id = Input::get('job_id');
			$inventory_job_name = Input::get('job_name');

			$inv_bin = Input::get('inv_bin');
			$inv_binltr= Input::get('inv_binltr');
			$job_client_id= Input::get('job_client_id');

			$inv_bin_name = DB::table('bins')->where('id', $inv_bin)->pluck('bin_name');
			$inv_binltr_name = DB::table('binlrts')->where('id', $inv_binltr)->pluck('binlrt_name');
			
			$designer_conmany = DB::table('users')->where('id', $job_client_id)->pluck('firm_name');
			$designer_Fname = DB::table('users')->where('id', $job_client_id)->pluck('first_name');
			$designer_Lname = DB::table('users')->where('id', $job_client_id)->pluck('last_name');

/*
) Inventory #
2) Bin #
3) Bin Ltr
4) Designer Name
5) Job Name
*/
			$url='ID:'.$inventory_id.'Designer Name '.$designer_Fname.' '.$designer_Lname.' Job Name:'.$inventory_job_name.' Bin:'.$inv_bin_name.'Bin Ltr:'.$inv_binltr_name;  
			$width = 200; 
			$height = 200; 
			$border = 1;
            $error = "L"; 
            $https = false; 
            $loadBalance = false;


			  $filename = "./qrcodes/".$inventory_id."_".$inventory_job_name.".png";
			  if (file_exists($filename))
			  {
			  	unlink($filename);
			  }

			    // build Google Charts URL:
			    // secure connection ?
			    $protocol = $https ? "https" : "http";
			    // load balancing
			    $host   = "chart.googleapis.com";
			    if ($loadBalance)
			      $host = abs(crc32($parameters) % 10).".chart.apis.google.com";
			    // safe URL
			    $url    = urlencode($url);
			    // put everything together
			    $qrUrl  = "$protocol://$host/chart?chs={$width}x{$height}&cht=qr&chld=$error|$border&chl=$url";
			    // get QR code from Google's servers
			    $qr     = file_get_contents($qrUrl);
			    // optimize PNG and save locally
			    $imgIn  = imagecreatefromstring($qr);
			    $imgOut = imagecreate($width, $height);
			    imagecopy($imgOut, $imgIn, 0,0, 0,0, $width,$height);
			    imagepng($imgOut, $filename, 9, PNG_ALL_FILTERS);
			    imagedestroy($imgIn);
			    imagedestroy($imgOut);

			  $inventory = Inventory::find($inventory_id);
			  $inventory->inv_qrcode = $filename;
			  if($inventory->save()){
				return Response::json(array('status' => $filename),200);	
				}
			}

	public function inventoryDetails($id) {
       if($id != "") {

			$inventories = DB::table('inventories')->select('inventories.*',
								    'itemdescriptions.itds_name',
								    'rooms.room_name',
								    'inventory_category.invcat_name',
								    'manufacturers.manuf_name',
								    'inventoryimages.img_invid',
									'carriers.carrier_name',
									'warehouses.warehouse_name',
									'bins.bin_name',
									'binlrts.binlrt_name',
								    'jobs.job_name')
							->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
							->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
							->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
							->leftJoin('manufacturers', 'manufacturers.id', '=', 'inventories.inv_manufacture')		
						    ->leftJoin('inventoryimages', 'inventories.inv_item_images', '=', 'inventoryimages.id')
						    ->leftJoin('jobs', 'jobs.id', '=', 'inventories.job_id')
						    ->leftJoin('carriers', 'carriers.id', '=', 'inventories.inv_carrier')
						    ->leftJoin('warehouses', 'warehouses.id', '=', 'inventories.inv_warehouse')
						    ->leftJoin('bins', 'bins.id', '=', 'inventories.inv_bin')
						    ->leftJoin('binlrts', 'binlrts.id', '=', 'inventories.inv_binltr')
							->where('inventories.id', $id)->first();




			// $inventories = DB::table('inventories')->select('inventories.*',
			// 									'jobs.job_name')
			// 							  ->leftJoin('jobs', 'jobs.id', '=', 'inventories.job_id')
	  //                                     ->where('inventories.id', $id)->first();

			$itemdescriptions = DB::table('itemdescriptions')->get();	
			$manufacturers = DB::table('manufacturers')->get();	
			$carriers = DB::table('carriers')->get();	
			$inventorycategories = DB::table('inventory_category')->get();	
			$rooms = DB::table('rooms')->get();	
			$warehouses = DB::table('warehouses')->get();
			$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();


			$bins = DB::table('bins')->where('bin_warehouse', $inventories->inv_warehouse)->get();	
			$binlrts = DB::table('binlrts')->where('binlrt_bin', $inventories->inv_bin)->get();	
			$incentoryImages = DB::table('inventoryimages')->where('img_invid', $id)->get();	
			
			$view = View::make('jobs.inventorydetails') 
			->with('title', 'Inventory Details')
			->with('menu', 'Jobs')
			->with('submenu', '')
			->with('itemdescriptions', $itemdescriptions)
			->with('manufacturers', $manufacturers)
			->with('carriers', $carriers)
			->with('inventorycategories', $inventorycategories)
			->with('rooms', $rooms)
			->with('warehouses', $warehouses)
			->with('bins', $bins)
			->with('binlrts', $binlrts)
			->with('advImage', $advImage)
			->with('incentoryImages', $incentoryImages)
			->with('inventories', $inventories);
			return $view;	
        }

	}


	public function designerInventory(){
		$designerID=Auth::user()->id;

		$inventories = DB::table('inventories')->select('inventories.id',
														'inventories.inv_item_images',
														'itemdescriptions.itds_name',
														'inventories.job_id',
													    'jobs.job_name')
									->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
								    ->leftJoin('jobs', 'jobs.id', '=', 'inventories.job_id')
								    ->whereIn('inventories.inv_delivery_status', array(2,3))
									->where('inventories.firm_id', $designerID)
									->orderBy('inventories.id', 'DESC')->get();
									
		$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();

			$jobs = DB::table('jobs')->select('jobs.id',
								    'jobs.job_name')
							->where('job_client_id', $designerID)->get();					

			$rooms = DB::table('rooms')->get();	
			$inventorycategories = DB::table('inventory_category')->get();										
			//print_r($jobs); die;
		$view = View::make('jobs.inventorylist') 
			->with('title', 'Inventory List')
			->with('menu', 'Inventories')
			->with('advImage', $advImage)
			->with('viewSearch', 'yes')
			->with('jobs', $jobs)
			->with('rooms', $rooms)
			->with('inventorycategories', $inventorycategories)
			->with('inventories', $inventories)
			->with('submenu', '');	
			return $view;						

	}


	public function searchInventory(){
		$designerID=Auth::user()->id;
		$inventory_job_id = Input::get('jobSearch');
		$inv_category = Input::get('inv_category');
		$inv_room = Input::get('inv_room');
		$inv_item_status = Input::get('inv_item_status');

		//if($inventory_job_id!=''){
		$query = DB::table('inventories')->select('inventories.id',
														'inventories.inv_item_images',
														'itemdescriptions.itds_name',
														'inventories.job_id',
													    'jobs.job_name')
									->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
								    ->leftJoin('jobs', 'jobs.id', '=', 'inventories.job_id')
								    ->where('inventories.inv_delivery_status','!=', 4)
									->where('inventories.firm_id', $designerID)
									->orderBy('inventories.id', 'DESC');

						if (isset($inventory_job_id) && $inventory_job_id!='')
						    $query->where('inventories.job_id',$inventory_job_id);

						if (isset($inv_category) && $inv_category!='')
						    $query->where('inventories.inv_category',$inv_category);

						if (isset($inv_room) && $inv_room!='')
						    $query->where('inventories.inv_room',$inv_room);

						if (isset($inv_item_status) && $inv_item_status!='')
						    $query->where('inventories.inv_item_status',$inv_item_status);

						$inventories = $query->get();

					$view = View::make('jobs.searchInventory') 
								->with('inventories', $inventories);	
								return $view;	

	}

	public function designerDamageInventory(){
		$designerID=Auth::user()->id;

			$jobs = DB::table('jobs')->select('jobs.id',
								    'jobs.job_name')
							->where('job_client_id', $designerID)->get();

		$inventories = DB::table('inventories')->select('inventories.id',
														'inventories.inv_item_images',
														'itemdescriptions.itds_name',
														'inventories.job_id',
													    'jobs.job_name')
									->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
								    ->leftJoin('jobs', 'jobs.id', '=', 'inventories.job_id')
								    ->where('inventories.inv_delivery_status','!=', 4)
								    ->whereIn('inventories.inv_item_status', array(2, 3, 4))
									->where('inventories.firm_id', $designerID)->get();
									
		$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();							

		$view = View::make('jobs.inventorylist') 
			->with('title', 'Damaged Inventory List')
			->with('menu', 'Dashboard')
			->with('advImage', $advImage)
			->with('inventories', $inventories)
			->with('jobs', $jobs)
			->with('submenu', '');	
			return $view;						

	}


	public function updateDeliveryStatus(){
		$inventory_id = Input::get('id');
		$updateType = Input::get('typeID');
		$inventory = Inventory::find(Input::get('id'));
		if($updateType== 'pull'){
			$inventory->inv_delivery_status = 3;
		}
		elseif ($updateType== 'delivery') {
			$inventory->inv_delivery_status = 4;
		}

		if($inventory->save()){
			return Response::json(array('status' => 'success'),200);	
		}


	}

	public function sendInventoryEmail(){
		$invId = Input::get('invId');
		$fromEmail = Input::get('fromEmail');
		$toEmail = Input::get('toEmail');	
		$eMessage = Input::get('eMessage');	

		$inventories = DB::table('inventories')->select('inventories.*',
												'itemdescriptions.itds_name',
												'inventory_category.invcat_name',
												'rooms.room_name',
												'jobs.job_name',
												'jobs.job_client_id')
										  ->leftJoin('jobs', 'jobs.id', '=', 'inventories.job_id')
										  ->leftJoin('itemdescriptions', 'itemdescriptions.id', '=', 'inventories.inv_description')
										  ->leftJoin('inventory_category', 'inventory_category.id', '=', 'inventories.inv_category')
										  ->leftJoin('rooms', 'rooms.id', '=', 'inventories.inv_room')
	                                      ->where('inventories.id', $invId)->first();


			$designer_Fname = DB::table('users')->where('id', $inventories->job_client_id)->pluck('first_name');
			$designer_Lname = DB::table('users')->where('id', $inventories->job_client_id)->pluck('last_name');
			$designerFullname= $designer_Fname.' '.	$designer_Lname; 

			$manufacturers_name = DB::table('manufacturers')->where('id', $inventories->inv_manufacture)->pluck('manuf_name');
			$carriers_name = DB::table('carriers')->where('id', $inventories->inv_carrier)->pluck('carrier_name');
			
			$incentoryImages = DB::table('inventoryimages')->where('img_invid', $invId)->get();
			
$itemStat ='';
if($inventories->inv_item_status == 1) 
	$itemStat = 'Received in good condition';
elseif($inventories->inv_item_status == 2) 
	$itemStat = 'Damaged';
elseif($inventories->inv_item_status == 3) 
	$itemStat = 'Being repaired – in house';
elseif($inventories->inv_item_status == 4) 
	$itemStat = 'Being repaired – out for repair';
elseif($inventories->inv_item_status == 5) 
	$itemStat = 'Awaiting call tag / awaiting pickup';
elseif($inventories->inv_item_status == 6) 
	$itemStat = 'Picked up';

$deLiveryStatus ='';

if($inventories->inv_delivery_status == 1) 
	$deLiveryStatus ='Not yet received';
elseif($inventories->inv_delivery_status == 2) 
	$deLiveryStatus ='In storage';
elseif($inventories->inv_delivery_status == 3) 
	$deLiveryStatus ='Pulled / loaded';
elseif($inventories->inv_delivery_status == 4) 
	$deLiveryStatus ='Delivered';

//now sending email to registered client
		    	$headers = "MIME-Version: 1.0" . "\r\n";
			    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			    $headers .= "From: info@vaultdesignerdelivery.com <info@vaultdesignerdelivery.com>" . "\r\n";
			    
			    $email_sub = "Vault: Inventory Details";


		 		
				$email_body = "<b>This Message is From:</b>" .$fromEmail.'<br /><br />';
				$email_body .= $eMessage .'<br /><br />';
				$email_body .= '<h3>Inventory Details:</h3><br /><hr /><br />';
				$email_body .= '<b>PO#</b>: '.$inventories->inv_pono.'<br />';
				$email_body .= '<b>Job Name</b>: '.$inventories->job_name.'<br />';
				$email_body .= '<b>Designer Name:</b>: '.$designerFullname.'<br /><br />';
				
				$email_body .= '<b>Item Description:</b>: '.$inventories->itds_name.'<br />';
				$email_body .= '<b>Category:</b>: '.$inventories->invcat_name.'<br />';
				$email_body .= '<b>Quantity:</b>: '.$inventories->inv_quantity.'<br />';
				$email_body .= '<b>Size:</b>: '.$inventories->inv_size.'<br />';
				$email_body .= '<b>Manufacturer:</b>: '.$manufacturers_name.'<br />';
				$email_body .= '<b>Carrier:</b>: '.$carriers_name.'<br />';
				$email_body .= '<b>Room:</b>: '.$inventories->room_name.'<br /><br />';


				$email_body .= '<b>Mfg #:</b>: '.$inventories->inv_mfg.'<br />';
				if($inventories->inv_received != '0000-00-00') 
					$email_body .= '<b>Date Received:</b>: '.$inventories->inv_received.'<br />';
				if($inventories->inv_delivered != '0000-00-00') 
					$email_body .= '<b>Date Delivered:</b>: '.$inventories->inv_delivered.'<br />';
				$email_body .= '<b>Item Status:</b>: '.$itemStat.'<br />';
				$email_body .= '<b>Delivery Status:</b>: '.$deLiveryStatus.'<br />';
				$email_body .= '<b>Images:</b>: <br />';

				if($incentoryImages){
					foreach($incentoryImages as $incentoryImage){
						if($incentoryImage->img_name !=''){
						
						$email_body .= '<img style="margin:5px; width:200px; height:150px;" src="http://app.vaultdesignerdelivery.com/public/without-flash-uploader/images/'.$incentoryImage->img_name.'"/>';
						
						}
					}
				}

				/*$email_body .= "Your user information:".'<br /><br />';*/
				
				$email_body .= '<hr /><br /><br />';
				  
				mail($toEmail,$email_sub,$email_body,$headers);


		return Response::json(array('status' => 'Good'),200);



	}
	public function deleteImages(){
		//Inventoryimage::find(Input::get('imgId'))->delete(); 
		$imgID = Input::get('imgId');
		$invID = Input::get('invID');
		$invImages = Inventoryimage::find(Input::get('imgId'));
		$inventory = Inventory::find(Input::get('invID'));

		
		if($inventory->inv_item_images == $invImages->img_name){

			$invImagesNew = Inventoryimage::where('id', '!=', $imgID)
										->where('img_invid', '=', $invID)
										->first();

			if($invImagesNew)	
				$inventory->inv_item_images=$invImagesNew->img_name;
			else						
				$inventory->inv_item_images='';
			$inventory->save();
		}
		Inventoryimage::find(Input::get('imgId'))->delete();
		$file = "without-flash-uploader/images/".$invImages->img_name;
			if (!unlink($file))
			  {
			  $stat = "Error deleting $file";
			  }
			else
			  {
			  $stat = "Deleted $file";
			  }

		
		return Response::json(array('status' => $stat, 'name'=> $invImages->img_name),200);
	}


	function deleteInventory(){
		$inventoryID=Input::get('id');

		$invImages = Inventoryimage::where('img_invid', '=', $inventoryID)
									  ->get();
			if($invImages){						  
				foreach ($invImages as $key) {
					$file = "without-flash-uploader/images/".$key->img_name;
					$thumb = "without-flash-uploader/images/thumb/".$key->img_name;
					if (file_exists($file)) {
					  unlink($file);
					  unlink($thumb);
					  }
					
			    }
		    }	

		    $inventoryInfo = Inventory::find($inventoryID);
		    if($inventoryInfo->inv_qrcode !=''){
		    	if (file_exists($inventoryInfo->inv_qrcode)) {
		    		unlink($inventoryInfo->inv_qrcode);
		    	}
		    }
		    //$file = "without-flash-uploader/images/".$inventoryInfo->inv_item_images;
		   

		Inventory::find($inventoryID)->delete();
		return Response::json(array('status' => 'deleted'),200);
	}


public function inventoryInlineUpdate(){
		$inventory_id = Input::get('id');
		$updateType = Input::get('col');
		$updateValue = strip_tags(Input::get('val'));
		$inventory = Inventory::find(Input::get('id'));

		if($updateType== 1){
			$inventory->inv_pono = $updateValue;
		}
		elseif ($updateType== 2) {
			$inventory->inv_description = $updateValue;
		}
		elseif ($updateType== 3) {
			$inventory->inv_room = $updateValue;
		}
		elseif ($updateType== 4) {
			$inventory->inv_manufacture = $updateValue;
		}
		elseif ($updateType== 5) {
			$inventory->inv_mfg = $updateValue;
		}
		elseif ($updateType== 6) {
			$inventory->inv_category = $updateValue;
		}
		elseif ($updateType== 7) {
			$inventory->inv_item_status = $updateValue;
		}
		elseif ($updateType== 8) {
			$inventory->inv_note = $updateValue;
		}
		elseif ($updateType== 9) {
			$inventory->inv_qb = $updateValue;
		}


		if($inventory->save()){
			return Response::json(array('status' => 'success'),200);	
		}
}


}