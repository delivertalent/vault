<?php

/*
Class:                      DashboardsController
Resposponsibity:            Display Admin Dashboard Information.
Collaborator:               Routing:  
                                      
                            Model: N/A
                            View: User.blade.php
                            JavaScript: User.js
                       
*/


class DashboardsController extends BaseController {
		
	public function indexview(){
		$title = "Dashboard";

			$newworkorders = DB::table('workorders')->whereNotIn('wo_status', array(4, 5))->count();
			$damaged = DB::table('inventories')->whereIn('inv_item_status', array(2, 3, 4))->where('inv_delivery_status','!=', 4)->count();

			$totalPrice = DB::table('inventories')->where('inv_delivery_status','!=', 4)
							->leftJoin('storage_prices', 'storage_prices.id', '=', 'inventories.inv_storage_price')
							->sum('storage_prices.price');

			/*$workorders = DB::table('workorders')->select('workorders.*','jobs.job_name','users.firm_name')
									->leftJoin('jobs', 'jobs.id', '=', 'workorders.wo_jobid')
									->leftJoin('users', 'users.id', '=', 'workorders.wo_firmid')
									->where('wo_status', 5)
									->orderBy('workorders.id', 'desc')->get();*/

			$workorders = DB::table('workorders')->select('workorders.*','jobs.job_name','users.firm_name')
									->leftJoin('jobs', 'jobs.id', '=', 'workorders.wo_jobid')
									->leftJoin('users', 'users.id', '=', 'workorders.wo_firmid')
									->orderBy('workorders.id', 'desc')
									->where('workorders.wo_status', '!=', 5)
									->get();
						


		$view = View::make('auth.home')
		->with('menu', 'Dashboard')
		->with('submenu', '')
		->with('workorders',$workorders)
		->with('newworkorders',$newworkorders)
		->with('damaged',$damaged)
		->with('totalPrice',$totalPrice)
		->with('title',$title);
		return $view;
	}	
}
	