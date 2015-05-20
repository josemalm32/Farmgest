<?php

class farm_model extends CRUD_model
{
    protected $_table = 'farms';
    protected $_primary_key = 'id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}