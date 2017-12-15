<?php

class Controller_Update extends Controller_Base
{
	/**
	 * Load the template and create the $this->template object if needed
	 */
	public function before ()
	{
		parent::before();
		
		if (! $this->is_restful()) {
			$arrJS = array('update.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}
	
	/**
	 * view price list
	 */
	public function action_index()
	{
        // find all articles
        $configVersion = Model_Config::getVersion();
        $isConnect = $this->is_connected();

        //get latest version
        $latestVersion = $configVersion;
        if($isConnect){
            $latestVersion = $this->getLatestVersionFromGithub();
            if($latestVersion == ''){
                $latestVersion = $configVersion;
            }
        }

        $data['currentVersion'] = $configVersion;
        $data['latestVersion'] = $latestVersion;
        $data['hasInternet'] = $isConnect;

        $displayUpdateButton = false;
        if($latestVersion > $configVersion){
            $displayUpdateButton = true;
        }
        $data['displayUpdateButton'] = $displayUpdateButton;

        $this->template->title = Lang::get('title_update');
        $this->template->content = View::forge ( 'update/index', $data );
	}

	function action_getUpdatedCodeFromGithub(){
        //init variable
        $result = null;
        $status = true;
        $message = Lang::get('m_no_error');
        $data = null;

        try{
            //check method is post or get
            if (Input::method() == 'POST'){
                //update code
				$data = shell_exec("cd .. && git reset --hard && git checkout master && git pull");
				
                //udpate current version
                $latestVersion = Input::param('latest_version');
                Model_Config::updateLatestVersion($latestVersion);

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

	function getLatestVersionFromGithub(){
        $gitConfigUrl = 'https://raw.githubusercontent.com/matsu33/salemanagement/master/config.json';
        try{
            $configServerString = $this->readFileWithUrl($gitConfigUrl);
            $configServerJson = json_decode($configServerString);
            $latestVersion = $configServerJson->latest_version;

            return $latestVersion;
        }catch (Exception $e){
            return '';
        }
    }

    function is_connected()
    {
        try{
            $connected = fopen("http://www.google.com:80/","r");
            if($connected)
            {
                return true;
            } else {
                return false;
            }
        }catch (Exception $e){
            return false;
        }
    }

    function readFileWithUrl($urlToRead){
        try {
            $options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
            $context  = stream_context_create($options);
            $content = file_get_contents($urlToRead, false, $context);

            if ($content === false) {
                // Handle the error
                return '';
            }
            return $content;
        } catch (Exception $e) {
            // Handle exception
            return '';
        }
    }

    /*****************************************************************************
	 ***API *********************************************************************
	 *****************************************************************************/
	/**
	 * get all price
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
											"product_id",
											"publisher_id",
											"publisher_name",
											"input_price",
											"category_id",
											"category_name",
											"material_id",
											"material_name",
											"size_id",
											"diameter",
											"length",
											"product_range",
											"unit_id",
											"unit_name",
											"image",
											"product_group"
											)
				->from($this->tableName)
				->join('publishers','LEFT')
				->on($this->tableName.'.publisher_id', '=', 'publishers.id')
				->join('products','LEFT')
				->on($this->tableName.'.product_id', '=', 'products.id')
				->join('categories','LEFT')
				->on('products.category_id', '=', 'categories.id')
				->join('materials','LEFT')
				->on('products.material_id', '=', 'materials.id')
				->join('sizes','LEFT')
				->on('products.size_id', '=', 'sizes.id')
				->join('units','LEFT')
				->on('products.unit_id', '=', 'units.id');
				$querySelect->order_by('id','DESC');
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
				$product_id = Input::post('product_id');
				$publisher_id = Input::post('publisher_id');
				$input_price = Input::post('input_price');
				
				$dataInsert = array(
					'product_id' => $product_id,
					'publisher_id' => $publisher_id,
					'input_price' => $input_price,
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
	
	/**
	 * Update
	 */
	public function action_update()
	{
		$result = null;
		$status = true;
		$message = '';
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$id = Input::post('id');

				$input_price = Input::post('input_price');

				$unit_id = Input::post('unit_id');

				$material_id = Input::post('material_id');
				$product_id = Input::post('product_id');
				$category_id = Input::post('category_id');

				$diameter = Input::post('diameter');
				$length = Input::post('input_length');
				$product_range = Input::post('input_product_range');

				//get size id
				$querySelect = DB::select_array(array('id'))->from('sizes');
				$querySelect->where('diameter', (int)$diameter);
				$querySelect->and_where('length', (int)$length);
				$querySelect->and_where('product_range', (float)$product_range);
				$querySelect->limit(1);
				$size = $querySelect->execute()->as_array();
				$size_id = null;

				if(count($size) > 0){
					$size_id = $size[0]['id'];
				}else{
					$modelSize = Model_Size::forge(array(
						'diameter' => $diameter,
						'length' => $length,
						'product_range' => (float)$product_range,
						'create_at' => date('Y-m-d H:i:s'),
					));

					$modelSize->save();

					$size_id = $modelSize->id;

				}

				//get exist product
				$querySelect = DB::select("products.id")
					->from('products');
				$querySelect->where('category_id', $category_id);
				$querySelect->where('material_id', $material_id);
				$querySelect->where('unit_id', $unit_id);
				$querySelect->where('size_id', $size_id);
				$querySelect->where('product_group', 0);
				$querySelect->limit(1);
				$data = $querySelect->execute()->as_array();
				$productId = $product_id;

				if(count($data) > 0){
					//exist size
					$productId = $data[0]['id'];
				}else {

					$modelProduct = Model_Product::forge(array(
						'category_id' => $category_id,
						'material_id' => $material_id,
						'size_id' => $size_id,
						'unit_id' => $unit_id,
						'product_group' => 0,
						'create_at' => date('Y-m-d H:i:s'),
					));

					$modelProduct->save();

					$productId = $modelProduct->id;
				}

				//init query update
				$query = DB::update($this->tableName);

				$arrayUpdate = array(
					'input_price' => $input_price
				);

				if($productId != $product_id){
					$arrayUpdate['product_id'] = $productId;
				}
				//set data
                $query->set($arrayUpdate);

                $query->where('id',$id);
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
			$message = Lang::get('e_common_sql'). ' (file:'.$e->getFile().')(line '.$e->getLine().') : '.$e->getMessage();
		}
		$result = array('status' => $status, 'message' => $message);
		return $result;
	}

// 	public function action_save()
// 	{
// 		$data["subnav"] = array('save'=> 'active' );
// 		$this->template->title = 'Bangbaogia &raquo; Save';
// 		$this->template->content = View::forge('bangbaogia/save', $data);
// 	}

// 	public function action_print()
// 	{
// 		$data["subnav"] = array('print'=> 'active' );
// 		$this->template->title = 'Bangbaogia &raquo; Print';
// 		$this->template->content = View::forge('bangbaogia/print', $data);
// 	}

	/**
	 * search price of product of publisher
	 */
	public function action_search()
	{
		//init variable
		$result = null;
		$status = true;
		$message = Lang::get('m_no_error');
		$data = null;
		$lastQuery = null;
		
		try{
			//check method is post or get
			if (Input::method() == 'POST'){
				$pid = Input::post('pid');
				$pubid = Input::post('pubid');
				
				//init sql
				$querySelect = DB::select($this->tableName.".id",
											"product_id",
											"publisher_id",
											"publisher_name",
											"input_price",
											"category_id",
											"category_name",
											"material_id",
											"material_name",
											"size_id",
											"diameter",
											"length",
											"product_range",
											"unit_id",
											"unit_name",
											"image",
											"product_group"
											)
				->from($this->tableName)
				->join('publishers','LEFT')
				->on($this->tableName.'.publisher_id', '=', 'publishers.id')
// 				->and_on($this->tableName.'.publisher_id', '=', $pubid)
				->join('products','LEFT')
				->on($this->tableName.'.product_id', '=', 'products.id')
// 				->and_on($this->tableName.'.product_id', '=', $pid)
				->join('categories','LEFT')
				->on('products.category_id', '=', 'categories.id')
				->join('materials','LEFT')
				->on('products.material_id', '=', 'materials.id')
				->join('sizes','LEFT')
				->on('products.size_id', '=', 'sizes.id')
				->join('units','LEFT')
				->on('products.unit_id', '=', 'units.id')
				->where($this->tableName.'.publisher_id', '=', $pubid)
				->and_where($this->tableName.'.product_id', '=', $pid)
				->order_by('id','DESC');
				$lastQuery = DB::last_query();
				$data = $querySelect->execute()->as_array();
			}else{
				$status = false;
				$message = Lang::get('e_not_valid_method');
			}
		}catch (Exception $e){
			$status = false;
			//$message = Lang::get('e_common_sql');
			$message = $e->getMessage();
		}
		
		//set result
		$result = array('status' => $status, 'message' => $message, 'data' => $data, 'lastquery' => $lastQuery);
		
		//return
		return $result;
	}

}
