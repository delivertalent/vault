<?php

class AdminjobController extends BaseController {

	public function adminjobList()
	{
		//
		if(Auth::check()){
			$title = "Jobs List";
			$states = DB::table('us_states')->select('state_code','state_full')->orderBy('state_full', 'asc')->get();
			
			$jobs = DB::table('jobs')->select('jobs.id',
								    'jobs.job_client_id',
								    'jobs.job_name',
								    'jobs.job_status',
								    'customers.customer_last_name',
								    'aditional_designers.designer_name')
							->leftJoin('customers', 'customers.id', '=', 'jobs.job_customer_id')
							->leftJoin('aditional_designers', 'aditional_designers.id', '=', 'jobs.job_designer_id')
							->get();

			$designers = DB::table('users')->select('id','firm_name')->where('role_id', 2)
										   ->where('status', 1)->get();

			$view = View::make('adminTemplate.adminjob.adminjob')
				  ->with('menu', 'Jobs')
				  ->with('submenu', '')		
				  ->with('states', $states)		
				  ->with('designers', $designers)		
				  ->with('jobs', $jobs)				
			      ->with('title',$title);
			return $view;			
		}		
	}

	public function clientJobList()
	{
		$clientID = Input::get('clientID'); 
		$jobs = DB::table('jobs')->select('jobs.id','jobs.job_name')
						->where('jobs.job_client_id', $clientID)
						->orderBy('jobs.id', 'desc')
						->get();

		$view = View::make('adminTemplate.adminjob.jobList')		
			  ->with('jobs', $jobs);
		return $view;
	}

}
