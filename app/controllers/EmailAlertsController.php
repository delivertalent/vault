<?php
class EmailAlertsController extends BaseController {

	public function emailAlarts(){
		$receipents = DB::table('users')->select('id','first_name','last_name','email')->where('email_alerts', 1)
									   ->get();
		foreach ($receipents as $receipent) {
			 /*Dear valued Designer, 

			 This is a notification that an order has been received at Vault for one of your clients. 
			 Please check your online Virtual Vault account for details and photographs. 

			 Thank you as always for your continued business! 
			 Vault Designer Delivery | Moving and Storage*/


				//now sending email to registered client
		    	$headers = "MIME-Version: 1.0" . "\r\n";
			    $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			    $headers .= "From: warehouse@vaultmovingandstorage.com  <warehouse@vaultmovingandstorage.com>" . "\r\n";
			    
			    $email_sub = "Vault: Order Received Notification";


		 		$email_body = "Dear valued Designer".',<br /><br />';
				$email_body .= "This is a notification that an order has been received at Vault for one of your clients.".'<br />';
				$email_body .= "Please check your online Virtual Vault account for details and photographs.".'<br /><br />';
				
				$email_body .= "Thank you as always for your continued business! ".'<br />';
			    $email_body .= '<small>Vault Designer Delivery | Moving and Storage</small><br/>'; 
				$email_body .= '<hr /><br /><br />';
				  
				if(mail($receipent->email,$email_sub,$email_body,$headers)){
					$designer = User::find($receipent->id);
					$designer->email_alerts = 0;
					$designer->save();
				}		
		}							   
									   
	}
}