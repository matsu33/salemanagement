<?php
use Fuel\Core\Lang;
use Fuel\Core\Package;

/**
 * Using for export excel
 * 
 * @author Nguyen Van Tung
 * @since 2014/12/01
 * Tham khảo: https://github.com/muhittin/fuelphp_excel
 */
class Excelhelper
{
	public static function export($templateName = NULL, $fileName = NULL, $saveDir = NULL, $data = NULL){
		//Load management message file
		$lang = Lang::load('index');
		
		//init status(1:success, 0:fail) and message success
		$status = 1;
		$message = Lang::get('m_export_excel_success');
		
		//trigger exception in a "try" block
		try {
			//get template
			if(!$templateName){
				$templateName = 'tpl.xls';
			}
			//get file name
			if(!$fileName){
				$fileName = 'Temp';
			}
			//init saved folder
			if(!$saveDir){
				$saveDir = 'D:\test\\';
			}
				
			//init file name
			$fileName = $fileName .'_'. date('ymd') . '_' . date('His') . '.xls';
				
			//get template directory
			$tpl_dir = APPPATH.'tmp/';
				
			//load excel package
			\Package::load('excel');
				
			//load template excel
			$phpexcel = \PHPExcel_IOFactory::load($tpl_dir.$templateName);
				
			//get sheet1
			$sheet = $phpexcel->getSheetByName('Sheet1');
				
			//set excel data
			self::setData($sheet, $data);
				
			//init writer
			$writer = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel5');
				
			//write to file
			$writer->save($saveDir.$fileName);
		} catch (Exception $e) {
			$status = 0;
			$message = $e->getMessage();
		}
		$result = array('status' => $status, 'message' => $message);
		return $result;
	}
	
	public static function setData(&$sheet, $data = NULL){
		//sample
		$sheet->setCellValueExplicit('A2', '09000000000', \PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('B2', '佐村河内屋菊水丸', \PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('C2', '不詳', \PHPExcel_Cell_DataType::TYPE_STRING);
	}
}