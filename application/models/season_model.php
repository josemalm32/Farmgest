<?php

class season_model extends CRUD_model
{
    protected $_table = 'prod_season';
    protected $_primary_key = 'id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}