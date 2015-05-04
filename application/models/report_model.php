<?php

class report_model extends CI_Model
{
	protected $_table = 'rep_configuration';
    protected $_primary_key = 'id';
    protected $_query_code = 'query_code';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    /*
     * function get query from the function that call its and send template name
     * export the query to xls file with the template name
     */

    public function export_excel($query=null, $template=null)
    {
    	require_once APPPATH.'Classes/PHPExcel.php';

    	$result = mysql_query($query) or die (mysql_error());

    	$objPHPExcel = new PHPExcel();
    	$objPHPExcel->setActiveSheetIndex(0);  
    	
		// Initialise the Excel row number 
		$rowCount = 1;  
		//start of printing column names as names of MySQL fields  
		$column = 'A';


		for ($i = 1; $i < mysql_num_fields($result); $i++)  
		{
		    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
		    $column++;
		}
		//end of adding column names  
		
		//start while loop to get data  
		$rowCount = 2;  
		while($row = mysql_fetch_row($result))  
		{  
		    $column = 'A';
		    for($j=1; $j<mysql_num_fields($result);$j++)  
		    {  
		        if(!isset($row[$j]))  
		            $value = NULL;  
		        elseif ($row[$j] != "")  
		            $value = strip_tags($row[$j]);  
		        else  
		            $value = "";  

		        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
		        $column++;
		    }  
		    $rowCount++;
		}

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		
		
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		if($template !=null){
			$objWriter->save($template); 
			//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
			return 1;
		}
		
		else{
			$objWriter->save('save.xls');
			//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
			return 1;
		}
		
		return null;

    }
/*
    public function export_word($query = null, $template = null){

    	require_once APPPATH.'PhpWord/Autoloader.php';

    	use PhpOffice\PhpWord\Autoloader;
		use PhpOffice\PhpWord\Settings;
		
		Autoloader::register();
		Settings::loadConfig();

		error_reporting(E_ALL);

    	$phpWord = new PhpWord();

    	

    }*/

    public function getReports($query_code=null, $)
    {     
        if (is_numeric($query_code)) {
            $this->db->where($this->_query_code, $query_code);
        } 
        
        if (is_array($query_code)) {
            foreach ($query_code as $_key => $_value) {
                $this->db->where($_key, $_value);
            }
        }
        $q = $this->db->get($this->_table);
        return $q->result_array();
    }
    }
    
}