<?php

class report_model extends CI_Model
{
    
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
/*
		echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
		echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
		// Echo memory usage
		echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


		// Echo memory peak usage
		echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

		// Echo done
		echo date('H:i:s') , " Done writing file" , EOL;
		echo 'File has been created in ' , getcwd() , EOL;
		
*/
    }

    public function export_word($query = null, $template = null){

    	require_once APPPATH.'PhpWord/Autoloader.php';

    	\PhpOffice\PhpWord\Autoloader::register();

    	$phpWord = new \PhpOffice\PhpWord\PhpWord();

    	

    }
    
}