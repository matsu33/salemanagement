<?php

class Controller_Banhang extends Controller_Hybrid
{
	public $template = '';
	//protected $require_auth = false;
	
public function before ()
	{
		parent::before();

		if (! $this->is_restful()) {
			/* $isLogined  = \Auth::check();
			if($isLogined){
				Response::redirect('home/index');
			} */
			
			//http://peter.sh/experiments/asynchronous-and-deferred-javascript-execution-explained/
			//for asyn loading js
			$scriptAttr = array(
				'defer'
			);
			$arrJS = array('libs/jquery/jquery.min.js', 'libs/underscore-min.js','libs/autoNumeric.js',
					//bootstrap
					'libs/bootstrap/js/bootstrap.min.js',
					
					//using for validate
					'libs/jquery-validation/jquery.validate.js',
					'libs/jquery-validation/localization/messages_vi.js',
					
					//dataTables
					'libs/dataTables/jquery.dataTables.js',
					'libs/dataTables/dataTables.bootstrap.js',
						
					//using for validate
					'libs/jquery-validation/jquery.validate.js',
					'libs/jquery-validation/localization/messages_vi.js',
						
					//create template in js
					'libs/doT/doT.min.js',
					'libs/omss/template.js',
						
					//datetime js
					'libs/datetimepicker/js/moment.js',
					'libs/datetimepicker/js/bootstrap-datetimepicker.min.js',
						
					//utility omss
					'libs/omss/omss.js',
						
					//common
					'libs/common.js',
					'product_group.js',
					'customer_insert.js',
					//current page
					'banhang.js');
			
			$arrCSS = array('libs/bootstrap.min.css', 'style.css');
			
			// Load common css
			Asset::css($arrCSS, $scriptAttr, 'banhang_css', false);
			
			//Load js
			Asset::js($arrJS, $scriptAttr, 'banhang_script', false);
		}
	}
	
		
	public function action_index()
	{
		$data['title']   = "Bán hàng";
		
		// returned Response object takes precedence and will show content without template
		return new Response(View::forge('banhang/index', $data));
	}

	/**
	 * search
	 */
	public function action_search()
	{
		$result = null;
		$status = true;
		$message = '';
		$data = null;
		$sizeId = null;
		$lastQuery = null;
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$select_category = Input::post('select_category');
				$select_material = Input::post('select_material');
				$select_unit = Input::post('select_unit');
				$input_diameter = Input::post('input_diameter');
				$input_length = Input::post('input_length');
				$input_product_range = Input::post('input_product_range');
	
				//init sql
				$selectColumns = array("id");
				//excute
					$querySelect = DB::select_array($selectColumns)->from("sizes");
					$querySelect->where('diameter', $input_diameter);
					$querySelect->and_where('length', $input_length);
					$querySelect->and_where('product_range', $input_product_range);
					$querySelect->order_by('update_at','DESC');
					$querySelect->limit(1);
					$size = $querySelect->execute()->as_array();
					$lastQuery = DB::last_query();
					
					if(count($size) > 0){
						//got size id
						$sizeId = $size[0]['id'];
						
						//get product id
						$querySelectProduct = DB::select("products.id",
								"products.unit_instock",
								"prices.wholesales_price",
								"prices.wholesales_price2",
								"prices.wholesales_price3",
								"prices.retail_price")
						->from("products")->join('prices','LEFT')->on("products.id", "=", "prices.product_id")
						->and_on("prices.selected_price", "=", DB::expr(1));
						$querySelectProduct->where('category_id', $select_category);
						$querySelectProduct->where('material_id', $select_material);
						$querySelectProduct->where('size_id', $sizeId);
						$querySelectProduct->where('unit_id', $select_unit);
						$querySelectProduct->limit(1);
						//var_dump($querySelectProduct->compile());exit;
						$product = $querySelectProduct->execute()->as_array();

						$lastQuery = DB::last_query();
						if(count($product) > 0){
							$data = $product;
						}else{
							$status = false;
							$message = "Sản phẩm không tồn tại";
						}
					}else{
						$status = false;
						$message = "Qui cách không tồn tại";
					}
					
				} else {
					//invalid method GET
					$status = false;
					$message = Lang::get('e_not_valid_method');
				}
			}catch (Exception $e){
				$status = false;
				$message = Lang::get('e_common_sql');
			}
			$result = array('status' => $status, 'message' => $message, 'data' => $data, 'lastQuery' => $lastQuery);
			return $result;
		}
}
