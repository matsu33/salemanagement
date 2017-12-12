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

		//get parameters
		$page = Input::param ( 'page' ) ? Input::param ( 'page' ) : 1;
		$material_id = Input::param ( 'material_id' ) ? Input::param ( 'material_id' ) : '';
		$category_id = Input::param ( 'category_id' ) ? Input::param ( 'category_id' ) : '';
		$product_diameter = Input::param ( 'product_diameter' ) ? Input::param ( 'product_diameter' ) : '';
		$product_length = Input::param ( 'product_length' ) ? Input::param ( 'product_length' ) : '';
		$product_range = Input::param ( 'product_range' ) ? Input::param ( 'product_range' ) : '';
		$unit_instock = Input::param ( 'unit_instock' ) ? Input::param ( 'unit_instock' ) : 0;

		$materialSearchUrl = $material_id == '' ? '' : '&material_id='.$material_id;
		$categorySearchUrl = $category_id == '' ? '' : '&category_id='.$category_id;
		$productDiameterSearchUrl = $product_diameter == '' ? '' : '&product_diameter='.$product_diameter;
		$productLengthSearchUrl = $product_length == '' ? '' : '&product_length='.$product_length;
		$productRangeSearchUrl = $product_range == '' ? '' : '&product_range='.$product_range;
		$unitInstockSearchUrl = $unit_instock == '' ? '' : '&unit_instock='.$unit_instock;

		// pagination config
		$config = array (
			// 'pagination_url' => '/manage/company',
			'pagination_url' => '/kiemkho/index?'.$materialSearchUrl.$categorySearchUrl.$productDiameterSearchUrl.$productLengthSearchUrl.$productRangeSearchUrl.$unitInstockSearchUrl,
			'total_items' => 0,
			'per_page' => PRODUCT_PER_PAGE,
			'uri_segment' => 'page',
			'show_first' => true,
			'show_last' => true
		);

		// Create a pagination instance named 'mypagination'
		$pagination = Pagination::forge ( 'mypagination', $config );

		$querySelect = DB::select ( "products.id", "unit_instock", "category_id", "category_name", "material_id", "material_name", "product_group", "size_id", "diameter", "length", "product_range", "unit_id", "unit_name", "image" )->from ( "products" )->join ( 'categories', 'LEFT' )->on ( 'products.category_id', '=', 'categories.id' )->join ( 'materials', 'LEFT' )->on ( 'products.material_id', '=', 'materials.id' )->join ( 'sizes', 'LEFT' )->on ( 'products.size_id', '=', 'sizes.id' )->join ( 'units', 'LEFT' )->on ( 'products.unit_id', '=', 'units.id' );

		if($category_id != '') {
			$querySelect->where('products.category_id', $category_id);
		}
		if($material_id != ''){
			$querySelect->where ( 'products.material_id', $material_id );
		}
		if($product_diameter != ''){
			$querySelect->where ( 'sizes.diameter', $product_diameter );
		}
		if($product_length != ''){
			$querySelect->where ( 'sizes.length', $product_length );
		}
		if($product_range != ''){
			$querySelect->where ( 'sizes.product_range', $product_range );
		}
		if($unit_instock >= 0){
			$querySelect->where ( 'unit_instock','>=', $unit_instock );
		}
		$querySelect->where ( 'products.status', '1' );

		$countTotalList = $querySelect->execute ()->as_array ();
		$total_items = count($countTotalList);
		$pagination->total_items = $total_items;
		$paginationOffset = $page * PRODUCT_PER_PAGE - PRODUCT_PER_PAGE;
		$data ['list_products'] = $querySelect->order_by ( 'products.create_at', 'desc' )->limit ( $pagination->per_page )->offset ( $paginationOffset )->execute ()->as_array ();

//		var_dump('<pre>');
//		var_dump(DB::last_query());
//		var_dump('</pre>');
//
//		var_dump('<pre>');
//		var_dump($data ['list_products']);
//		var_dump('</pre>');

		$data ['pagination'] = $pagination->render ();

		$data ['material_id'] = $material_id;
		$data ['category_id'] = $category_id;
		$data ['product_diameter'] = $product_diameter;
		$data ['product_length'] = $product_length;
		$data ['product_range'] = $product_range;
		$data ['unit_instock'] = $unit_instock;

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
			
			$querySelect = DB::select ( "orderdetails.id", "orderdetails.order_id", "orderdetails.product_id", "unit_instock", "category_id", "category_name", "material_id", "material_name", "product_group", "size_id", "diameter", "length", "product_range", "unit_id", "unit_name", "image", "order_type", "orderdetails.update_at", "old_instock", "new_instock", "quanlity" )
			->from ( "orderdetails" )->join ( 'products', 'LEFT' )->on ( 'products.id', '=', 'orderdetails.product_id' )
			->join ( 'categories', 'LEFT' )->on ( 'products.category_id', '=', 'categories.id' )
			->join ( 'materials', 'LEFT' )->on ( 'products.material_id', '=', 'materials.id' )
			->join ( 'sizes', 'LEFT' )->on ( 'products.size_id', '=', 'sizes.id' )
			->join ( 'units', 'LEFT' )->on ( 'products.unit_id', '=', 'units.id' )
			->where ( 'orderdetails.product_id', $pid )
				->order_by('orderdetails.update_at','DESC');
			//->order_by('orderdetails.id', 'DESC');
			
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
		$data = array();
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

	/**
	 * update new instock of product
	 * @return multitype:boolean string
	 */
	public function action_updateOrderDetailDate()
	{
		$result = null;
		$status = true;
		$message = '';

		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$orderDetailId = Input::param('orderdetailid');
				$productid = Input::param('productid');
				$newDate   = Input::param('newdate');
				$orderid   = Input::param('orderid');
				$updateall = Input::param('updateall');

//				$updateDate = date($newDate);
				$updateDate     = str_replace('/', '-', $newDate);
				$updateDate = date('Y-m-d', strtotime($updateDate));

				//Start transaction update old, new instock
				if($updateall === 'true' || $updateall === true){
					//START update date of order
					$query = DB::update("orderdetails");
					//set data
					$query->set(array(
						'update_at' => $updateDate
					));
					$query->where('order_id', $orderid);
					//excute
					$query->execute();
					//END update date of order

					//get list product id of order
					$listProductId = $this->getListProductIdOfOrder($orderid);

					//loop all product
					for($i = 0; $i < count($listProductId) - 1; $i++){
						$productId = $listProductId[$i];

						//get all order detail of product
						$listOrderDetail = $this->getListOrderDetailOfProduct($productId);

						$oldStockTemp = 0;
						//loop all order detail
						for($j = 0; $j < count($listOrderDetail); $j++){
							$orderDetailTemp = $listOrderDetail[$j];
							$orderDetailIdTemp = $orderDetailTemp['id'];
							$orderType = $orderDetailTemp['order_type'];
							$quanlity = (int)$orderDetailTemp['quanlity'];
							$oldInstock = (int)$orderDetailTemp['old_instock'];
							$newInstock = (int)$orderDetailTemp['new_instock'];

							if($j > 0){
								$oldInstock = $oldStockTemp;
							}

							if($orderType == Constant::ORDER_TYPE_SALE){
								$newInstock = $oldInstock - $quanlity;
							}elseif($orderType == Constant::ORDER_TYPE_BUY){
								$newInstock = $oldInstock + $quanlity;
							}elseif($orderType == Constant::ORDER_TYPE_INVENTORY){
								$oldInstock = $oldStockTemp;
							}
							$oldStockTemp = $newInstock;

							$query = DB::update("orderdetails");
							//set data
							$query->set(array(
								'old_instock' => $oldInstock,
								'new_instock' => $newInstock
							));

							$query->where('id', $orderDetailIdTemp);
							//excute
							$query->execute();

						}
					}

				}else{
					//START update date of order
					$query = DB::update("orderdetails");
					//set data
					$query->set(array(
						'update_at' => $updateDate
					));
					$query->where('id', $orderDetailId);
					//excute
					$query->execute();
					//END update date of order

					//get all order detail of product
					$listOrderDetail = $this->getListOrderDetailOfProduct($productid);

					$oldStockTemp = 0;
					//loop all order detail
					for($j = 0; $j < count($listOrderDetail); $j++){
						$orderDetailTemp = $listOrderDetail[$j];
						$orderDetailIdTemp = $orderDetailTemp['id'];
						$orderType = $orderDetailTemp['order_type'];
						$quanlity = (int)$orderDetailTemp['quanlity'];
						$oldInstock = (int)$orderDetailTemp['old_instock'];
						$newInstock = (int)$orderDetailTemp['new_instock'];

						if($j > 0){
							$oldInstock = $oldStockTemp;
						}elseif($j == 0){
							$oldInstock = 0;
						}

						if($orderType == Constant::ORDER_TYPE_SALE){
							$newInstock = $oldInstock - $quanlity;
						}elseif($orderType == Constant::ORDER_TYPE_BUY){
							$newInstock = $oldInstock + $quanlity;
						}elseif($orderType == Constant::ORDER_TYPE_INVENTORY){
							$oldInstock = $oldStockTemp;
						}
						$oldStockTemp = $newInstock;

						$query = DB::update("orderdetails");
						//set data
						$query->set(array(
							'old_instock' => $oldInstock,
							'new_instock' => $newInstock
						));

						$query->where('id', $orderDetailIdTemp);
						//excute
						$query->execute();

					}
				}



				//End transaction update old, new instock
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

	public function action_checkOrderProductNumber() {
		$data = array();
		if (Input::method () == 'POST') {
			$orderid = Input::param ( 'orderid' );

			$data = $this->getListProductIdOfOrder($orderid);

			$countArray = count($data);

			if ($countArray <= 0) {
				return array (
					'status' => false,
					'count' => 0
				);
			}

			return array (
				'status' => true,
				'count' => $countArray
			);
		}

		return $data;
	}

	public function getListProductIdOfOrder($orderId){
		$querySelect = DB::select ( "product_id" )
			->from ( "orderdetails" )
			->where ( 'order_id', $orderId );

		$data = $querySelect->execute ()->as_array ();

		return $data;
	}

	public function getListOrderDetailOfProduct($productId){
		$querySelect = DB::select ()
			->from ( "orderdetails" )
			->where ( 'product_id', $productId )
			->order_by('update_at','ASC');

		$data = $querySelect->execute ()->as_array ();

		return $data;
	}

}
