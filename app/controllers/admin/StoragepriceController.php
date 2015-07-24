<?php

class StoragepriceController extends BaseController {

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


	public function storageIndex()
	{
		//
		if(Auth::check()){
			$title = "Storage";
			
			//$storagePrices = DB::table('storage_prices')->get();

			$storagePrices = DB::select("SELECT res.* 
								         FROM	(SELECT CONCAT(users.first_name,' ' ,users.last_name) as designerName ,jobs.job_name, inventories.job_id, SUM( storage_prices.price ) as price
												FROM inventories
												LEFT JOIN jobs ON inventories.job_id = jobs.id
												LEFT JOIN users ON jobs.job_client_id = users.id
												LEFT JOIN storage_prices ON storage_prices.id = inventories.inv_storage_price
												WHERE inventories.inv_delivery_status != 4
												GROUP BY `job_id`) as res
										ORDER BY res.designerName ");

								

			$view = View::make('adminTemplate.storageprices.storageIndex')
				  ->with('menu', 'Storage')
				  ->with('submenu', '')			
				  ->with('storagePrices', $storagePrices)		
			      ->with('title',$title);
			return $view;			
		}		
	}
public function exportReport(){

  /*$data = array(
    array("firstname" => "Mary", "lastname" => "Johnson", "age" => 25),
    array("firstname" => "Amanda", "lastname" => "Miller", "age" => 18),
    array("firstname" => "James", "lastname" => "Brown", "age" => 31),
    array("firstname" => "Patricia", "lastname" => "Williams", "age" => 7),
    array("firstname" => "Michael", "lastname" => "Davis", "age" => 43),
    array("firstname" => "Sarah", "lastname" => "Miller", "age" => 24),
    array("firstname" => "Patrick", "lastname" => "Miller", "age" => 27),
  );*/

$data2 = DB::select("SELECT res.* 
								         FROM	(SELECT CONCAT(users.first_name,' ' ,users.last_name) as designerName ,jobs.job_name, inventories.job_id, SUM( storage_prices.price ) as price
												FROM inventories
												LEFT JOIN jobs ON inventories.job_id = jobs.id
												LEFT JOIN users ON jobs.job_client_id = users.id
												LEFT JOIN storage_prices ON storage_prices.id = inventories.inv_storage_price
												WHERE inventories.inv_delivery_status != 4
												GROUP BY `job_id`) as res
										ORDER BY res.designerName ");


//$data2=(array)$data;
$data = array();


  foreach($data2 as $row) {
  	$arrayname=array();
  	$arrayname['Designer Name'] = $row->designerName;
  	$arrayname['Job Name'] = $row->job_name;
  	$arrayname['Price'] = $row->price;
  	 array_push($data, $arrayname);

  }


  function cleanData(&$str)
  {
    // escape tab characters
    $str = preg_replace("/\t/", "\\t", $str);

    // escape new lines
    $str = preg_replace("/\r?\n/", "\\n", $str);

    // convert 't' and 'f' to boolean values
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';

    // force certain number/date formats to be imported as strings
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }

    // escape fields that include double quotes
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // file name for download
  $filename = "vault-storage-price-" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  foreach($data as $row) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\n";
      $flag = true;
    }
    array_walk($row, 'cleanData');
    echo implode("\t", array_values($row)) . "\n";
  }

  exit;


}
	public function storagePriceList()
	{
		//
		if(Auth::check()){
			$title = "Storage Price";
			
			$storagePrices = DB::table('storage_prices')->get();
			$view = View::make('adminTemplate.storageprices.storageprice')
				  ->with('menu', 'Configuration')
				  ->with('submenu', 'StoragePrice')			
				  ->with('storagePrices', $storagePrices)		
			      ->with('title',$title);
			return $view;			
		}		
	}


	public function saveStoragePrice(){
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, customer_first_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			/*#Check Duplicate Email
			$count = DB::table('customers')->where('customer_email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email*/


			$storageprice = new StoragePrice;
			$storageprice->price = Input::get('price');

			if($storageprice->save()){
				$isertedID = $storageprice->id;
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


			$storageprice = StoragePrice::find(Input::get('id'));
			$storageprice->price = Input::get('price');
			if($storageprice->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

    #Retrive the requisted designer information from database
	public function getStoragePrice()
    {
       if(Input::get('id') != "") {
   			$storageprice = StoragePrice::find(Input::get('id'));
	        return Response::json($storageprice);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteStoragePrice()
    {   
		StoragePrice::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================



}