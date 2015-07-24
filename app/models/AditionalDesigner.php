<?php

class AditionalDesigner extends Eloquent {
    protected $guarded = array();
    
    protected $table = 'aditional_designers';
    
    protected $primaryKey = 'id';

/*    public static $rules = array(
    	'userid' => 'required|min:2|unique:users,userid',
		'email' => 'required|email|unique:users,email',
		'password' => 'required|min:4'
	);
      
    public static function validate($data){
    	return Validator::make($data, static::$rules);
    }*/
    

    
    
}