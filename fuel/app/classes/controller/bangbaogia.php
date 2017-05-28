<?php

class Controller_Bangbaogia extends Controller_Base
{
	public $tableName = 'prices';
	
	/**
	 * Load the template and create the $this->template object if needed
	 */
	public function before ()
	{
		parent::before();
		
		if (! $this->is_restful()) {
			$arrJS = array('bangbaogia.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}
	
	/**
	 * view price list
	 */
	public function action_index()
	{
		// get search parameter
		$search_keyword = Input::param ( 'keyword' ) ? Input::param ( 'keyword' ) : '';
		
		// pagination config
		$config = array (
				// 'pagination_url' => '/manage/company',
				'pagination_url' => '/bangbaogia/index?keyword=' . $search_keyword,
				'total_items' => 0,
				'per_page' => PRODUCT_PER_PAGE,
				'uri_segment' => 'page',
				'show_first' => true,
				'show_last' => true
		);
		
		// Create a pagination instance named 'mypagination'
		$pagination = Pagination::forge ( 'mypagination', $config );
		
		// count company
		/*$query_count = DB::select ( DB::expr ( 'COUNT(company.id) as count' ) )->from ( 'company' );
		 if ($search_keyword != '') {
		 $query_count->where ( 'name', 'LIKE', '%' . $search_keyword . '%' )->or_where ( 'address', 'LIKE', '%' . $search_keyword . '%' );
		 }
		 $total_items = $query_count->execute ()->current () ['count'];
		 */
		
		$total_items = Model_Price::count();
		
		//////////////////////////
		//init sql
		$query_select = DB::select($this->tableName.".id",
											"product_id",
											"publisher_id",
											"publisher_name",
											"input_price",
											"category_id",
											"category_name",
											"material_id",
											"material_name",
											"size_id",
											"diameter",
											"length",
											"product_range",
											"unit_id",
											"unit_name",
											"image",
											"product_group"
											)
				->from($this->tableName)
				->join('publishers','LEFT')
				->on($this->tableName.'.publisher_id', '=', 'publishers.id')
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
				//->order_by('id','DESC');
				//$data = $querySelect->execute()->as_array();
		
		
				///////////////////////
				// set list search
				
		
				// set total items of pagination
				$pagination->total_items = $total_items;
		
				// we pass the object, it will be rendered when echo'd in the view
				$data ['pagination'] = $pagination->render ();
		
				$data ['keyword'] = $search_keyword;
				
				$data ['list_price'] = $query_select->order_by ( 'prices.create_at', 'desc' )->limit ( $pagination->per_page )->offset ( $pagination->offset )->execute ()->as_array ();
				
				//var_dump($pagination->offset);
				//var_dump($data);exit;
				$this->template->title = Lang::get('title_price_list');
				$this->template->content = View::forge ( 'bangbaogia/index', $data );
	}

	/*****************************************************************************
	 ***API *********************************************************************
	 *****************************************************************************/
	/**
	 * get all price
	 */
	public function action_getAll()
	{
		//init variable
		$result = null;
		$status = true;
		$message = Lang::get('m_no_error');
		$data = null;
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				//init sql
				$querySelect = DB::select($this->tableName.".id",
											"product_id",
											"publisher_id",
											"publisher_name",
											"input_price",
											"category_id",
											"category_name",
											"material_id",
											"material_name",
											"size_id",
											"diameter",
											"length",
											"product_range",
											"unit_id",
											"unit_name",
											"image",
											"product_group"
											)
				->from($this->tableName)
				->join('publishers','LEFT')
				->on($this->tableName.'.publisher_id', '=', 'publishers.id')
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
				$querySelect->order_by('id','DESC');
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
	 * Add
	 */
	public function action_add()
	{
		$result = null;
		$status = true;
		$message = Lang::get('m_insert_success');

		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$product_id = Input::post('product_id');
				$publisher_id = Input::post('publisher_id');
				$input_price = Input::post('input_price');
				
				$dataInsert = array(
					'product_id' => $product_id,
					'publisher_id' => $publisher_id,
					'input_price' => $input_price,
					'create_at' => date('Y-m-d H:i:s'),
				);
				$query = DB::insert($this->tableName);
				$query->set($dataInsert);
				$queryResult = $query->execute();
			} else {
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
	 * Delete
	 */
	public function action_delete($id = null)
	{
		$result = null;
		$status = true;
		$message = '';
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				//query
				$query = DB::delete($this->tableName);
				
				// Set a where statement
				$query->where('id', Input::post('id'));
				
				//excute
                $query->execute();
				
				$message = Lang::get('m_delete_success');
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
	 * Update
	 */
	public function action_update()
	{
		$result = null;
		$status = true;
		$message = '';
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				//init query update
				$query = DB::update($this->tableName);
				
				$id = Input::post('id');
				$input_price = Input::post('input_price');

				//set data
                $query->set(array(
                    'input_price' => $input_price
                ));
                $query->where('id',Input::post('id'));
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

// 	public function action_save()
// 	{
// 		$data["subnav"] = array('save'=> 'active' );
// 		$this->template->title = 'Bangbaogia &raquo; Save';
// 		$this->template->content = View::forge('bangbaogia/save', $data);
// 	}

// 	public function action_print()
// 	{
// 		$data["subnav"] = array('print'=> 'active' );
// 		$this->template->title = 'Bangbaogia &raquo; Print';
// 		$this->template->content = View::forge('bangbaogia/print', $data);
// 	}

	/**
	 * search price of product of publisher
	 */
	public function action_search()
	{
		//init variable
		$result = null;
		$status = true;
		$message = Lang::get('m_no_error');
		$data = null;
		$lastQuery = null;
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$pid = Input::post('pid');
				$pubid = Input::post('pubid');
				
				//init sql
				$querySelect = DB::select($this->tableName.".id",
											"product_id",
											"publisher_id",
											"publisher_name",
											"input_price",
											"category_id",
											"category_name",
											"material_id",
											"material_name",
											"size_id",
											"diameter",
											"length",
											"product_range",
											"unit_id",
											"unit_name",
											"image",
											"product_group"
											)
				->from($this->tableName)
				->join('publishers','LEFT')
				->on($this->tableName.'.publisher_id', '=', 'publishers.id')
// 				->and_on($this->tableName.'.publisher_id', '=', $pubid)
				->join('products','LEFT')
				->on($this->tableName.'.product_id', '=', 'products.id')
// 				->and_on($this->tableName.'.product_id', '=', $pid)
				->join('categories','LEFT')
				->on('products.category_id', '=', 'categories.id')
				->join('materials','LEFT')
				->on('products.material_id', '=', 'materials.id')
				->join('sizes','LEFT')
				->on('products.size_id', '=', 'sizes.id')
				->join('units','LEFT')
				->on('products.unit_id', '=', 'units.id')
				->where($this->tableName.'.publisher_id', '=', $pubid)
				->and_where($this->tableName.'.product_id', '=', $pid)
				->order_by('id','DESC');
				$lastQuery = DB::last_query();
				$data = $querySelect->execute()->as_array();
			}else{
				$status = false;
				$message = Lang::get('e_not_valid_method');
			}
		}catch (Exception $e){
			$status = false;
			//$message = Lang::get('e_common_sql');
			$message = $e->getMessage();
		}
		
		//set result
		$result = array('status' => $status, 'message' => $message, 'data' => $data, 'lastquery' => $lastQuery);
		
		//return
		return $result;
	}

}
