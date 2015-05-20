<?php

class fertilization_model extends CRUD_model
{
    protected $_table = 'prod_fertilization';
    protected $_primary_key = 'id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}