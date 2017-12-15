<?php
class Controller_Units extends Controller_Base
{
	public $tableName = 'units';
	
	/**
	 * Load the template and create the $this->template object if needed
	 */
	public function before ()
	{
		parent::before();
		
		if (! $this->is_restful()) {
			$arrJS = array('unit.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}

	/**
	 * list all unit
	 */
	public function action_index()
	{
        //init sql
        $selectColumns = array(
            "id",
            "unit_name");
        //excute
        $querySelect = DB::select_array($selectColumns)->from($this->tableName);
        $querySelect->order_by('unit_name','ASC');
        $data['listData'] = $querySelect->execute()->as_array();

		$this->template->title = Lang::get('title_unit');
		$this->template->content = View::forge('units/index', $data);
	}
	
	/*****************************************************************************
	 ***API unit*************************************************************
	 *****************************************************************************/
	/**
	 * get all unit
	 */
	public function action_getAll()
	{
		//init variable
		$result = null;
		$status = true;
		$message = Lang::get('m_no_error');
		$data = null;
		
		try{
			//Cache::delete_all("db.unit");
			//init sql 
			$selectColumns = array(
				"id",
				"unit_name");
			//excute
			$querySelect = DB::select_array($selectColumns)->from($this->tableName);
			$querySelect->order_by('unit_name','ASC');
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
				$unit_name = Input::post('unit_name');
				
				$dataInsert = array(
					'unit_name' => $unit_name,
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
                    'unit_name' => Input::post('unit_name')
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

}
