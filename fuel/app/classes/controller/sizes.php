<?php
class Controller_Sizes extends Controller_Base
{
	public $tableName = 'sizes';
	
	/**
	 * Load the template and create the $this->template object if needed
	 */
	public function before ()
	{
		parent::before();
		
		if (! $this->is_restful()) {
			$arrJS = array('size.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}

	/**
	 * list all size
	 */
	public function action_index()
	{	
		$this->template->title = Lang::get('title_size');
		$this->template->content = View::forge('sizes/index');
	}
	
	/*****************************************************************************
	 ***API size*************************************************************
	 *****************************************************************************/
	/**
	 * get all size
	 */
	public function action_getAll()
	{
		//init variable
		$result = null;
		$status = true;
		$message = Lang::get('m_no_error');
		$data = null;
		
		try{
			//init sql 
			$selectColumns = array(
				"id",
				"diameter",
				"length",
				"product_range");
			//excute
			$querySelect = DB::select_array($selectColumns)->from($this->tableName);
			$querySelect->order_by('update_at','DESC');
			$data = $querySelect->execute()->as_array();
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
				$diameter = Input::post('diameter');
				$length = Input::post('length');
				$product_range = Input::post('product_range');
				
				$dataInsert = array(
					'diameter' => $diameter,
					'length' => $length,
					'product_range' => $product_range,
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
				//set data
                $query->set(array(
					'diameter' => Input::post('diameter'),
					'length' => Input::post('length'),
					'product_range' => Input::post('product_range')
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
	 * checkExist
	 */
	public function action_checkExist()
	{
		$result = null;
		$status = true;
		$message = '';
		$data = null;
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$diameter = Input::post('diameter');
				$length = Input::post('length');
				$product_range = Input::post('product_range');
				
				//init sql 
				$selectColumns = array(
					"id",
					"diameter",
					"length",
					"product_range");
				//excute
				$querySelect = DB::select_array($selectColumns)->from($this->tableName);
				$querySelect->where('diameter', (int)$diameter);
				$querySelect->and_where('length', (int)$length);
				$querySelect->and_where('product_range', (float)$product_range);
				$querySelect->order_by('update_at','DESC');
				$querySelect->limit(1);
				$size = $querySelect->execute()->as_array();
				
				if(count($size) > 0){
					$data = $size[0]['id'];
				}else{
					$modelSize = Model_Size::forge(array(
							'diameter' => $diameter,
							'length' => $length,
							'product_range' => (float)$product_range
					));

					$modelSize->save();
					
					$data = $modelSize->id;
					
				}
			} else {
				//invalid method GET
				$status = false;
				$message = Lang::get('e_not_valid_method');
			}
		}catch (Exception $e){
			$status = false;
			$message = $e;//Lang::get('e_common_sql');
		}
		$result = array('status' => $status, 'message' => $message, 'size_id' => $data);
		return $result;
	}
}
