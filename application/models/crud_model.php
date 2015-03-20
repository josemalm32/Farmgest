<?php

class CRUD_model extends CI_Model {

    // ------------------------------------------------------------------------

    protected $_table;
    protected $_primary_key;
    // ------------------------------------------------------------------------

    /**
     * Change the fetch mode if desired
     *
     * @var string $_fetch_mode Optionally set to 'object', default is array
     */
    protected $_fetch_mode = 'array';

    // ------------------------------------------------------------------------

    /**
     * Construct the CI_Model
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
    }

    // ------------------------------------------------------------------------

    /**
     * For using the class without a model
     *
     * @param string $table  Name of the table
     * @param string $primary_key  Name of the tables Primary Key
     */
    public function setOptions($table, $primary_key = false)
    {
        $this->_table = $table;
        $this->_primary_key = $primary_key;
    } 

    // ------------------------------------------------------------------------

    /**
     * Grabs data from a table
     *       OR a single record by passing $id,
     *       OR a different field than the primary_key by passing two paramters
     *       OR by passing an array
     *
     * @param integer|string $id_or_row (Optional)
     *           null    = Fetch all table records
     *           number  = Fetch where primary key = $id
     *           string  = Fetch based on a different column name
     *           array   = Fetch based on array criteria
     *
     * @param integer|string $optional_value (Optional)
     * @param string         $order_by (Optional)
     *
     * @return object database results
     */
    public function get($id_or_row = null, $optional_value = null, $order_by = null)
    {
        // Custom order by if desired
        if ($order_by != null) {
            $this->db->order_by($order_by);
        }

        // Fetch all records for a table
        if ($id_or_row == null) {
            $query = $this->db->get($this->_table);
        } elseif (is_array($id_or_row)) {
            $query = $this->db->get_where($this->_table, $id_or_row);
        } else {
            if ($optional_value == null) {
                $query = $this->db->get_where($this->_table, array($this->_primary_key => $id_or_row));
            } else {
                $query = $this->db->get_where($this->_table, array($id_or_row => $optional_value));
            }
        }

        if ($this->_fetch_mode == 'array') {
            return $query->result_array();
        } else {
            return $query->result();
        }
    }
}
?>
    