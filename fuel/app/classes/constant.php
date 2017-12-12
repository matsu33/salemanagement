<?php

/**
 * Constant
 * 
 * @author Nguyen Van Tung
 * @since 2014/12/02
 */
class Constant
{
    const ORDER_TYPE_BUY = 1;
	const ORDER_TYPE_SALE = 2;
    const ORDER_TYPE_WHOLESALE = 2;
    const ORDER_TYPE_RETAIL = 2;
    const ORDER_TYPE_INVENTORY = 3;
    /* const ORDER_TYPE_CREATE = 3;
    const ORDER_TYPE_TRANSPORT = 4;
    const ORDER_TYPE_ORDER = 5; */
    const STATUS_PAID = 1;
    const STATUS_DEBT = 2;
    
    const TYPE_CUSTOMER_WHOLESALE = 1;
    const TYPE_CUSTOMER_RETAIL = 2;
    
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;
}