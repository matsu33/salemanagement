<?php

class Controller_Congno extends Controller_Base
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
			$arrJS = array('muahang.js','product_group.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}
	
	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = 'Congno &raquo; Index';
		$this->template->content = View::forge('congno/index', $data);
	}

	public function action_no_nha_cung_cap()
	{
		$this->template->title = Lang::get('title_publisher_debt');
		$this->template->content = View::forge('congno/publisher_debt');
	}
	
	public function action_no_khach_hang()
	{
		$this->template->title = Lang::get('title_customer_debt');
		$this->template->content = View::forge('congno/customer_debt');
	}
	
	public function action_publisher_search_day()
	{
		$data["subnav"] = array('publisher_search_day'=> 'active' );
		$this->template->title = 'Congno &raquo; Publisher search day';
		$this->template->content = View::forge('congno/publisher_search_day', $data);
	}

	public function action_publisher_search_month()
	{
		$data["subnav"] = array('publisher_search_month'=> 'active' );
		$this->template->title = 'Congno &raquo; Publisher search month';
		$this->template->content = View::forge('congno/publisher_search_month', $data);
	}

	public function action_publisher_search_year()
	{
		$data["subnav"] = array('publisher_search_year'=> 'active' );
		$this->template->title = 'Congno &raquo; Publisher search year';
		$this->template->content = View::forge('congno/publisher_search_year', $data);
	}

	public function action_publisher_paid()
	{
		$data["subnav"] = array('publisher_paid'=> 'active' );
		$this->template->title = 'Congno &raquo; Publisher paid';
		$this->template->content = View::forge('congno/publisher_paid', $data);
	}

	public function action_customer_search_day()
	{
		$data["subnav"] = array('customer_search_day'=> 'active' );
		$this->template->title = 'Congno &raquo; Customer search day';
		$this->template->content = View::forge('congno/customer_search_day', $data);
	}

	public function action_customer_search_month()
	{
		$data["subnav"] = array('customer_search_month'=> 'active' );
		$this->template->title = 'Congno &raquo; Customer search month';
		$this->template->content = View::forge('congno/customer_search_month', $data);
	}

	public function action_customer_search_year()
	{
		$data["subnav"] = array('customer_search_year'=> 'active' );
		$this->template->title = 'Congno &raquo; Customer search year';
		$this->template->content = View::forge('congno/customer_search_year', $data);
	}

	public function action_customer_paid()
	{
		$data["subnav"] = array('customer_paid'=> 'active' );
		$this->template->title = 'Congno &raquo; Customer paid';
		$this->template->content = View::forge('congno/customer_paid', $data);
	}

}
