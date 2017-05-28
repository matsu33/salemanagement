<?php

class Controller_Customerdebt extends Controller_Base
{
	public $tableName = 'orders';
	public $tableOrderDetail = 'orderdetails';
	public $tableProducts = 'products';
	public $tableProductGroup = 'productgroups';
	
	/**
	 * Load the template and create the $this->template object if needed
	 */
	public function before ()
	{
		parent::before();
	
		if (! $this->is_restful()) {
			$arrJS = array('customerdebt.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}
	
	public function action_index()
	{
		$this->template->title = Lang::get('title_customer_debt');
		$this->template->content = View::forge('customerdebt/index');
	}

	/*****************************************************************************
	 ***API *********************************************************************
	 *****************************************************************************/
	/**
	 * search
	 * @return multitype:boolean string |multitype:boolean unknown |multitype:boolean NULL
	 */
	public function action_excuteSearch()
	{
		$data = null;
	
		if (Input::method() == 'POST') {
			 
			$date_from   = Input::param('date_from');
			$date_to     = Input::param('date_to');
			$publisherid     = Input::param('customerid');
			$datetype = Input::param('datetype');
			
			
			$querySelect = DB::select("orders.create_at",
											"orders.customer_id",
											"orders.customer_type",
											"orders.date_paid",
											"orders.debt",
											"orders.id",
											"orders.order_type",
											"orders.paid",
											"customer_id",
											"customer_name",
											"orders.status",
											"orders.total",
											"orders.update_at",
											"orders.user_id")->from('orders');
			$querySelect->join('customers','left')->on('orders.customer_id', '=', 'customers.id');
// 			$querySelect->join('customers','left')->on('orders.customer_id', '=', 'customers.id');
			$querySelect->where('orders.order_type', '=', Constant::ORDER_TYPE_WHOLESALE);
			$querySelect->where('orders.customer_type', '=', Constant::TYPE_CUSTOMER_WHOLESALE);
// 			$querySelect->where('orders.status', '=', 1);
			$querySelect->where('orders.create_at', '>=', $date_from);
			$querySelect->where('orders.create_at', '<=', $date_to);
			if($publisherid){
				$querySelect->where('orders.customer_id', '=', $publisherid);
			}
// 			$querySelect->where('orders.order_type', Constant::ORDER_TYPE_WHOLESALE);
			
// 			$querySelect->where('orders.status', '1');
// 			$querySelect->order_by('orders.date_paid');
			$data = $querySelect->execute()->as_array();
	
			if (count($data) <= 0) {
				return array(
						'status' => false,
						'message' => 'Không tìm thấy đơn hàng nào!'
				);
			}
	
			return array(
					'status' => true,
					'data' => $data
			);
		}
	
		return array(
				'status' => false,
				'message' => Lang::get('e_not_valid_method')
		);
	}

	/**
	 * paid
	 */
	public function action_paid()
	{
		$result = null;
		$status = true;
		$message = '';
	
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				//init query update
				$query = DB::update($this->tableName);
				
				$data = json_decode(Input::post('dataPost'));
				$orderListId = $data->data;
	
				//set data
				$query->set(array(
						'paid' => DB::expr('total'),
						'debt' => 0,
						'date_paid' => DB::expr('update_at'),
						'status' => 2
				));
				$query->where('id','IN',$orderListId);
				//excute
				$query->execute();
	
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
		$result = array('status' => $status, 'message' => $message);
		return $result;
	}
	
	public function action_excel()
	{
		if (Input::method() == 'POST') {
			$postData = Input::param('data');
			$postData = json_decode($postData, true);
	
			// EXCEL temporary path
			$tpl_dir = APPPATH . 'tmp/';
	
			// Load excel
			\Package::load('excel');
			// Load temporary excel
			$objPHPExcel = \PHPExcel_IOFactory::load($tpl_dir . 'tpl_phieu_doi_chieu_cong_no.xls');
			// Set active sheet
			$activeSheet = $objPHPExcel->setActiveSheetIndex(0);
	
			$count       = 14;
			foreach ($postData as $key => $value) {
				$activeSheet->setCellValue('B' . $count, $value['date']);
				$activeSheet->setCellValue('J' . $count, $value['debt']);
				$count++;
			}
	
			// Rename worksheet
			$activeSheet->setTitle('phieu_doi_chieu_cong_no');
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);
	
			$timestamp = time();
			$fileName = "phieu_doi_chieu_cong_no_".$timestamp.".xls";
			// Redirect output to a client’s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$fileName.'"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
			// If you're serving to IE over SSL, then the following may be needed
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
			header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header('Pragma: public'); // HTTP/1.0
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		}
	}
	
	public function action_getOrderDetail()
	{
		$data = null;
	
		if (Input::method() == 'POST') {
	
			$order_id   = Input::param('order_id');
				
			$querySelect = DB::select("orderdetails.id",
					"orderdetails.order_id",
					"image",
					"orderdetails.product_id",
					"category_id","category_name",
					"material_id","material_name",
					"size_id","diameter","length","product_range",
					"unit_id","unit_name",
					"orderdetails.order_type",
					"orderdetails.quanlity",
					"orderdetails.price",
					"orderdetails.money",
					"orderdetails.create_at",
					"orderdetails.update_at")
			->from('orderdetails');
			$querySelect->join('products','left')->on('orderdetails.product_id', '=', 'products.id');
// 			$querySelect->and_on('orderdetails.order_id', '=', DB::expr($order_id));
			$querySelect->join('categories','left')->on('products.category_id', '=', 'categories.id');
			$querySelect->join('materials','left')->on('products.material_id', '=', 'materials.id');
			$querySelect->join('sizes','left')->on('products.size_id', '=', 'sizes.id');
			$querySelect->join('units','left')->on('products.unit_id', '=', 'units.id');
			$querySelect->where("orderdetails.order_id", "=", $order_id);
			
			$data = $querySelect->execute()->as_array();
	
			if (count($data) <= 0) {
				return array(
						'status' => false,
						'message' => 'Không tìm thấy đơn hàng nào!'
				);
			}
	
			return array(
					'status' => true,
					'data' => $data
			);
		}
	
		return array(
				'status' => false,
				'message' => Lang::get('e_not_valid_method')
		);
	}
}
