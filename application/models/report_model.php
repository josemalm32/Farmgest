<?php

class report_model extends CI_Model
{
	protected $_table = 'rep_configuration';
    protected $_primary_key = 'id';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    /*
     * function get query from the function that call its and send template name
     * export the query to xls file with the template name
     */

    public function export_excel($id)
    {
    	require_once APPPATH.'Classes/PHPExcel.php';
    	
    	echo $id, "= id";
    	$data = $this->get($id);
    	
    	$objPHPExcel = new PHPExcel();

    	$objPHPExcel->setActiveSheetIndex(0);  
    	
    	foreach($data as $rows){
    		$result = mysql_query($rows['query_sql']) or die (mysql_error());
    		$rowCount = intval($rows['start_line']);
    		$column = $rows['title_cell'];
    	}

    	
    	
		// Initialise the Excel row number 
		
		//start of printing column names as names of MySQL fields  
		


		for ($i = 1; $i < mysql_num_fields($result); $i++)  
		{
		    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
		    $column++;
		}
		//end of adding column names  
		
		//start while loop to get data  
		$rowCount = $rowCount+1;  
		while($row = mysql_fetch_row($result))  
		{  
		    $column = 'B';
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

		//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		
		
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		//if($template !=null){
		//	$objWriter->save($template); 
			//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
		//	return 1;
		//}
		
		//else{
		//	$objWriter->save('php://output');
			//echo date('H:i:s') , " Write to Excel2007 format" , EOL;
			return 1;
		//}
		
		//return null;

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

    public function get($id = null)
    {       
        if (is_numeric($id)) {
            $this->db->where($this->_primary_key, $id);
        } 
        
        $q = $this->db->get($this->_table);
        return $q->result_array();
    }
    

    
}