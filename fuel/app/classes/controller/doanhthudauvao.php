<?php

class Controller_Doanhthudauvao extends Controller_Base
{
    public function before()
    {
        parent::before();
        
        if (!$this->is_restful()) {
            $arrJS = array(
                'doanhthudauvao.js'
            );
            //Load js
            Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
        }
    }
    
    public function action_index()
    {
        $data["subnav"]          = array(
            'index' => 'active'
        );
        $this->template->title   = Lang::get('title_doanhthudauvao');
        $this->template->content = View::forge('doanhthudauvao/index', $data);
    }
    
    public function action_excuteSearch()
    {
        $data = null;
        
        if (Input::method() == 'POST') {
        	
            $date_from   = Input::param('date_from');
            $date_to     = Input::param('date_to');
            
            $querySelect = DB::select("orders.id", 
            							"orders.user_id", 
            							"orders.publisher_id", 
            							"orders.customer_id", 
            							"orders.order_type", 
            							"orders.status", 
            							"orders.customer_type", 
            							"orders.total", 
            							"orders.debt", 
            							"orders.paid", 
            							"orders.date_paid", 
            							"orders.create_at", 
            							"orders.update_at", 
            							"customers.customer_name")->from('orders');
			$querySelect->join('customers','left')->on('orders.customer_id', '=', 'customers.id');
            $querySelect->where('orders.date_paid', '>=', $date_from);
            $querySelect->where('orders.date_paid', '<=', $date_to);
            $querySelect->where('orders.order_type', Constant::ORDER_TYPE_WHOLESALE);
            $querySelect->where('orders.status', '1');
            $querySelect->order_by('orders.date_paid');
            $data = $querySelect->execute()->as_array();
            
            if (count($data) <= 0) {
                return array(
                    'status' => false,
                    'message' => 'Không tìm thấy hóa đơn nào!'
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
    
    
    public function action_excuteMaterialSearch()
    {
    	$data = null;
    
    	if (Input::method() == 'POST') {
    		 
    		$date_from   = Input::param('date_from');
    		$date_to     = Input::param('date_to');
    		$materialId = Input::param('materialId');
    		
    		$querySelect = DB::select("orderdetails.id", "order_id", "orderdetails.order_type", "price", "customers.customer_name", "quanlity", array('money', 'total'), "orders.customer_type", "date_paid")->from('orderdetails');
    		$querySelect->join('orders','left')->on('orders.id', '=', 'orderdetails.id');
    		$querySelect->join('customers','left')->on('customers.id', '=', 'orders.customer_id');
    		$querySelect->join('products','left')->on('orderdetails.product_id', '=', 'products.id');
    		$querySelect->join('materials','left')->on('products.material_id', '=', 'materials.id');
    		$querySelect->where('orders.date_paid', '>=', $date_from);
    		$querySelect->where('orders.date_paid', '<=', $date_to);
    		$querySelect->where('orders.order_type', Constant::ORDER_TYPE_WHOLESALE);
    		$querySelect->where('orders.status', '1');
    		$querySelect->where('products.material_id', $materialId);
    		$querySelect->order_by('orders.date_paid');
    		//var_dump($querySelect->compile());exit;
    		$data = $querySelect->execute()->as_array();
    		
    		if (count($data) <= 0) {
    			return array(
    					'status' => false,
    					'message' => 'Không tìm thấy hóa đơn nào!'
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
