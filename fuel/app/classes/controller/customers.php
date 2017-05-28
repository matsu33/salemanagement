<?php
class Controller_Customers extends Controller_Base
{
	public $tableName = 'customers';
	/**
	 * Add customer
	 */
	public function action_addCustomer()
	{
		$result = null;
		$status = true;
		$message = Lang::get('m_insert_success');
	
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$customer_name = Input::param('customer_name');
	
				$dataInsertCustomer = array(
						'customer_name' => $customer_name,
						'create_at' => date('Y-m-d H:i:s'),
				);
	
				$queryInsertCustomer = DB::insert($this->tableName);
				$queryInsertCustomer->set($dataInsertCustomer);
				$queryResult = $queryInsertCustomer->execute();
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
				//init sql
				$querySelect = DB::select($this->tableName.".id",
						"customer_name")
						->from($this->tableName);
				$querySelect->order_by('update_at','DESC');
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
	
	public function action_index()
	{
		$data['customers'] = Model_Customer::find('all');
		$this->template->title = "Customers";
		$this->template->content = View::forge('customers/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('customers');

		if ( ! $data['customer'] = Model_Customer::find($id))
		{
			Session::set_flash('error', 'Could not find customer #'.$id);
			Response::redirect('customers');
		}

		$this->template->title = "Customer";
		$this->template->content = View::forge('customers/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Customer::validate('create');

			if ($val->run())
			{
				$customer = Model_Customer::forge(array(
					'customer_type' => Input::post('customer_type'),
					'customer_name' => Input::post('customer_name'),
				));

				if ($customer and $customer->save())
				{
					Session::set_flash('success', 'Added customer #'.$customer->id.'.');

					Cache::delete("db.customer");
					
					Response::redirect('customers');
				}

				else
				{
					Session::set_flash('error', 'Could not save customer.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Customers";
		$this->template->content = View::forge('customers/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('customers');

		if ( ! $customer = Model_Customer::find($id))
		{
			Session::set_flash('error', 'Could not find customer #'.$id);
			Response::redirect('customers');
		}

		$val = Model_Customer::validate('edit');

		if ($val->run())
		{
			$customer->customer_type = Input::post('customer_type');
			$customer->customer_name = Input::post('customer_name');

			if ($customer->save())
			{
				Session::set_flash('success', 'Updated customer #' . $id);

				Cache::delete("db.customer");
				
				Response::redirect('customers');
			}

			else
			{
				Session::set_flash('error', 'Could not update customer #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$customer->customer_type = $val->validated('customer_type');
				$customer->customer_name = $val->validated('customer_name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('customer', $customer, false);
		}

		$this->template->title = "Customers";
		$this->template->content = View::forge('customers/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('customers');

		if ($customer = Model_Customer::find($id))
		{
			$customer->delete();

			Session::set_flash('success', 'Deleted customer #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete customer #'.$id);
		}

		Response::redirect('customers');

	}

}
