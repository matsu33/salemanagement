<?php

class Controller_Publisherdebt extends Controller_Base
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
			$arrJS = array('publisherdebt.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}
	
	public function action_index()
	{
		$publisher_id = Input::param('publisher_id') ? Input::param('publisher_id') : '';
		$search_date = Input::param('search_date') ? urldecode(Input::param('search_date')) : '';
		$search_day = Input::param('search_day') ? urldecode(Input::param('search_day')) : '';
		$search_month = Input::param('search_month') ? urldecode(Input::param('search_month')) : '';
		$search_year = Input::param('search_year') ? Input::param('search_year') : '';
		$search_type = Input::param('search_type') ? Input::param('search_type') : '1';

		$data = null;
		$data ['publisher_id'] = $publisher_id;
		$data ['search_date'] = urlencode($search_date);
		$data ['search_day'] = urlencode($search_day);
		$data ['search_month'] = urlencode($search_month);
		$data ['search_year'] = $search_year;
		$data ['search_type'] = $search_type;

		$currentDateFromTo = $this->getFromToDate($search_type, $search_date);
		$date_from = $currentDateFromTo['from'];
		$date_to = $currentDateFromTo['to'];

		$page = Input::param ( 'page' ) ? Input::param ( 'page' ) : 1;

		$publisherSearchUrl = $publisher_id == '' ? '' : '&publisher_id='.$publisher_id;
		$dateSearchUrl = $search_date == '' ? '' : '&search_date='.urlencode($search_date);
		$daySearchUrl = $search_day == '' ? '' : '&search_day='.urlencode($search_day);
		$monthSearchUrl = $search_month == '' ? '' : '&search_month='.urlencode($search_month);
		$yearSearchUrl = $search_year == '' ? '' : '&search_year='.$search_year;
		$typeSearchUrl = $search_type == '' ? '' : '&search_type='.$search_type;

		// pagination config
		$config = array (
			// 'pagination_url' => '/manage/company',
			'pagination_url' => '/no_nha_cung_cap/index?'.$publisherSearchUrl.$dateSearchUrl.$typeSearchUrl.$daySearchUrl.$monthSearchUrl.$yearSearchUrl,
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
			"publisher_id",
			"publisher_name",
//			"orders.status",
//			"orders.total",
//			"orders.update_at",
//			"orders.user_id",
			DB::expr ('GROUP_CONCAT(case when orders.status = 2 then orders.id end SEPARATOR \',\' ) as listDebtOrderId'),
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
		$querySelect->join('publishers','left')->on('orders.publisher_id', '=', 'publishers.id');
// 			$querySelect->join('customers','left')->on('orders.customer_id', '=', 'customers.id');
		$querySelect->where('orders.order_type', '=', 1);
//		$querySelect->where('debtCount', '>=', 1);
// 			$querySelect->where('orders.status', '=', 1);
		if($publisher_id != ''){
			$querySelect->where('orders.publisher_id', '=', $publisher_id);
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
			$querySelect->group_by('orders.publisher_id');
		}elseif ($search_type == '2'){
			//month
			$querySelect->group_by('orders.publisher_id', DB::expr ('YEAR(orders.create_at)'), DB::expr ('MONTH(orders.create_at)'), DB::expr ('DAY(orders.create_at)'));
		}elseif ($search_type == '3'){
			//year
			$querySelect->group_by('orders.publisher_id', DB::expr ('YEAR(orders.create_at)'), DB::expr ('MONTH(orders.create_at)'));
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

		var_dump('<pre>');
		var_dump(DB::last_query());
		var_dump('</pre>');
////
//		var_dump('<pre>');
//		var_dump($data ['list_debt']);
//		var_dump('</pre>');

		// we pass the object, it will be rendered when echo'd in the view
		$data ['pagination'] = $pagination->render ();



//		$data = $querySelect->execute()->as_array();

//		if($publisher_id){
//			$publisher = Model_Publisher::find($publisher_id);
//			$data['publisher_id'] = $publisher_id;
//			$data['publisher_name'] = urlencode($publisher->publisher_name);
//		}

		$this->template->title = Lang::get('title_publisher_debt');
		$this->template->content = View::forge('publisherdebt/index', $data);
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
			$publisherid     = Input::param('publisherid');
			$datetype = Input::param('datetype');
			
			
			$querySelect = DB::select("orders.create_at",
											"orders.customer_id",
											"orders.customer_type",
											"orders.date_paid",
											"orders.debt",
											"orders.id",
											"orders.order_type",
											"orders.paid",
											"publisher_id",
											"publisher_name",
											"orders.status",
											"orders.total",
											"orders.update_at",
											"orders.user_id")->from('orders');
			$querySelect->join('publishers','left')->on('orders.publisher_id', '=', 'publishers.id');
// 			$querySelect->join('customers','left')->on('orders.customer_id', '=', 'customers.id');
			$querySelect->where('orders.order_type', '=', 1);
// 			$querySelect->where('orders.status', '=', 1);
			$querySelect->where('orders.create_at', '>=', $date_from);
			$querySelect->where('orders.create_at', '<=', $date_to);
			if($publisherid){
				$querySelect->where('orders.publisher_id', '=', $publisherid);
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
						'status' => Constant::STATUS_PAID
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
}
