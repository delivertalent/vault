<?php

class Inventory extends Eloquent {
    protected $guarded = array();
    
    protected $table = 'inventories';
    
    protected $primaryKey = 'id';
    
}