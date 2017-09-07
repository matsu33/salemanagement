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
		$customer_id = Input::param('customer_id') ? Input::param('customer_id') : '';
		$search_date = Input::param('search_date') ? urldecode(Input::param('search_date')) : '';
		$search_day = Input::param('search_day') ? urldecode(Input::param('search_day')) : '';
		$search_month = Input::param('search_month') ? urldecode(Input::param('search_month')) : '';
		$search_year = Input::param('search_year') ? Input::param('search_year') : '';
		$search_type = Input::param('search_type') ? Input::param('search_type') : '1';

		$data = null;
		$data ['customer_id'] = $customer_id;
		$data ['search_date'] = urlencode($search_date);
		$data ['search_day'] = urlencode($search_day);
		$data ['search_month'] = urlencode($search_month);
		$data ['search_year'] = $search_year;
		$data ['search_type'] = $search_type;

		$currentDateFromTo = $this->getFromToDate($search_type, $search_date);
		$date_from = $currentDateFromTo['from'];
		$date_to = $currentDateFromTo['to'];

		$page = Input::param ( 'page' ) ? Input::param ( 'page' ) : 1;

		$customerSearchUrl = $customer_id == '' ? '' : '&customer_id='.$customer_id;
		$dateSearchUrl = $search_date == '' ? '' : '&search_date='.urlencode($search_date);
		$daySearchUrl = $search_day == '' ? '' : '&search_day='.urlencode($search_day);
		$monthSearchUrl = $search_month == '' ? '' : '&search_month='.urlencode($search_month);
		$yearSearchUrl = $search_year == '' ? '' : '&search_year='.$search_year;
		$typeSearchUrl = $search_type == '' ? '' : '&search_type='.$search_type;

		// pagination config
		$config = array (
			// 'pagination_url' => '/manage/company',
			'pagination_url' => '/no_khach_hang/index?'.$customerSearchUrl.$dateSearchUrl.$typeSearchUrl.$daySearchUrl.$monthSearchUrl.$yearSearchUrl,
			'total_items' => 0,
			'per_page' => PRODUCT_PER_PAGE,
			'uri_segment' => 'page',
			'show_first' => true,
			'show_last' => true
		);

		// Create a pagination instance named 'mypagination'
		$pagination = Pagination::forge ( 'mypagination', $config );

		$selectColumns = array(
//			"orders.create_at",
//			"orders.customer_id",
//			"orders.customer_type",
//			"orders.date_paid",
//			"orders.debt",
//			"orders.id",
//			"orders.order_type",
//			"orders.paid",
			"customer_id",
			"customer_name",
//			"orders.status",
//			"orders.total",
//			"orders.update_at",
//			"orders.user_id",
//			DB::expr ('GROUP_CONCAT(case when orders.status = 2 then orders.id end SEPARATOR \',\' ) as listDebtOrderId'),
			DB::expr ('GROUP_CONCAT(orders.id SEPARATOR \',\' ) as listOrderId'),
			DB::expr ('YEAR(orders.create_at) as year'),
			DB::expr ('SUM(case when orders.status = 1 then 1 else 0 end) AS paidCount'),
			DB::expr ('SUM(case when orders.status = 2 then 1 else 0 end) AS debtCount'),
			DB::expr ('SUM(case when orders.status = 1 then orders.paid else 0 end) AS paidTotal'),
			DB::expr ('SUM(case when orders.status = 2 then orders.debt else 0 end) AS debtTotal'));

		if($search_type == '1' || $search_type == '2'){
			//day or month
			array_push($selectColumns, DB::expr ('MONTH(orders.create_at) as month'),
				DB::expr ('DAY(orders.create_at) as day'));
		}elseif ($search_type == '3'){
			//year
			array_push($selectColumns, DB::expr ('MONTH(orders.create_at) as month'));
		}

		$querySelect = DB::select_array($selectColumns)->from('orders');
		$querySelect->join('customers','left')->on('orders.customer_id', '=', 'customers.id');
// 			$querySelect->join('customers','left')->on('orders.customer_id', '=', 'customers.id');
		$querySelect->where('orders.order_type', '=', 2);
//		$querySelect->where('debtCount', '>=', 1);
// 			$querySelect->where('orders.status', '=', 1);
		if($customer_id != ''){
			$querySelect->where('orders.customer_id', '=', $customer_id);
		}
		if($date_from != ''){
			$querySelect->where('orders.create_at', '>=', urldecode($date_from));
		}
		if($date_to != ''){
			$querySelect->where('orders.create_at', '<=', urldecode($date_to));
		}

		//GROUP BY YEAR(create_at), MONTH(create_at), DAY(create_at)
		if($search_type == '1'){
			//day
			$querySelect->group_by('orders.customer_id');
		}elseif ($search_type == '2'){
			//month
			$querySelect->group_by('orders.customer_id', DB::expr ('YEAR(orders.create_at)'), DB::expr ('MONTH(orders.create_at)'), DB::expr ('DAY(orders.create_at)'));
		}elseif ($search_type == '3'){
			//year
			$querySelect->group_by('orders.customer_id', DB::expr ('YEAR(orders.create_at)'), DB::expr ('MONTH(orders.create_at)'));
		}

		$querySelect->having('debtCount', '>=', 1);

		$countTotalList = $querySelect->execute ()->as_array ();

		$total_items = count($countTotalList);
		// set total items of pagination
		$pagination->total_items = $total_items;

		// set list search
		$paginationOffset = $page * PRODUCT_PER_PAGE - PRODUCT_PER_PAGE;
		$data ['list_debt'] = $querySelect->order_by ( 'orders.create_at', 'desc' )->limit ( $pagination->per_page )->offset ( $paginationOffset )->execute ()->as_array ();
//		$data ['list_debt'] = $querySelect->order_by ( 'orders.create_at', 'desc' )->execute ()->as_array ();

//		var_dump('<pre>');
//		var_dump(DB::last_query());
//		var_dump('</pre>');
////
//		var_dump('<pre>');
//		var_dump($data ['list_debt']);
//		var_dump('</pre>');

		// we pass the object, it will be rendered when echo'd in the view
		$data ['pagination'] = $pagination->render ();

		$this->template->title = Lang::get('title_customer_debt');
		$this->template->content = View::forge('customerdebt/index', $data);
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
			$customerid     = Input::param('customerid');
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
			if($customerid){
				$querySelect->where('orders.customer_id', '=', $customerid);
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

			$lastQuery = DB::last_query();

			if (count($data) <= 0) {
				return array(
						'status' => false,
						'message' => 'Không tìm thấy đơn hàng nào! Order ID : '.$order_id.' - Query : '.$lastQuery
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

	public function getFromToDate($search_type, $search_date){
		//2017-08-26 00:00:00
		//2017-08-26 59:59:59
//		$search_type = '1';
//		$search_date = '2017/08/26';
//		$search_date = '2017/08';
//		$search_date = '2017';
		$result = null;
		if($search_date != ''){
			$dateSplit = explode('/', $search_date);
			if($search_type == '1'){
				$year = $dateSplit[2];
				$month = $dateSplit[1];
				$day = $dateSplit[0];
				$result['from'] = date($year."-".$month."-".$day." 00:00:00");
				$result['to'] = date($year."-".$month."-".$day." 59:59:59");
			}elseif ($search_type == '2'){
				$year = $dateSplit[1];
				$month = $dateSplit[0];
				$result['from'] = date($year."-".$month."-01 00:00:00");
				$result['to'] = date($year."-".$month."-t 59:59:59");
			}elseif ($search_type == '3'){
				$result['from'] = date($search_date."-01-01 00:00:00");
				$result['to'] = date($search_date."-12-t 59:59:59");
			}
		}else{
			if($search_type == '1'){
				$result['from'] = date("Y-m-d 00:00:00");
				$result['to'] = date("Y-m-d 59:59:59");
			}elseif ($search_type == '2'){
				$result['from'] = date("Y-m-01 00:00:00");
				$result['to'] = date("Y-m-t 59:59:59");
			}elseif ($search_type == '3'){
				$result['from'] = date("Y-01-01 00:00:00");
				$result['to'] = date("Y-12-t 59:59:59");
			}
		}

		return $result;
	}

	public function action_getlistorder()
	{
		$data = null;

		if (Input::method() == 'POST' || true) {

			$listOrderId   = Input::param('listOrderId');
			if ($listOrderId == null || $listOrderId == '') {
				return array(
					'status' => false,
					'message' => 'Danh sách rỗng!'
				);
			}
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
//			$querySelect->where('orders.order_type', '=', 1);
// 			$querySelect->where('orders.status', '=', 1);
//			$querySelect->where('orders.create_at', '>=', $date_from);
//			$querySelect->where('orders.create_at', '<=', $date_to);
//			if($customerid){
//				$querySelect->where('orders.customer_id', '=', $customerid);
//			}
// 			$querySelect->where('orders.order_type', Constant::ORDER_TYPE_WHOLESALE);

// 			$querySelect->where('orders.status', '1');
// 			$querySelect->order_by('orders.date_paid');
			$id_array = explode(',', $listOrderId);
			$querySelect->where('orders.id', 'in', $id_array);
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
