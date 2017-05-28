<?php

class Model_Coupon extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'customer_id',
		'product_id',
		'coupon_price',
		'create_at',
		'update_at',
	);


	protected static $_table_name = 'coupons';

}
