<?php

class Controller_Banle extends Controller_Base
{
    
    public $tableName = 'orders';
    public $tableOrderDetail = 'orderdetails';
    public $tableProducts = 'products';
    public $tableProductGroup = 'productgroups';
    
    /**
     * Load the template and create the $this->template object if needed
     */
    public function before()
    {
        parent::before();
        
        if (!$this->is_restful()) {
            $arrJS = array(
                'banle.js',
                'product_group.js',
            	'customer_insert.js'
            );
            //Load js
            Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
        }
    }
    
    /**
     * view index page
     */
    public function action_index()
    {
        $this->template->title   = Lang::get('title_retail');
        $this->template->content = View::forge('banle/index');
    }
    
    /*****************************************************************************
     ***API *********************************************************************
     *****************************************************************************/
    /**
     * Add
     */
    public function action_add()
    {
        $result  = null;
        $status  = true;
        $message = Lang::get('m_insert_success');
        
        try {
            //check method is post or get
            if (Input::method() == 'POST') {
                $postData    = Input::param('data');
                //$customer_id = Input::param('customer_id');
                $date_buy    = Input::param('date_buy');
                $date_buy    = str_replace('/', '-', $date_buy);
                $date_buy    = date('Y-m-d', strtotime($date_buy));
                
                $total = Input::param('total');
                
                $order_type = Constant::ORDER_TYPE_RETAIL;
                
                DB::start_transaction();
                $dataInsertOrder = array(
                    'customer_id' => null,
                	'customer_type' => Constant::TYPE_CUSTOMER_RETAIL,
                    'order_type' => $order_type,
                    'total' => $total,
                    'debt' => 0,
                    'paid' => $total,
                	'status' => Constant::STATUS_PAID,
                    'date_paid' => $date_buy,
                    'create_at' => date('Y-m-d H:i:s')
                );
                
                $queryInsertOrder = DB::insert($this->tableName);
                $queryInsertOrder->set($dataInsertOrder);
                $queryResultOrder = $queryInsertOrder->execute();
                
                $orderId = null;
                if ($queryResultOrder) {
                    //get order id
                    $order_id = $queryResultOrder[0];
                    
                    foreach ($postData as $key => $value) {
                        
                        $product_id    = $value['product_id'];
                        $price         = $value['buy_price'];
                        $quanlity      = $value['quanlity'];
                        $money         = $value['amount'];
                        $product_group = $value['product_group'];
                        
                        $old_instock = $value['unit_instock'];
                        if(!$old_instock) {
                        	$old_instock = 0;
                        }
                        $new_instock = $old_instock - $quanlity;
                        
                        //insert order detail
                        $dataInsertOrderDetail = array(
                            'order_id' => $order_id,
                            'product_id' => $product_id,
                            'order_type' => $order_type,
                            'price' => $price,
                            'quanlity' => $quanlity,
                            'money' => $money,
                            'create_at' => $date_buy,
                        	'old_instock' => $old_instock,
                        	'new_instock' => $new_instock
                        );
                        
                        $queryInsertOrderDetail = DB::insert($this->tableOrderDetail);
                        $queryInsertOrderDetail->set($dataInsertOrderDetail);
                        $queryResultOrderDetail = $queryInsertOrderDetail->execute();
                        
                        if ($product_group != '0') {
                            //update product group
                            $this->updateProductGroupWithQuanlity($product_group, $quanlity);
                        } else {
                            //update product
                            $this->updateProductInstoctWithQuanlity($product_id, $quanlity);
                        }
                    }
                    
                    //commit transaction
                    DB::commit_transaction();
                } else {
                    //no order id -> roll back
                    DB::rollback_transaction();
                    
                    $status  = false;
                    $message = Lang::get('e_common_sql');
                }
            } else {
                $status  = false;
                $message = Lang::get('e_not_valid_method');
            }
        }
        catch (Exception $e) {
            $status  = false;
            $message = Lang::get('e_common_sql');
        }
        $result = array(
            'status' => $status,
            'message' => $message
        );
        return $result;
    }
    
    /**
     * update product with quanlity
     */
    public function updateProductInstoctWithQuanlity($product_id, $quanlity)
    {
        $queryUpdateProduct = DB::update($this->tableProducts);
        
        // Set values
        $queryUpdateProduct->set(array(
            'unit_instock' => \DB::expr($this->tableProducts . ".unit_instock - " . $quanlity)
        ));
        $queryUpdateProduct->where('id', $product_id);
        $queryUpdateProductResult = $queryUpdateProduct->execute();
    }
    
    /**
     * update product group with quanlity
     */
    public function updateProductGroupWithQuanlity($product_group, $quanlity)
    {
        $arrayProductId = $this->getListProductWithGroupId($product_group);
        
        for ($i = 0; $i < count($arrayProductId); $i++) {
            $product_id       = $arrayProductId[$i]['id'];
            $product_quanlity = $arrayProductId[$i]['quanlity'];
            $updateQuanlity   = $product_quanlity * $quanlity;
            $this->updateProductInstoctWithQuanlity($product_id, $updateQuanlity);
        }
    }
    
    /**
     * get list product id of group
     */
    public function getListProductWithGroupId($product_group)
    {
        //init sql
        $querySelect = DB::select($this->tableProducts . ".id", $this->tableProductGroup . '.quanlity')->from($this->tableProducts)->join($this->tableProductGroup, 'LEFT')->on($this->tableProducts . '.product_group', '=', $this->tableProductGroup . '.id');
        
        $querySelect->where($this->tableProducts . '.product_group', $product_group);
        // var_dump($querySelect->compile());exit;
        $data = $querySelect->execute()->as_array();
        
        return $data;
    }
    
    public function action_save()
    {
        $data["subnav"]          = array(
            'save' => 'active'
        );
        $this->template->title   = 'banle &raquo; Save';
        $this->template->content = View::forge('banle/save', $data);
    }
    
    public function action_print()
    {
        $data["subnav"]          = array(
            'print' => 'active'
        );
        $this->template->title   = 'banle &raquo; Print';
        $this->template->content = View::forge('banle/print', $data);
    }
    
    public function action_update()
    {
        $data["subnav"]          = array(
            'update' => 'active'
        );
        $this->template->title   = 'banle &raquo; Update';
        $this->template->content = View::forge('banle/update', $data);
    }
    
    public function action_delete()
    {
        $data["subnav"]          = array(
            'delete' => 'active'
        );
        $this->template->title   = 'banle &raquo; Delete';
        $this->template->content = View::forge('banle/delete', $data);
    }
    
}
