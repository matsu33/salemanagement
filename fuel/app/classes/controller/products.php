<?php
class Controller_Products extends Controller_Template
{

	public function action_index()
	{
		$data['products'] = Model_Product::find('all');
		$this->template->title = "Products";
		$this->template->content = View::forge('products/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('products');

		if ( ! $data['product'] = Model_Product::find($id))
		{
			Session::set_flash('error', 'Could not find product #'.$id);
			Response::redirect('products');
		}

		$this->template->title = "Product";
		$this->template->content = View::forge('products/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Product::validate('create');

			if ($val->run())
			{
				$product = Model_Product::forge(array(
					'category_id' => Input::post('category_id'),
					'name' => Input::post('name'),
				));

				if ($product and $product->save())
				{
					Session::set_flash('success', 'Added product #'.$product->id.'.');

					Response::redirect('products');
				}

				else
				{
					Session::set_flash('error', 'Could not save product.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Products";
		$this->template->content = View::forge('products/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('products');

		if ( ! $product = Model_Product::find($id))
		{
			Session::set_flash('error', 'Could not find product #'.$id);
			Response::redirect('products');
		}

		$val = Model_Product::validate('edit');

		if ($val->run())
		{
			$product->category_id = Input::post('category_id');
			$product->name = Input::post('name');

			if ($product->save())
			{
				Session::set_flash('success', 'Updated product #' . $id);

				Response::redirect('products');
			}

			else
			{
				Session::set_flash('error', 'Could not update product #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$product->category_id = $val->validated('category_id');
				$product->name = $val->validated('name');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('product', $product, false);
		}

		$this->template->title = "Products";
		$this->template->content = View::forge('products/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('products');

		if ($product = Model_Product::find($id))
		{
			$product->delete();

			Session::set_flash('success', 'Deleted product #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete product #'.$id);
		}

		Response::redirect('products');

	}

}
