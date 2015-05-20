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
    	require_once APPPATH.'Classes/PHPExcel/IOFactory.php';

    	// get data from rep configuration  where row id = id
    	$queryResult = $this->get($id);

    	
    	$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load($queryResult[0]['template_location']);

    	$objPHPExcel->getProperties()->setCreator("Nutrimondego,Lda")
                             ->setLastModifiedBy("Nutrimondego,Lda")
                             ->setTitle("Office 2007 XLS Test Document")
                             ->setSubject("Office 2007 XLS Test Document")
                             ->setDescription("Examples.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");


        //set active sheet 
    	$objPHPExcel->setActiveSheetIndex(0); 

    	//get data from system and set data in specific cell
    	$dateTimeNow = time(); 
    	$objPHPExcel->getActiveSheet()->setCellValue('E1', PHPExcel_Shared_Date::PHPToExcel( $dateTimeNow ));
    	$objPHPExcel->getActiveSheet()->getStyle('E1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
    	
    	// execute query from query sql from rep configuration
    	$result = mysql_query($queryResult[0]['query_sql']) or die (mysql_error());

    	
		// Initialise the Excel row number 
		$rowCount = $queryResult[0]['start_line'];
		//start of printing column names as names of MySQL fields  
		$column = $queryResult[0]['title_cell'];

		for ($i = 1; $i < mysql_num_fields($result); $i++)  
		{
		    $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, mysql_field_name($result,$i));
		    $objPHPExcel->getActiveSheet()->getStyle($column.$rowCount)->applyFromArray(array("font" => array( "bold" => true)));
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
		        $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		        $objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
		        $column++;
		    }  
		    $rowCount++;
		}

		//echo __FILE__,"    ";
		//echo __DIR__."\\report_model.xls";
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		
		
		
		if($queryResult[0]['template_location'] !=null){

			// Write the Excel file to filename some_excel_file.xlsx in the current directory
			$objWriter->save(str_replace('.php', '.xls', __FILE__));

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="report.xls"');
			header('Cache-Control: max-age=0');
			// read excel
			$objReader = PHPExcel_IOFactory::createReader('Excel5');
			$objPHPExcel = $objReader->load(__DIR__."\\report_model.xls");
			//write and save excel created above and force download
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');

			return 1;

		}

		return 0;

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
        if (is_array($id)) {
            foreach ($id as $_key => $_value) {
                $this->db->where($_key, $_value);
            }
        }
        $q = $this->db->get($this->_table);
        return $q->result_array();
    }

}