<?php

class Controller_Home extends Controller_Base
{
	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = Lang::get('title_home');
		$this->template->content = View::forge('home/index', $data);
	}

}
