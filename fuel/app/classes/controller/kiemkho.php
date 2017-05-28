<?php
class Controller_Kiemkho extends Controller_Base {
	public function before() {
		parent::before ();
		
		if (! $this->is_restful ()) {
			$arrJS = array (
					'kiemkho.js' 
			);
			// Load js
			Asset::js ( $arrJS, $this->scriptAttr, 'current_script', false );
		}
	}
	public function action_index() {
		$data ["subnav"] = array (
				'index' => 'active' 
		);
		$this->template->title = Lang::get ( 'title_kiemkho' );
		$this->template->content = View::forge ( 'kiemkho/index', $data );
	}
	public function action_list() {
		$data ["subnav"] = array (
				'list' => 'active' 
		);
		$this->template->title = 'Kiemkho &raquo; List';
		$this->template->content = View::forge ( 'kiemkho/list', $data );
	}
	public function action_detail() {
		$data ["subnav"] = array (
				'detail' => 'active' 
		);
		$this->template->title = 'Kiemkho &raquo; Detail';
		$this->template->content = View::forge ( 'kiemkho/detail', $data );
	}
	public function action_getListMaterial() {
		$data = null;
		if (Input::method () == 'POST') {
			$querySelect = DB::select ()->from ( 'materials' );
			$querySelect->where ( 'materials.status', '1' );
			$data = $querySelect->execute ()->as_array ();
		}
		
		return $data;
	}
	public function action_getListCategories() {
		$data = null;
		if (Input::method () == 'POST') {
			$querySelect = DB::select ()->from ( 'categories' );
			$querySelect->where ( 'categories.status', '1' );
			$data = $querySelect->execute ()->as_array ();
		}
		
		return $data;
	}
	public function action_excuteSearch() {
		$data = null;
		if (Input::method () == 'POST') {
			$material_id = Input::param ( 'material_id' );
			$category_id = Input::param ( 'category_id' );
			$product_diameter = Input::param ( 'product_diameter' );
			$product_length = Input::param ( 'product_length' );
			$product_range = Input::param ( 'product_range' );
			
			$size_id = $this->getSizeId ( $product_diameter, $product_length, $product_range );
			
			if (count ( $size_id ) <= 0) {
				return array (
						'status' => false,
						'message' => 'Quy cách không tồn tại!' 
				);
			}
			
			$size_id = $size_id [0] ['id'];
			
			$querySelect = DB::select ( "products.id", "unit_instock", "category_id", "category_name", "material_id", "material_name", "product_group", "size_id", "diameter", "length", "product_range", "unit_id", "unit_name", "image" )->from ( "products" )->join ( 'categories', 'LEFT' )->on ( 'products.category_id', '=', 'categories.id' )->join ( 'materials', 'LEFT' )->on ( 'products.material_id', '=', 'materials.id' )->join ( 'sizes', 'LEFT' )->on ( 'products.size_id', '=', 'sizes.id' )->join ( 'units', 'LEFT' )->on ( 'products.unit_id', '=', 'units.id' );
			
			$querySelect->where ( 'products.category_id', $category_id );
			$querySelect->where ( 'products.material_id', $material_id );
			$querySelect->where ( 'products.size_id', $size_id );
			$querySelect->where ( 'products.status', '1' );
			
			$data = $querySelect->execute ()->as_array ();
			
			if (count ( $data ) <= 0) {
				return array (
						'status' => false,
						'message' => 'Không tìm thấy sản phẩm nào!' 
				);
			}
			
			return array (
					'status' => true,
					'data' => $data 
			);
		}
		
		return $data;
	}
	public function getSizeId($product_diameter, $product_length, $product_range) {
		$querySelect = DB::select ( 'id' )->from ( 'sizes' );
		$querySelect->where ( 'sizes.diameter', $product_diameter );
		$querySelect->where ( 'sizes.length', $product_length );
		$querySelect->where ( 'sizes.product_range', $product_range );
		$size_id = $querySelect->execute ()->as_array ();
		return $size_id;
	}
	
	/**
	 * get history buy, sell of product
	 * @return multitype:boolean string |multitype:boolean unknown |NULL
	 */
	public function action_getHistory() {
		$data = null;
		if (Input::method () == 'POST') {
			$pid = Input::param ( 'pid' );
			
			$querySelect = DB::select ( "orderdetails.id", "orderdetails.product_id", "unit_instock", "category_id", "category_name", "material_id", "material_name", "product_group", "size_id", "diameter", "length", "product_range", "unit_id", "unit_name", "image", "order_type", "orderdetails.update_at", "old_instock", "new_instock", "quanlity" )
			->from ( "orderdetails" )->join ( 'products', 'LEFT' )->on ( 'products.id', '=', 'orderdetails.product_id' )
			->join ( 'categories', 'LEFT' )->on ( 'products.category_id', '=', 'categories.id' )
			->join ( 'materials', 'LEFT' )->on ( 'products.material_id', '=', 'materials.id' )
			->join ( 'sizes', 'LEFT' )->on ( 'products.size_id', '=', 'sizes.id' )
			->join ( 'units', 'LEFT' )->on ( 'products.unit_id', '=', 'units.id' )
			->where ( 'orderdetails.product_id', $pid )
			->order_by('orderdetails.id', 'DESC');
			
			$data = $querySelect->execute ()->as_array ();
			
			if (count ( $data ) <= 0) {
				return array (
						'status' => false,
						'message' => 'Không tìm thấy hóa đơn nào!' 
				);
			}
			
			return array (
					'status' => true,
					'data' => $data 
			);
		}
		
		return $data;
	}
	
	/**
	 * update new instock of product 
	 * @return multitype:boolean string
	 */
	public function action_updateProductInstock()
	{
		$result = null;
		$status = true;
		$message = '';
	
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$pid   = Input::param('pid');
				$new_instock   = Input::param('new_instock');
				$old_instock   = Input::param('old_instock');
				
				$dateCreate = date('Y-m-d H:i:s');
				
				//add order
				$modelOrder = Model_Order::forge(array(
						'order_type' => Constant::ORDER_TYPE_INVENTORY,
						'create_at' => $dateCreate,
						'update_at' => $dateCreate
				));
				$modelOrder->save();
				$orderId = $modelOrder->id;
				
				//add order detail
				$modelOrderDetail = Model_Orderdetail::forge(array(
					'order_id' => $orderId,
					'product_id' => $pid,
					'order_type' => Constant::ORDER_TYPE_INVENTORY,
					'old_instock' => $old_instock,
					'new_instock' => $new_instock,
					'create_at' => $dateCreate,
					'update_at' => $dateCreate
				));
				$modelOrderDetail->save();
				
				//update product instock
				$query = DB::update("products");
				//set data
                $query->set(array(
					'unit_instock' => $new_instock,
					'create_at' => $dateCreate,
					'update_at' => $dateCreate
                ));
                $query->where('id', $pid);
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
	
	/**
	 * get price of product
	 * @return multitype:boolean string |multitype:boolean unknown |NULL
	 */
	public function action_getPriceOfProduct() {
		$data = null;
		if (Input::method () == 'POST') {
			$pid = Input::param ( 'pid' );
				
			$querySelect = DB::select ( "prices.id", "prices.wholesales_price", "prices.wholesales_price2", "prices.wholesales_price3", "prices.retail_price")
			->from ( "prices" )
			->where ( 'prices.product_id', $pid )
			->where ( 'prices.selected_price', DB::expr(1))
			->limit(1);
				
			$data = $querySelect->execute ()->as_array ();
				
			if (count ( $data ) <= 0) {
				return array (
						'status' => false,
						'message' => 'Không tìm thấy giá!'
				);
			}
				
			return array (
					'status' => true,
					'data' => $data
			);
		}
	
		return $data;
	}
}
