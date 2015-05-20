<?php

class season_problems_model extends CRUD_model
{
    protected $_table = 'prod_season_problems';
    protected $_primary_key = 'id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}