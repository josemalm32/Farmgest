<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
    Class Custom_export_model extends grocery_CRUD_model {
     
    	public function __construct() { parent::__construct(); 

    }



	public function exportToExcel($state_info = null)
	{
		$data = $this->get_common_data();

		$data->order_by 	= $this->order_by;
		$data->types 		= $this->get_field_types();

		$data->list = $this->get_list();
		$data->list = $this->change_list($data->list , $data->types);
		$data->list = $this->change_list_add_actions($data->list);

		$data->total_results = $this->get_total_results();

		$data->columns 				= $this->get_columns();
		$data->primary_key 			= $this->get_primary_key();

		@ob_end_clean();
		$this->_export_to_excel($data);
	}

	public function _export_to_excel($data)
	{
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);

		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		date_default_timezone_set('Europe/London');

		/** PHPExcel_IOFactory */
		require_once dirname(__FILE__) . '/Classes/PHPExcel/IOFactory.php';

		$string_to_export = "";
		
		foreach($data->columns as $column){
			$i++;
			$string_to_export .= $column->display_as."\t";
		}
		$string_to_export .= "\n";

		//get all and divide by columns
		$result = count($data) / $i;

		foreach($data->list as $num_row => $row){
			foreach($data->columns as $column){
				$string_to_export .= $this->_trim_export_string($row->{$column->field_name})."\t";
			}
			$string_to_export .= "\n";
		}

		// Convert to UTF-16LE and Prepend BOM
		$string_to_export = "\xFF\xFE" .mb_convert_encoding($string_to_export, 'UTF-16LE', 'UTF-8');

		$filename = "export-".date("Y-m-d_H:i:s").".xls";

		header('Content-type: application/vnd.ms-excel;charset=UTF-16LE');
		header('Content-Disposition: attachment; filename='.$filename);
		header("Cache-Control: no-cache");
		echo $string_to_export;
		die();
	}