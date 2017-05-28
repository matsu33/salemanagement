<?php

class Controller_Sosanhgia extends Controller_Base
{
	public $tableName = 'prices';
	
	/**
	 * Load the template and create the $this->template object if needed
	 */
	public function before ()
	{
		parent::before();
		
		if (! $this->is_restful()) {
			$arrJS = array('sosanhgia.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}
	
	/**
	 * view index page
	 */
	public function action_index()
	{
		$this->template->title = Lang::get('title_compare_price');
		$this->template->content = View::forge('sosanhgia/index');
	}

	/*****************************************************************************
	 ***API *********************************************************************
	 *****************************************************************************/
	/**
	 * search product price list
	 */
	public function action_search()
	{
		//init variable
		$result = null;
		$status = true;
		$message = Lang::get('m_no_error');
		$data = null;
		$query = null;
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$category_id = Input::param('category_id');
				$material_id = Input::param('material_id');
				$diameter = Input::param('diameter');
				$length = Input::param('length');
				$product_range = Input::param('product_range');
		
				//init sql
				$querySelect = DB::select(
											"product_id",
											"category_name",
											"material_name",
											"diameter",
											"length",
											"product_range",
											"unit_name",
											"image",
											"wholesales_price",
											"wholesales_price2",
											"wholesales_price3",
											"retail_price",
// 											DB::expr("MAX(wholesales_price) AS wholesales_price"),
// 											DB::expr("MAX(retail_price) AS retail_price"),
											"selected_price"
											)
				->from($this->tableName)
				->join('products','LEFT')
				->on($this->tableName.'.product_id', '=', 'products.id')
				->join('categories','LEFT')
				->on('products.category_id', '=', 'categories.id')
				->join('materials','LEFT')
				->on('products.material_id', '=', 'materials.id')
				->join('sizes','LEFT')
				->on('products.size_id', '=', 'sizes.id')
				->join('units','LEFT')
				->on('products.unit_id', '=', 'units.id');
				
				if($category_id){
					$querySelect->where('category_id',$category_id);
				}
				if($material_id){
					$querySelect->and_where('material_id',$material_id);
				}
				if($diameter){
					$querySelect->and_where('diameter',$diameter);
				}
				if($length){
					$querySelect->and_where('length',$length);
				}
				if($product_range){
					$querySelect->and_where('product_range',$product_range);
				}
				$querySelect->group_by("product_id");
				$querySelect->order_by($this->tableName.'.update_at','DESC');
				
				$data = $querySelect->execute()->as_array();
				
				$query = DB::last_query();
			}else{
				$status = false;
				$message = Lang::get('e_not_valid_method');
			}
		}catch (Exception $e){
			$status = false;
			$message = Lang::get('e_common_sql');
		}
		
		//set result
		$result = array('status' => $status, 'message' => $message, 'data' => $data, 'query' => $query);
		
		//return
		return $result;
	}

	/**
	 * get publisher price of product
	 */
	public function action_searchPublisherPrice()
	{
		//init variable
		$result = null;
		$status = true;
		$message = Lang::get('m_no_error');
		$data = null;
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$product_id = Input::param('product_id');
		
				//init sql
				$querySelect = DB::select(
											"publisher_id",
											"publisher_name",
											"input_price",
											"selected_price",
											"wholesales_rate",
											"wholesales_rate2",
											"wholesales_rate3",
											"retail_rate"
											)
				->from($this->tableName)
				->join('publishers','LEFT')
				->on($this->tableName.'.publisher_id', '=', 'publishers.id');
				
				$querySelect->where('product_id',$product_id);
				
				$data = $querySelect->execute()->as_array();
			}else{
				$status = false;
				$message = Lang::get('e_not_valid_method');
			}
		}catch (Exception $e){
			$status = false;
			$message = Lang::get('e_common_sql');
		}
		
		//set result
		$result = array('status' => $status, 'message' => $message, 'data' => $data);
		
		//return
		return $result;
	}
	
	/**
	 * setSelectedPublisher
	 */
	public function action_setSelectedPublisher()
	{
		$result = null;
		$status = true;
		$message = '';
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				//init query update
				$query = DB::update($this->tableName);
				
				$product_id = Input::post('product_id');
				$publisher_id = Input::post('publisher_id');
				$wholesales_rate = Input::post('wholesales_rate');
				$wholesales_rate2 = Input::post('wholesales_rate2');
				$wholesales_rate3 = Input::post('wholesales_rate3');
				$retail_rate = Input::post('retail_rate');
				
				DB::start_transaction();
				//===Update unselect all category of product to 0
				$query = DB::update($this->tableName);
				//set data
                $query->set(array(
                    'selected_price' => 0,
                    'wholesales_price' => 0,
                    'retail_price' => 0,
                    'wholesales_rate' => 0,
                		'wholesales_rate2' => 0,
                		'wholesales_rate3' => 0,
                    'retail_rate' => 0
                ))
                ->where('product_id',$product_id);
				//excute
                $query->execute();
				
				//===Update price to selected product
				$query2 = DB::update($this->tableName);
				//set data
                $query2->set(array(
                    'wholesales_price' => DB::expr('input_price + input_price * '.$wholesales_rate/100),
                		'wholesales_price2' => DB::expr('input_price + input_price * '.$wholesales_rate2/100),
                		'wholesales_price3' => DB::expr('input_price + input_price * '.$wholesales_rate3/100),
                    'retail_price' => DB::expr('input_price + input_price * '.$retail_rate/100),
                    'selected_price' => 1,
                    'wholesales_rate' => $wholesales_rate,
                		'wholesales_rate2' => $wholesales_rate2,
                		'wholesales_rate3' => $wholesales_rate3,
                    'retail_rate' => $retail_rate
                ))
                ->where('product_id',$product_id)
				->and_where('publisher_id',$publisher_id);
				//var_dump($query2->compile());exit;
				//excute
                $query2->execute();
				
				DB::commit_transaction();
				
				$message = Lang::get('m_update_success');
			} else {
				//invalid method GET
				$status = false;
				$message = Lang::get('e_not_valid_method');
			}
		}catch (Exception $e){
			$status = false;
			$message = Lang::get('e_common_sql');
		}
		$result = array('status' => $status, 'message' => $message, 'sql' => $query2->compile());
		return $result;
	}
	
	/**
	 * print list product price
	 * 
	 * @reference: https://github.com/PHPOffice/PHPExcel/blob/develop/Examples/01simple-download-xls.php
	 */
	public function action_print()
	{
		$category_id = Input::post('category_id');
		$material_id = Input::post('material_id');
		var_dump($category_id);
		var_dump($category_name);
		var_dump($material_id);
		var_dump($category_name);
		exit;
		//var_dump('print abc');
		Package::load("excel");
    	
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");
		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', 'Hello')
		            ->setCellValue('B2', 'world!')
		            ->setCellValue('C1', 'Hello')
		            ->setCellValue('D2', 'world!');
		// Miscellaneous glyphs, UTF-8
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A4', 'Miscellaneous glyphs')
		            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="01simple.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function action_save()
	{
		$data["subnav"] = array('save'=> 'active' );
		$this->template->title = 'Sosanhgia &raquo; Save';
		$this->template->content = View::forge('sosanhgia/save', $data);
	}

}
