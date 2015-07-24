<?php

/*
Class:                      DesignersController

Resposponsibity:            CREATE, READ, UPDATE & DELETE of Zone

Collaborator:               Routing:  /landmark, 
                                      /saveUsers, /deleteUsers/{id}, /getUsersByRoleID
                            Model: N/A
                            View: User.blade.php
                            JavaScript: User.js

Methods:                  
                            5. getUsers() -> Ajax request to get user
                            6. saveUsers() -> Ajax request to save user
                            7. deleteUsers($id) -> Ajax request to delete user
                          
*/


class DesignersController extends BaseController {
	#display list of all designer.	
	public function index() {
		if (Auth::check()){
			$userid = Auth::user()->id; 
			# role_id =1 admin User
			# role_id =2 Designer
			$states = DB::table('us_states')->select('state_code','state_full')->orderBy('state_full', 'asc')->get();
			$designers = DB::table('users')->where('role_id', 2)->get();				
			
			$view = View::make('adminTemplate.designer.index') 
			->with('title', 'Manage Clients')
			->with('menu', 'Designer')
			->with('submenu', '')
			->with('userid', $userid)
			->with('states', $states)
			->with('designers', $designers);
			return $view;
	    }
	}
	
	
	
//========================================================================

	#Add and Update Designer information
	public function addDesigner(){


		$userID=Auth::user()->id;
		if(Input::get('id') == ""){
			#Add Designer information
			#parameter List: did, firm_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email 
			
			#Check Duplicate Email
			$count = DB::table('users')->where('email', Input::get('email'))->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email

			$newPassword = str_random(6);

			$designer = new User;
			$designer->firm_name = Input::get('firm_name');
			$designer->first_name = Input::get('first_name');
			$designer->last_name = Input::get('last_name');
			$designer->primary_address = Input::get('primary_address');
			$designer->primary_address_two = Input::get('primary_address_two');

			$designer->city = Input::get('city');
			$designer->state = Input::get('state');
			$designer->phone = Input::get('phone');
			$designer->email = Input::get('email');
			$designer->zip_code = Input::get('zip_code');
			$designer->password = Hash::make($newPassword);
			$designer->status = 3;
			$designer->role_id = 2;

			if($designer->save()){
				$isertedID = $designer->id;

					$link =  route('login');
			        $data = array('userName'  => $designer->last_name, 
			        			  'userEmail'  => $designer->email, 
			        			  'userPassword'  => $newPassword, 
			        			  'link'  => $link 
			        			  );
			    $subject = 'Vault: Clients Account Created Successfully';


				//now sending email to registered client
		    	$headers = "MIME-Version: 1.0" . "\r\n";
			    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			    $headers .= "From: warehouse@vaultmovingandstorage.com  <warehouse@vaultmovingandstorage.com>" . "\r\n";
			    
			    $email_sub = "Vault: Clients Account Created Successfully";


		 		$email_body = "Dear ".$designer->last_name.',<br /><br />';
				$email_body .= "Welcome to http://app.vaultdesignerdelivery.com/public  Please find your sign in credentials below".'<br /><br />';
				/*$email_body .= "Your user information:".'<br /><br />';*/
				$email_body .= "Email: ".$designer->email.'<br />';
				$email_body .= "Password: ".$newPassword.'<br /><br />';
			    $email_body .= 'You can login below and change your password<br/>'; 
				$email_body .= 'URL: <a href="'.$link.'">'.$link.'</a><br />';
				$email_body .= "Please save this email for future reference.<br/><br/>";
				$email_body .= '<hr /><br /><br />';
				  
				if(mail($designer->email,$email_sub,$email_body,$headers)){
					return Response::json(array('status' => 'success','isertedID' => $isertedID),200);
				}
				else{
					return Response::json(array('status' => 'Fails','isertedID' => $isertedID),200);
				}

			        // sending mail:
			       /* Mail::send('emails.emailTemp', $data, function($message) use ($designer,$subject)
			            {
			                $message->to($designer->email , $designer->last_name)->subject($subject);
			            });*/
					
			}
		}
		else
		{
			#update designer information.
			#parameter List: did, firm_name, first_name, last_name, primary_address, primary_address_two, city, state, phone, email

			#Check Duplicate Email
			$count = DB::table('users')->where('email', Input::get('email'))
									   ->where('id','!=', Input::get('id'))
									   ->count();	
			if($count > 0){
				return Response::json(array('status' =>"idExists", 'message' =>"Email Address: ".Input::get('email')." Already Exists."),200);
			}
			#End of Check Duplicate Email


			$designer = User::find(Input::get('id'));
			$designer->firm_name = Input::get('firm_name');
			$designer->first_name = Input::get('first_name');
			$designer->last_name = Input::get('last_name');
			$designer->primary_address = Input::get('primary_address');
			$designer->primary_address_two = Input::get('primary_address_two');
			$designer->city = Input::get('city');
			$designer->state = Input::get('state');
			$designer->phone = Input::get('phone');
			$designer->email = Input::get('email');
			$designer->zip_code = Input::get('zip_code');
			$designer->status = Input::get('status');
			if($designer->save()){
				return Response::json(array('status' => 'updated'),200);	
			}
			else{
				return Response::json(array('status' => 'Nothing to update'),200);	
			}
		}
	}

//========================================================================

	public function resentActivationEmail(){
		$designer = User::find(Input::get('id'));
		if($designer->status!=1){
			$newPassword = str_random(6);
			$designer->password = Hash::make($newPassword);

			if($designer->save()){
				$isertedID = $designer->id;

				$link =  route('login');   
			    $subject = 'Vault: Clients Account Created Successfully';


				//now sending email to registered client
		    	$headers = "MIME-Version: 1.0" . "\r\n";
			    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			    $headers .= "From: warehouse@vaultmovingandstorage.com  <warehouse@vaultmovingandstorage.com>" . "\r\n";
			    
			    $email_sub = "Vault: Clients Account Created Successfully";


		 		$email_body = "Dear ".$designer->last_name.',<br /><br />';
				$email_body .= "Welcome to http://app.vaultdesignerdelivery.com/public  Please find your sign in credentials below".'<br /><br />';
				/*$email_body .= "Your user information:".'<br /><br />';*/
				$email_body .= "Email: ".$designer->email.'<br />';
				$email_body .= "Password: ".$newPassword.'<br /><br />';
			    $email_body .= 'You can login below and change your password<br/>'; 
				$email_body .= 'URL: <a href="'.$link.'">'.$link.'</a><br />';
				$email_body .= "Please save this email for future reference.<br/><br/>";
				$email_body .= '<hr /><br /><br />';
				  
				if(mail($designer->email,$email_sub,$email_body,$headers)){
					mail('admin@vaultmovingandstorage.com',$email_sub,$email_body,$headers);
					return Response::json(array('status' => 'success','isertedID' => $isertedID),200);
				}
				else{
					return Response::json(array('status' => 'Fails','isertedID' => $isertedID),200);
				}		
			}
		}
		return Response::json(array('status' => $designer->status),200);

	}
//========================================================================
    #Retrive the requisted designer information from database
	public function leadDesignerList()
    {
       if(Input::get('clientID') != "") {
   			$adiDesigners = DB::table('aditional_designers')
   									->select('id','designer_name')
									->where('firm_id', Input::get('clientID'))
									->orderBy('designer_name', 'asc')
									->get();
									
			$view = View::make('adminTemplate.adminjob.aditionalDesignerList') 
			->with('adiDesigners', $adiDesigners);
			return $view;
        }
    }

//========================================================================



//========================================================================

    #Retrive the requisted designer information from database
	public function getDesigner()
    {
       if(Input::get('id') != "") {
   			$designer = User::find(Input::get('id'));
	        return Response::json($designer);	
        }
    }

//========================================================================

    #Delete Designer Information.
	public function deleteDesigner()
    {   
		User::find(Input::get('id'))->delete();
		return Response::json(array('status' => 'deleted'),200);
        
    }

//========================================================================
     #Designer Details Information.
	public function detailDesigner($designerID)
    {   
		if (Auth::check()){
			$userid = Auth::user()->id; 
			# role_id =1 admin User
			# role_id =2 Designer
			
			$designer = DB::table('users')->select('users.id',
									'users.first_name',
								    'users.last_name',
								    'users.firm_name',
								    'users.email',
								    'users.primary_address',
								    'users.primary_address_two',
								    'users.city',
								    'users.zip_code',
								    'users.phone',
								    'us_states.state_full')
							->leftJoin('us_states', 'us_states.state_code', '=', 'users.state')
							->where('role_id', 2)->where('id', $designerID)->first();	


			$states = DB::table('us_states')->select('state_code','state_full')->orderBy('state_full', 'asc')->get();

			$customers = DB::table('customers')->select('id','customer_first_name','customer_last_name')
												->where('customer_firm_id', $designerID)
												->orderBy('id', 'asc')->get();

			$adiDesigners = DB::table('aditional_designers')->select('id','designer_name')
														 ->where('firm_id', $designerID)
														 ->orderBy('designer_name', 'asc')->get();



			$jobs = DB::table('jobs')->select('jobs.id',
									'jobs.job_client_id',
								    'jobs.job_name',
								    'jobs.job_status',
								    'customers.customer_last_name',
								    'aditional_designers.designer_name')
							->leftJoin('customers', 'customers.id', '=', 'jobs.job_customer_id')
							->leftJoin('aditional_designers', 'aditional_designers.id', '=', 'jobs.job_designer_id')
							->where('job_client_id', $designerID)->orderBy('id', 'desc')->get();

			$workorders = DB::table('workorders')->select('workorders.*','jobs.job_name')
									->leftJoin('jobs', 'jobs.id', '=', 'workorders.wo_jobid')
									->where('wo_firmid', $designerID)
									->orderBy('workorders.id', 'desc')->get();

			$view = View::make('adminTemplate.designer.details') 
			->with('title', 'Clients Details')
			->with('menu', 'Designer')
			->with('submenu', '')
			->with('userid', $userid)
			->with('states', $states)
			->with('customers', $customers)
			->with('adiDesigners', $adiDesigners)
			->with('jobs', $jobs)
			->with('workorders', $workorders)
			->with('designer', $designer);
			return $view;
	    }
        
    }  

    function adminAdditionalDesigner($id){


			$designer = DB::table('users')->select('users.id',
									'users.first_name',
								    'users.last_name',
								    'users.firm_name',
								    'users.email',
								    'users.primary_address',
								    'users.primary_address_two',
								    'users.city',
								    'users.zip_code',
								    'users.phone',
								    'us_states.state_full')
							->leftJoin('us_states', 'us_states.state_code', '=', 'users.state')
							->where('role_id', 2)->where('id', $id)->first();

$adiDesigners = DB::table('aditional_designers')->where('firm_id', $id)
												->orderBy('designer_name', 'asc')->get();


			$view = View::make('adminTemplate.designer.aditionalDesigners') 
			->with('title', 'Clients Details')
			->with('menu', 'Designer')
			->with('submenu', '')
			->with('userid', $id)
			->with('additionalDesigners', $adiDesigners)
			->with('designer', $designer);
			return $view;    	

    }
//========================================================================	
}
	