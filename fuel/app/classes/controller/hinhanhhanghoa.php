<?php
class Controller_Hinhanhhanghoa extends Controller_Base
{
	public $tableName = 'products';
	
	/**
	 * Load the template and create the $this->template object if needed
	 */
	public function before ()
	{
		parent::before();
		
		// header('Content-Type: text/html; charset=utf-8');
		
		if (! $this->is_restful()) {
			$arrJS = array('product.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}

	/**
	 * list view all product image
	 */
	public function action_index()
	{
		// get search parameter
		$search_keyword = Input::param ( 'keyword' ) ? Input::param ( 'keyword' ) : '';
		
		// pagination config
		$config = array (
				// 'pagination_url' => '/manage/company',
				'pagination_url' => '/hinhanhhanghoa/index?keyword=' . $search_keyword,
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
		
		$total_items = Model_Product::count();
		
		//////////////////////////
		//init sql
		$query_select = DB::select($this->tableName.".id",
				"category_id",
				"category_name",
				"material_id",
				"material_name",
				"product_group",
				"size_id",
				"diameter",
				"length",
				"product_range",
				"unit_id",
				"unit_name",
				"image")
				->from($this->tableName)
				->join('categories','LEFT')
				->on($this->tableName.'.category_id', '=', 'categories.id')
				->join('materials','LEFT')
				->on($this->tableName.'.material_id', '=', 'materials.id')
				->join('sizes','LEFT')
				->on($this->tableName.'.size_id', '=', 'sizes.id')
				->join('units','LEFT')
				->on($this->tableName.'.unit_id', '=', 'units.id');
				///->order_by('id','DESC');
				//$data = $querySelect->execute()->as_array();
		
		
		///////////////////////
		// set list search
		
		// set total items of pagination
		$pagination->total_items = $total_items;
		
		// we pass the object, it will be rendered when echo'd in the view
		$data ['pagination'] = $pagination->render ();
		
		$data ['keyword'] = $search_keyword;
		
		$data ['list_product'] = $query_select->order_by ( 'products.create_at', 'desc' )->limit ( $pagination->per_page )->offset ( $pagination->offset )->execute ()->as_array ();
		
		$this->template->title = Lang::get('title_product');
		//$this->template->content = View::forge('hinhanhhanghoa/index');
		$this->template->content = View::forge ( 'hinhanhhanghoa/index', $data );
	}
	
	/*****************************************************************************
	 ***API category*************************************************************
	 *****************************************************************************/
	/**
	 * get all category
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
				//$time_start = microtime(true); 
				//init sql
				$querySelect = DB::select($this->tableName.".id",
											"category_id",
											"category_name",
											"material_id",
											"material_name",
											"product_group",
											"size_id",
											"diameter",
											"length",
											"product_range",
											"unit_id",
											"unit_name",
											"image")
				->from($this->tableName)
				->join('categories','LEFT')
				->on($this->tableName.'.category_id', '=', 'categories.id')
				->join('materials','LEFT')
				->on($this->tableName.'.material_id', '=', 'materials.id')
				->join('sizes','LEFT')
				->on($this->tableName.'.size_id', '=', 'sizes.id')
				->join('units','LEFT')
				->on($this->tableName.'.unit_id', '=', 'units.id')
				->order_by('id','DESC');
				$data = $querySelect->execute()->as_array();
				//$time_end = microtime(true);
				//dividing with 60 will give the execution time in minutes other wise seconds
				//$execution_time = ($time_end - $time_start);
				//execution time of the script
				//echo '<b>Total Execution Time:</b> '.$execution_time.' ';exit;
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
	 * get list product group by group id
	 */
	public function action_getListProductGroup()
	{
		//init variable
		$result = null;
		$status = true;
		$message = Lang::get('m_no_error');
		$data = null;
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$product_group_id = Input::post('product_group');
				//init sql
				$querySelect = DB::select("productgroups.sub_product_id",
											"category_id",
											"category_name",
											"material_id",
											"material_name",
											"product_group",
											"size_id",
											"diameter",
											"length",
											"product_range",
											"unit_id",
											"unit_name",
											"quanlity",
											"image")
				->from('productgroups')
				->join('products','LEFT')
				->on($this->tableName.'.id', '=', 'productgroups.sub_product_id')
				->join('categories','LEFT')
				->on($this->tableName.'.category_id', '=', 'categories.id')
				->join('materials','LEFT')
				->on($this->tableName.'.material_id', '=', 'materials.id')
				->join('sizes','LEFT')
				->on($this->tableName.'.size_id', '=', 'sizes.id')
				->join('units','LEFT')
				->on($this->tableName.'.unit_id', '=', 'units.id')
				->where('productgroups.id', $product_group_id);
				
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
	 * get all category
	 */
	public function action_getInfo()
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
											"category_id",
											"category_name",
											"material_id",
											"material_name",
											"size_id",
											"diameter",
											"length",
											"product_range",
											"product_group",
											"unit_id",
											"unit_name",
											"unit_instock",
											"image")
				->from($this->tableName)
				->join('categories','LEFT')
				->on($this->tableName.'.category_id', '=', 'categories.id')
				->join('materials','LEFT')
				->on($this->tableName.'.material_id', '=', 'materials.id')
				->join('sizes','LEFT')
				->on($this->tableName.'.size_id', '=', 'sizes.id')
				->join('units','LEFT')
				->on($this->tableName.'.unit_id', '=', 'units.id')
				->join('productgroups','LEFT')
				->on($this->tableName.'.product_group', '=', 'productgroups.id');
				
				$category_id = Input::param('category_id');
				$material_id = Input::param('material_id');
				$size_id = Input::param('size_id');
				$unit_id = Input::param('unit_id');
				$product_group = Input::param('product_group');
				
				$querySelect->where('category_id', $category_id);
				$querySelect->where('material_id', $material_id);
				$querySelect->where('size_id', $size_id);
				$querySelect->where('unit_id', $unit_id);
				$querySelect->where('product_group', $product_group);
				
				$querySelect->limit(1);
				
				$data = $querySelect->execute()->as_array();
				if(count($data) > 0){
					$data = $data[0];
				}else{
					$image = '';
					//init new product
					$resultInsert = $this->insertProductWithData($category_id, $material_id, $size_id, $unit_id, $image, $product_group);
					
					$product_id = $resultInsert[0];
					
					$productList = $this->getProductById($product_id);
					
					$data = $productList[0];
				}
			}else{
				$status = false;
				$message = Lang::get('e_not_valid_method');
			}
		}catch (Exception $e){
			$status = false;
			$message = Lang::get('e_common_sql').$e;
		}
		
		//set result
		$result = array('status' => $status, 'message' => $message, 'data' => $data);
		
		//return
		return $result;
	}
	
	function getProductById($id){
		$querySelect = DB::select($this->tableName.".id",
											"category_id",
											"category_name",
											"material_id",
											"material_name",
											"size_id",
											"diameter",
											"length",
											"unit_instock",
											"product_range",
											"product_group",
											"unit_id",
											"unit_name",
											"image")
				->from($this->tableName)
				->join('categories','LEFT')
				->on($this->tableName.'.category_id', '=', 'categories.id')
				->join('materials','LEFT')
				->on($this->tableName.'.material_id', '=', 'materials.id')
				->join('sizes','LEFT')
				->on($this->tableName.'.size_id', '=', 'sizes.id')
				->join('units','LEFT')
				->on($this->tableName.'.unit_id', '=', 'units.id')
				->join('productgroups','LEFT')
				->on($this->tableName.'.product_group', '=', 'productgroups.id');
		
		$querySelect->where($this->tableName.'.id', $id);
		$querySelect->limit(1);
		$data = $querySelect->execute()->as_array();
		
		return $data;
	}
	
	/**
	 * get product group id
	 */
	public function action_getProductGroupId()
	{
		//init variable
		$result = null;
		$status = true;
		$message = Lang::get('m_no_error');
		$data = null;
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				
				$postData = Input::post('data');
				
				$numberOfProduct = count($postData);
				
				//init sql
				$querySelect = DB::select("productgroups.id",DB::expr('GROUP_CONCAT(sub_product_id, quanlity) AS sub_product_id2'), DB::expr('COUNT(id) as number_of_product'))
				->from("productgroups")
				->group_by("productgroups.id")
				->having('number_of_product', $numberOfProduct);
				for ($i=0; $i < $numberOfProduct; $i++) { 
					$querySelect->and_having("sub_product_id2","LIKE","%".$postData[$i][0].$postData[$i][1]."%");
				}
				$querySelect->limit(1);
				
				$dbReturn = $querySelect->execute()->as_array();
				
				if(count($dbReturn) <= 0){
					//not exist this group
					
					//init unit id
					$uid = uniqid('', true);
					
					DB::start_transaction();
					
					for ($i=0; $i < $numberOfProduct; $i++) {
						$subproductid = $postData[$i][0];
						$quanlity = $postData[$i][1];
						 
						$dataInsert = array(
							'id' => $uid,
							'sub_product_id' => $subproductid,
							'quanlity' => $quanlity,
							'create_at' => date('Y-m-d H:i:s')
						);
						$query = DB::insert("productgroups");
						$query->set($dataInsert);
						$queryResult = $query->execute();
					}
					
					DB::commit_transaction();
					
					$data = $uid;
				}else{
					$data = $dbReturn[0]['id'];
				}
			} else {
				$status = false;
				$message = Lang::get('e_not_valid_method');
			}
		}catch (Exception $e){
			DB::rollback_transaction();
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
				$category_id = Input::post('category_id');
				$material_id = Input::post('material_id');
				$size_id = Input::post('size_id');
				$unit_id = Input::post('unit_id');
				$image = Input::post('image');
				$product_group = Input::post('product_group');
				
				$this->insertProductWithData($category_id, $material_id, $size_id, $unit_id, $image, $product_group);
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
	 * insert function
	 */
	public function insertProductWithData($category_id, $material_id, $size_id, $unit_id, $image = '', $product_group){
		$dataInsert = array(
			'category_id' => $category_id,
			'material_id' => $material_id,
			'size_id' => $size_id,
			'unit_id' => $unit_id,
			'image' => $image,
			'product_group' => $product_group,
			'create_at' => date('Y-m-d H:i:s'),
		);
		$query = DB::insert($this->tableName);
		$query->set($dataInsert);
		$queryResult = $query->execute();
		
		return $queryResult;
	}
	
	/**
	 * Update
	 */
	public function action_update($id = null)
	{
		$result = null;
		$status = true;
		$message = '';
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				//init query update
				$query = DB::update($this->tableName);
				
				$category_id = Input::post('category_id');
				$material_id = Input::post('material_id');
				$size_id = Input::post('size_id');
				$unit_id = Input::post('unit_id');
				$image = Input::post('image');
				$product_group = Input::post('product_group');
				
				//set data
                $query->set(array(
                    'category_id' => $category_id,
                    'material_id' => $material_id,
                    'size_id' => $size_id,
                    'unit_id' => $unit_id,
                    'product_group' => $product_group,
                    'image' => $image
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
				
				//delete image
				$imageName = Input::post('image');
				$imagePath = DOCROOT.'assets/img/products/'.$imageName;
				if (File::exists($imagePath))
				{
					File::delete($imagePath);
				}
				
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
	
	function post_upload(){
		$config = array(
				'path' => DOCROOT . 'assets/img/products',
				'randomize' => true,
				'ext_whitelist' => array(
						'img',
						'jpg',
						'jpeg',
						'gif',
						'png'
				)
		);
		Upload::process($config);
		if (Upload::is_valid()) {
			Upload::save();
			$arr = Upload::get_files();

			// var_dump($arr[0]);exit;			
			$filename = $arr[0]['saved_as'];
			$filepath = $arr[0]['saved_to'].$filename;
			
			$image = Image::forge(array(
			    'quality' => 70
			));
			
			$size = Image::sizes($filepath);
	    	$width = $size->width;
	    	$width = $width > 1536 ? 1536 : $width;
			
	    	$image->load($filepath)->resize($width, null, true, false)->save($filepath);
			
			return array(
					'result' => true,
					'filename' => $filename,
					'filepath' => $filepath
			);
		}
	}
	
	/**
	 * remove image with name
	 */
	function action_removeImage(){
		if (Input::method() == 'POST'){
			$imageName = Input::post('image');
			$imagePath = DOCROOT.'assets/img/products/'.$imageName;
			if (File::exists($imagePath))
			{
				File::delete($imagePath);
			}
		}
		return true;
	}
	
	/**
	 * check product exist
	 */
	function action_checkExist(){
		$result = null;
		$status = true;
		$message = Lang::get('m_no_error');

		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$category_id = Input::post('category_id');
				$material_id = Input::post('material_id');
				$size_id = Input::post('size_id');
				$unit_id = Input::post('unit_id');
				$product_group = Input::post('product_group');

				$querySelect = DB::select("id")
				->from($this->tableName)
				->where("category_id",$category_id)
				->and_where("material_id",$material_id)
				->and_where("size_id",$size_id)
				->and_where("unit_id",$unit_id)
				->and_where("product_group",$product_group);
				$querySelect->limit(1);
				
				$data = $querySelect->execute()->as_array();
				
				if(count($data) > 0){
					$status = true;
					$message = Lang::get('m_product_exist_in_db');
				}else{
					$status = false;
				}
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
}
