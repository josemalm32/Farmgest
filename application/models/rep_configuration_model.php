<?php

class rep_configuration_model extends CRUD_model
{
    protected $_table = 'rep_configuration';
    protected $_primary_key = 'id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}