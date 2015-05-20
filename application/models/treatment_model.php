<?php

class treatment_model extends CRUD_model
{
    protected $_table = 'prod_treatment';
    protected $_primary_key = 'id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}