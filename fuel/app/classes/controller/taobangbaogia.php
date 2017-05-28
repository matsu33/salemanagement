<?php

use Fuel\Core\Fuel;
class Controller_Taobangbaogia extends Controller_Base
{
    
    public $tableName = 'orders';
    public $tableOrderDetail = 'orderdetails';
    public $tableProducts = 'products';
    public $tableProductGroup = 'productgroups';
    public $tableProductPrice = 'prices';
    
    /**
     * Load the template and create the $this->template object if needed
     */
    public function before()
    {
        parent::before();
        
        if (!$this->is_restful()) {
            $arrJS = array(
                'taobangbaogia.js',
                'product_group.js'
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
        $this->template->title   = Lang::get('title_taobangbaogia');
        $this->template->content = View::forge('taobangbaogia/index');
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
                $postData     = Input::param('data');
                $publisher_id = Input::param('publisher_id');
                $date_buy     = Input::param('date_buy');
                $date_buy     = str_replace('/', '-', $date_buy);
                $date_buy     = date('Y-m-d', strtotime($date_buy));
                
                $total = Input::param('total');
                
                $order_type = Constant::ORDER_TYPE_CREATE;
                
                DB::start_transaction();
                $dataInsertOrder = array(
                    'publisher_id' => $publisher_id,
                    'order_type' => $order_type,
                    'total' => $total,
                    'debt' => $total,
                    'paid' => 0,
                    'date_paid' => date('Y-m-d H:i:s'),
                    'create_at' => $date_buy
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
                        
                        //insert order detail
                        $dataInsertOrderDetail = array(
                            'order_id' => $order_id,
                            'product_id' => $product_id,
                            'order_type' => $order_type,
                            'price' => $price,
                            'quanlity' => $quanlity,
                            'money' => $money,
                            'create_at' => $date_buy
                        );
                        
                        $queryInsertOrderDetail = DB::insert($this->tableOrderDetail);
                        $queryInsertOrderDetail->set($dataInsertOrderDetail);
                        $queryResultOrderDetail = $queryInsertOrderDetail->execute();
                        
                        if ($product_group != '0') {
                            //update product group
                            //$this->updateProductGroupWithQuanlity($product_group, $quanlity);
                        } else {
                            //update product
                            //$this->updateProductInstoctWithQuanlity($product_id, $quanlity);
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
            'unit_instock' => \DB::expr($this->tableProducts . ".unit_instock + " . $quanlity)
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
        $this->template->title   = 'Muahang &raquo; Save';
        $this->template->content = View::forge('taobangbaogia/save', $data);
    }
    
    public function action_print()
    {
        $data["subnav"]          = array(
            'print' => 'active'
        );
        $this->template->title   = 'Muahang &raquo; Print';
        $this->template->content = View::forge('taobangbaogia/print', $data);
    }
    
    public function action_update()
    {
        $data["subnav"]          = array(
            'update' => 'active'
        );
        $this->template->title   = 'Muahang &raquo; Update';
        $this->template->content = View::forge('taobangbaogia/update', $data);
    }
    
    public function action_delete()
    {
        $data["subnav"]          = array(
            'delete' => 'active'
        );
        $this->template->title   = 'Muahang &raquo; Delete';
        $this->template->content = View::forge('taobangbaogia/delete', $data);
    }
    
    public function action_excel()
    {
        if (Input::method() == 'POST') {
            $postData = Input::param('data');
            $postData = json_decode($postData, true);
            
            // EXCEL temporary path
            $tpl_dir = APPPATH . 'tmp/';
            
            // Load excel
            \Package::load('excel');
            // Load temporary excel
            $objPHPExcel = \PHPExcel_IOFactory::load($tpl_dir . 'tpl_taobangbaogia.xls');
            // Set active sheet
            $activeSheet = $objPHPExcel->setActiveSheetIndex(0);
            
            $count       = 14;
            foreach ($postData as $key => $value) {
                $activeSheet->setCellValue('B' . $count, $value['category_name']);
                $activeSheet->setCellValue('C' . $count, $value['material_name']);
                $activeSheet->setCellValue('D' . $count, $value['diameter']);
                $activeSheet->setCellValue('E' . $count, $value['length']);
                $activeSheet->setCellValue('F' . $count, $value['product_range']);
                $activeSheet->setCellValue('G' . $count, $value['unit_name']);
                $activeSheet->setCellValue('H' . $count, $value['quanlity']);
                $activeSheet->setCellValue('I' . $count, $value['buy_price']);
                $count++;
            }
            
            // Rename worksheet
            $activeSheet->setTitle('bangbaogia');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
            
            $timestamp = time();
            $fileName = "bang_bao_gia_".$timestamp.".xls";
            
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename='.$fileName);
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }
    
    public function action_getProductPrice()
    {
    	$data = null;
    	if (Input::method() == 'POST') {
    		$product_id = Input::param('product_id');
    
    		$querySelect = DB::select()->from($this->tableProductPrice);
    	  
    		$querySelect->where($this->tableProductPrice . '.product_id', $product_id);
    
    		$querySelect->where($this->tableProductPrice . '.selected_price', '1');
    
    		$data = $querySelect->execute()->as_array();
    	}
    
    	return $data;
    }
}
