<?php

class UsState extends Eloquent{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'us_states';
	protected $guarded = array();
    protected $primaryKey = 'state_code';


}