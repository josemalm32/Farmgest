<?php

class Todo_model extends CRUD_model
{
    protected $_table = 'g_tasks_users';
    protected $_primary_key = 'id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}