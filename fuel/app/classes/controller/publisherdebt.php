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
		$this->template->title = Lang::get('title_publisher_debt');
		$this->template->content = View::forge('publisherdebt/index');
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
}
