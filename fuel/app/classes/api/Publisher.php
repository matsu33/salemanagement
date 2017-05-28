<?php
/**
 * 
 */
class Publisher {
	public static function insert($value='')
	{
		$publisher = new Model_Publisher();
		$publisher->publisher_name = $value;
		$publisher->save();
		return $publisher;
	}
}
