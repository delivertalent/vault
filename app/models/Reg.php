<?php

class Reg extends Eloquent {
    protected $guarded = array();
    
    protected $table = 'users';
    
    protected $primaryKey = 'id';

    public static $rules = array(
    	'userid' => 'required|min:2|unique:users,userid',
		'email' => 'required|email|unique:users,email',
		'password' => 'required|min:4'
	);
    
   
    public static $rules2 = array(
    		'email' => 'required|email',
    		'password' => 'required|min:4'
    );
    
    
    public static function validate($data){
    	return Validator::make($data, static::$rules);
    }
    
    public static function validate2($data){
    	return Validator::make($data, static::$rules2);
    }
    
    
}