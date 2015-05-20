<?php

class fieldsection_model extends CRUD_model
{
    protected $_table = 'prod_fields_sections';
    protected $_primary_key = 'id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}