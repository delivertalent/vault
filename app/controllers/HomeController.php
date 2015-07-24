<?php

class HomeController extends BaseController {

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

	public function showWelcome()
	{
		if (Auth::check()){
			$title = "Homepage";
			$designerID=Auth::user()->id;
			$jobs = DB::table('jobs')->where('job_client_id', $designerID)->count();
			$aditionalDesigners = DB::table('aditional_designers')->where('firm_id', $designerID)->count();

			$newworkorders = DB::table('workorders')->where('wo_status', 1)->where('wo_firmid', $designerID)->count();
			$damaged = DB::table('inventories')->where('firm_id', $designerID)
											   ->where('inv_delivery_status','!=', 4)
											   ->whereIn('inv_item_status', array(2, 3, 4))
											   ->count();

			$totalInventory = DB::table('inventories')->where('firm_id', $designerID)
											   ->where('inv_delivery_status','!=', 4)
											   ->count();
			
			$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();

			$designerInfo = User::find($designerID);
			$view = View::make('home.home')
				  ->with('menu', 'Dashboard')
				  ->with('submenu', '')		
				  ->with('totalInventory', $totalInventory)		
				  ->with('designerInfo', $designerInfo)		
				  ->with('newworkorders', $newworkorders)		
				  ->with('jobs', $jobs)		
				  ->with('advImage', $advImage)		
				  ->with('aditionalDesigners', $aditionalDesigners)		
				  ->with('damaged', $damaged)		
			      -> with('title',$title);
			return $view;
		}
	}

	
	public function userProfile(){
		if (Auth::check()){
			$title = "Profile";
			$designerID=Auth::user()->id;
			$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();

			$designerInfo = User::find($designerID);
			$states = DB::table('us_states')->select('state_code','state_full')->orderBy('state_full', 'asc')->get();
			$view = View::make('home.profile')
				  ->with('menu', 'Setting')
				  ->with('submenu', 'profile')		
				  ->with('advImage', $advImage)		
				  ->with('states', $states)		
				  ->with('designerInfo', $designerInfo)		
			      -> with('title',$title);
			return $view;
		}
	}

	public function updateProfile(){
		if(Auth::check()){
			$designerID=Auth::user()->id;
			$designer = User::find($designerID);
			$designer->firm_name = Input::get('firm_name');
			$designer->first_name = Input::get('first_name');
			$designer->last_name = Input::get('last_name');
			$designer->primary_address = Input::get('primary_address');
			$designer->primary_address_two = Input::get('primary_address_two');

			$designer->city = Input::get('city');
			$designer->state = Input::get('state');
			$designer->phone = Input::get('phone');
			$designer->zip_code = Input::get('zip_code');

			if($designer->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}			
		}
	}


	public function updateStatus(){
		if(Auth::check()){
			$designerID=Auth::user()->id;
			$designer = User::find($designerID);
			$designer->password = Hash::make(Input::get('userPassword'));
			$designer->status = 1;

			if($designer->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}			
		}
	}

	public function additionalDesigner(){
		if(Auth::check()){
			$title = "Additional User";
			$designerID=Auth::user()->id;
			$designerInfo = User::find($designerID);
			$advImage = DB::table('advertises')->orderBy(DB::raw('RAND()'))->take(1)->first();
			$additionalDesigners = DB::table('aditional_designers')->where('firm_id', $designerID)->get();
			$view = View::make('home.additionalDesigner')
				  ->with('menu', 'Setting')
				  ->with('submenu', 'additionalDesigner')	
				  ->with('advImage', $advImage)		
				  ->with('designerInfo', $designerInfo)		
				  ->with('additionalDesigners', $additionalDesigners)		
			      ->with('title',$title);
			return $view;			
		}
	}


//========================================================================

	#Add and Update Additional Designer information
	public function saveAdditionalDesigner(){


		$designerID=Auth::user()->id;

			if (Input::has('fromAdmin')){
			   $designerID = Input::get('fromAdmin');
			}
		
		if(Input::get('id') == ""){
			#Add Additional Designer information
			#parameter List: designer_name, designer_email, designer_phone
			
			#Check Duplicate Email
			$count = DB::table('aditional_designers')->where('designer_email', Input::get('designer_email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('designer_email')." Already Exists."),200);
			}
			#End of Check Duplicate Email

			$designer = new AditionalDesigner;
			$designer->designer_name = Input::get('designer_name');
			$designer->designer_email = Input::get('designer_email');
			$designer->designer_phone = Input::get('designer_phone');
			$designer->firm_id = $designerID;
			

			if($designer->save()){
				$isertedID = $designer->id;
				return Response::json(array('status' => 'success','isertedID' => $isertedID),200);	
			}
		}
		else
		{
			#update additional designer information.
			#parameter List: designer_name, designer_email, designer_phone

			#Check Duplicate Email
			$count = DB::table('aditional_designers')->where('designer_email', Input::get('designer_email'))
									   ->where('id','!=', Input::get('id'))
									   ->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email


			$designer = AditionalDesigner::find(Input::get('id'));
			$designer->designer_name = Input::get('designer_name');
			$designer->designer_email = Input::get('designer_email');
			$designer->designer_phone = Input::get('designer_phone');
			
			if($designer->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

//========================================================================

    #Retrive the requisted designer information from database
	public function getAdditionalDesigner()
    {
       if(Input::get('id') != "") {
   			$designer = AditionalDesigner::find(Input::get('id'));
	        return Response::json($designer);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteAdditionalDesigner()
    {   
		AditionalDesigner::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================




}