<?php

class Inventory_model extends CRUD_model
{
    protected $_table = 'inventory_management';
    protected $_primary_key = 'id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}