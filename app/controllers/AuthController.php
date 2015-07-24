<?php
use Illuminate\Support\Facades\Input;
class AuthController extends BaseController{
	
	public function indexview(){
		$title = "Homepage";
		$view = View::make('auth.home')
		-> with('title',$title);
		return $view;
	}
	
	
	public function loginview(){
		$title = "Login";
		return View::make('auth.login')
		->with('title',$title);
	}
	
	public function forgetPass(){
		$email = Input::get('elementEmail');
		$result = DB::table('users')->where('email', $email)->first();
		if($result){
			$gui = str_random(8);
			$designer = User::find($result->id);
			$designer->guid = $gui;


			if($designer->save()){
				//return Response::json(array('status' => 'updated'),200);	
					
				//$link =  route('update-password'.$gui);
				$link =  'http://'.$_SERVER['HTTP_HOST'].'/vault/public/update-password/'.$gui;
		        $data = array('userName'  => $result->last_name, 
		        			  'userEmail'  => $result->email, 
		        			  'link'  => $link 
		        			  );
		        $subject = 'Vault: Reset Password Request';
				

				//now sending email to registered client
		    	$headers = "MIME-Version: 1.0" . "\r\n";
			    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			    $headers .= "From: vault@ncbeta.net <noreply@ncbeta.net>" . "\r\n";
			    
			    $email_sub = "Vault: Reset Password Request";


		 		$email_body = "Dear ".$designer->last_name.',<br /><br />';
				$email_body .= "Someone requested that the password be reset for the following account:".'<br /><br />';
				/*$email_body .= "Your user information:".'<br /><br />';*/
				$email_body .= "User Email: ".$designer->email.'<br /><br />';

			    $email_body .= 'If this was a mistake, just ignore this email and nothing will happen.<br/>'; 
			    $email_body .= 'To reset your password, visit the following address:<br/>'; 
				$email_body .= 'URL: <a href="'.$link.'">'.$link.'</a><br /><br/>';
				$email_body .= "Thank you..<br/><br/>";
				$email_body .= '<hr /><br /><br />';
				  
				mail($designer->email,$email_sub,$email_body,$headers);
		        
				return Response::json(array('status' => 'success'),200);
			}			

		}
		else{
			$msg = array('userid'=>'Email does not match');
			return Response::json(array('status' => 'notMatch'),200);
		}
	}	



	public function loginuser(){
		$validation = Reg::validate2(Input::all());
		//echo "hello";
		if($validation->fails()){
			$message = $validation->messages();
			return Redirect::Route('login')->with('errors',$message)->withInput();
		}
		else{
			$email = Input::get('email');
			$password = Input::get('password');
						
			if (Auth::attempt(array('email' => $email, 'password' => $password)))
			{
				$result = DB::table('users')->where('email', $email)->first();
				//print_r($result );
				Session::put('sessionEmail', $email);
				Session::put('sessionRoleid', $result->role_id);
				if($result->role_id ==1 )
					return Redirect::Route('dashboard'); #if the user is admin(role_id =1).
				elseif($result->role_id ==3 )
					return Redirect::Route('manager-dashboard'); #if the user is Manager(role_id =3).
				else
					return Redirect::Route('auth'); #if the user is Designer(role_id =2).
			}
			else
			{
				$msg = array('userid'=>'userid or password does not match');
				return Redirect::Route('login')->with('message', 'userid or password does not match')->withInput();
			}
			
		}
		
	}
	
	public function logoutuser(){
		Auth::logout();
		//$userid = Session::get('userid');
		Session::flush();
		return Redirect::Route('auth');
	}

	public function updatePassword($id){
		$result = DB::table('users')->where('guid', $id)->first();
		$invalidUrl=1;
		if($result){
			$invalidUrl="";
		}
			$title = "Reset Password";
			return View::make('auth.resetpass')
			->with('title',$title)
			->with('guid',$id)
			->with('invalidUrl',$invalidUrl);

		

	}		

	public function setPassword(){
		$validation = Reg::validate2(Input::all());
		//echo "hello";
		$guID = Input::get('guID');
		if($validation->fails()){
			$message = $validation->messages();
			return Redirect::Route('update-password',$guID)->with('errors',$message)->withInput();
		}
		else{
			$email = Input::get('email');
						
			$result = DB::table('users')->where('email', $email)->where('guid', $guID)->first();
			if ($result)
			{				
				//print_r($result );
				$password = Input::get('password');
				$newPassword = Hash::make($password);
				DB::table('users')->where('id', $result->id)->update(array('password' => $newPassword,'guid' => ''));

					return Redirect::Route('auth'); #if the user is Designer(role_id =2).
			}
			else
			{
				$msg = array('userid'=>'Userid or Activation key does not match.');
				return Redirect::Route('update-password',$guID)->with('message', 'Userid or Activation key does not match')->withInput();
			}
			
		}
		
	}
	
}
