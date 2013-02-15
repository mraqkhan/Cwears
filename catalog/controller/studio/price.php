<?php  
class ControllerStudioPrice extends Controller {
	private $error = array();
	
	public function index() {
				
		$this->language->load('studio/price');
		
		$this->load->model('opentshirts/composition');
		$this->load->model('opentshirts/product_size');
		$this->load->model('opentshirts/product_color');
		$this->load->model('opentshirts/product');
		$this->load->model('opentshirts/price_product');
		$this->load->model('opentshirts/price_printing');
		$this->load->model('opentshirts/price_quote');
		
		//unset($this->session->data['order']);
		
		$all_sizes = $this->model_opentshirts_product_size->getSizes();
		$all_colors = $this->model_opentshirts_product_color->getColors();
		
		$filters = array();
		
		$this->data['price_id_composition'] = false;
		/*if (isset($this->request->get['idc'])) {
			$filters['filter_editable'] = 1; //validate editable status
			$filters['filter_id_composition'] = $this->request->get['idc'];
			$total = $this->model_composition_composition->getTotalCompositions($filters);
			if($total==1) {
				$this->data['price_id_composition'] = $this->request->get['idc'];
			}
    	} else if (isset($this->request->post['price_id_composition'])) {
			$filters['filter_editable'] = 1; //validate editable status
			$filters['filter_id_composition'] = $this->request->post['price_id_composition'];
			$total = $this->model_composition_composition->getTotalCompositions($filters);
			if($total==1) {
				$this->data['price_id_composition'] = $this->request->post['price_id_composition'];
			}
    	}*/
		
		
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateProduct()) {
			
			//get distinct products sizes availables for this product
			$distinct_product_sizes = $this->model_opentshirts_product->getSizes($this->request->post['price_id_product']);
			//get distinct products colors availables for this product
			$distinct_product_colors = $this->model_opentshirts_product->getColors($this->request->post['price_id_product']);
			
			/* HEADER SIZES */
			//get upcharges by sizes for this product
			$product_sizes_upcharge = $this->model_opentshirts_price_product->getSizesUpcharge($this->request->post['price_id_product']);
			//sizes header with upcharge
			$product_sizes_header = array();
			foreach($distinct_product_sizes as $id_product_size) {
				$upcharge = (isset($product_sizes_upcharge[$id_product_size]))?$this->currency->format($product_sizes_upcharge[$id_product_size]):0;
				$product_sizes_header[] = array(
					'name' => $all_sizes[$id_product_size]['initials'], 
					'upcharge' => $upcharge
				);
			}
			/* END SIZES HEADER */


			if(isset($this->request->post['quantity_s_c'])) {
				$this->request->post['quantity_s_c'] = $this->model_opentshirts_price_quote->cleanMatrix($this->request->post['quantity_s_c'],$this->request->post['price_id_product']);
			} else {
				$this->request->post['quantity_s_c'] = $this->model_opentshirts_price_quote->cleanMatrix(array(),$this->request->post['price_id_product']);
			}
			
			/* start working with money $$$ */
			$matrix_color_size_price = array(); //save unit price for every color/size combination
			$product_total = 0;
			$product_upcharge_total = 0;
			$printing_total = 0;
			if ($this->validateMatrixPrinting()) {
				$amount_products = $this->model_opentshirts_price_quote->countProductsInMatrix($this->request->post['quantity_s_c']);
				$printing_prices = $this->model_opentshirts_price_printing->getPrintingPricesFromQuantity($amount_products);
				$color_groups_prices = $this->model_opentshirts_price_product->getColorGroupsPriceFromQuantity($this->request->post['price_id_product'], $amount_products);
				foreach($this->request->post['quantity_s_c'] as $id_product_color=>$array_sizes) {
					foreach($array_sizes as $id_product_size=>$quantity) {
						if($quantity) { //Only colors and sizes available for this product.
						
							$matrix_color_size_price[$id_product_color][$id_product_size] = 0;
							foreach($this->request->post['views_num_colors'] as $key=>$view) {
								$num_colors = (int)$view["num_colors"];
								if($all_colors[$id_product_color]["need_white_base"]=='1') {
									if($view["need_white_base"]=="true")///artwork needs white base
									{
										$num_colors = ($num_colors>0)?$num_colors+1:0; //add 1 color for whitebase
									}	
								}
								//add printing price
								if($num_colors > 0) {
									$printing_total += $printing_prices[$num_colors] * $quantity;
									$matrix_color_size_price[$id_product_color][$id_product_size] += $printing_prices[$num_colors];
								}
							}
							
							//add to product price
							$product_total += $color_groups_prices[$all_colors[$id_product_color]["id_product_color_group"]] * $quantity;
							$matrix_color_size_price[$id_product_color][$id_product_size] += $color_groups_prices[$all_colors[$id_product_color]["id_product_color_group"]];
							
							//add upcharge for larger sizes if needed
							if(isset($product_sizes_upcharge[$id_product_size])) {
								$product_total += $product_sizes_upcharge[$id_product_size] * $quantity;
								$product_upcharge_total += $product_sizes_upcharge[$id_product_size] * $quantity;
								$matrix_color_size_price[$id_product_color][$id_product_size] +=  $product_sizes_upcharge[$id_product_size];
							}
						}
					}
				}
				
				//save unit price for every color/size combination
				foreach($this->request->post['quantity_s_c'] as $id_product_color=>$array_sizes) {
					foreach($array_sizes as $id_product_size=>$quantity) {
						$matrix_color_size_price[$id_product_color][$id_product_size] = 0;
						foreach($this->request->post['views_num_colors'] as $key=>$view) {
							$num_colors = (int)$view["num_colors"];
							if($all_colors[$id_product_color]["need_white_base"]=='1') {
								if($view["need_white_base"]=="true")///artwork needs white base
								{
									$num_colors = ($num_colors>0)?$num_colors+1:0; //add 1 color for whitebase
								}	
							}
							//add printing price
							if($num_colors > 0 && isset($printing_prices[$num_colors])) {
								$matrix_color_size_price[$id_product_color][$id_product_size] += $printing_prices[$num_colors];
							}
						}
						
						//add to product price
						$matrix_color_size_price[$id_product_color][$id_product_size] += $color_groups_prices[$all_colors[$id_product_color]["id_product_color_group"]];
						
						//add upcharge for larger sizes if needed
						if(isset($product_sizes_upcharge[$id_product_size])) {
							$matrix_color_size_price[$id_product_color][$id_product_size] +=  $product_sizes_upcharge[$id_product_size];
						}						
					}
				}
				
	
				$total_price = $product_total + $printing_total;
				$unit_price = $total_price / $amount_products;
			}
		}
		
		if (isset($this->request->post['price_id_product'])) {
			$this->data['price_id_product'] = $this->request->post['price_id_product'];
		} else {
			$this->data['price_id_product'] = '';
		}
		
		if (isset($this->request->post['price_module_collapsed'])) {
			$this->data['price_module_collapsed'] = $this->request->post['price_module_collapsed'];
		} else {
			$this->data['price_module_collapsed'] = '1';
		}
		
		if (!empty($matrix_color_size_price)) {
			foreach($matrix_color_size_price as $id_product_color=>&$sizes) {
				foreach($sizes as $id_product_size=>&$unitPrice) {
					$unitPrice = $this->currency->format($unitPrice);
				}
			}
			$this->data['matrix_color_size_price'] =  $matrix_color_size_price;
		} else {
			$this->data['matrix_color_size_price'] = array();
		}
		
		if (isset($total_price)) {
			$this->data['total_price'] =  $this->currency->format($total_price);
		} else {
			$this->data['total_price'] = $this->currency->format(0);
		}

		if (isset($amount_products)) {
			$this->data['amount_products'] = $amount_products;
		} else {
			$this->data['amount_products'] = 0;
		}

		if (isset($unit_price)) {
			$this->data['unit_price'] = $this->currency->format($unit_price);
		} else {
			$this->data['unit_price'] = $this->currency->format(0);
		}

		if (isset($product_upcharge_total)) {
			$this->data['product_upcharge_total'] = $this->currency->format($product_upcharge_total);
		} else {
			$this->data['product_upcharge_total'] = $this->currency->format(0);
		}

		if (isset($product_total)) {
			$this->data['product_total'] = $this->currency->format($product_total);
		} else {
			$this->data['product_total'] = $this->currency->format(0);
		}
		
		if (isset($printing_total)) {
			$this->data['printing_total'] = $this->currency->format($printing_total);
		} else {
			$this->data['printing_total'] = $this->currency->format(0);
		}

		if (isset($this->request->post['views_num_colors'])) {
			$this->data['views_num_colors'] = $this->request->post['views_num_colors'];
		} else {
			$this->data['views_num_colors'] = array();
		}

		if (isset($this->request->post['quantity_s_c'])) {
			$this->data['matrix_color_size_quantity'] = $this->request->post['quantity_s_c'];
		} else {
			$this->data['matrix_color_size_quantity'] = array();
		}
		
		if (isset($distinct_product_sizes)) {
			$this->data['product_sizes'] = $distinct_product_sizes;
		} else {
			$this->data['product_sizes'] = array();
		}
		
		if (isset($distinct_product_colors)) {
			$this->data['product_colors'] = $distinct_product_colors;
		} else {
			$this->data['product_colors'] = array();
		}
		
		if (isset($product_sizes_header)) {
			$this->data['product_sizes_header'] = $product_sizes_header;
		} else {
			$this->data['product_sizes_header'] = array();
		}
		
		
		$this->data['all_colors'] = $all_colors;
		$this->data['all_sizes'] = $all_sizes;
				
		$this->data['text_total_price'] = $this->language->get('text_total_price');
		$this->data['text_product_price'] = $this->language->get('text_product_price');
		$this->data['text_number_products'] = $this->language->get('text_number_products');
		$this->data['text_price_per_product'] = $this->language->get('text_price_per_product');
		$this->data['text_upcharge_larger_size'] = $this->language->get('text_upcharge_larger_size');
		$this->data['text_product_total'] = $this->language->get('text_product_total');
		$this->data['text_printing_price'] = $this->language->get('text_printing_price');
		$this->data['text_printing_total'] = $this->language->get('text_printing_total');
		$this->data['text_need_underbase'] = $this->language->get('text_need_underbase');
		$this->data['text_total_price'] = $this->language->get('text_total_price');
		$this->data['text_save'] = $this->language->get('text_save');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_no_save'] = $this->language->get('button_no_save');
		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_recalculate'] = $this->language->get('button_recalculate');
		$this->data['action'] = $this->url->link('studio/price', '', 'SSL');
		$this->data['action_add_to_cart'] = $this->url->link('studio/price/update', '', 'SSL');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['hide_matrix'])) {
			$this->data['hide_matrix'] = true;
		} else {
			$this->data['hide_matrix'] = false;
		}
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/studio/price.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/studio/price.tpl';
		} else {
			$this->template = 'default/template/studio/price.tpl';
		}
		
		$this->response->setOutput($this->render());
	}

	public function update() {

		$this->language->load('checkout/cart');

		$this->load->model('opentshirts/product_size');
		$this->load->model('opentshirts/product_color');
		$this->load->model('opentshirts/product');
		$this->load->model('catalog/product');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {  //&& $this->validateUpdate()) {

			$all_sizes = $this->model_opentshirts_product_size->getSizes();
			$all_colors = $this->model_opentshirts_product_color->getColors();
			$product_id = $this->request->post['price_id_product'];
									
			$product_info = $this->model_catalog_product->getProduct($product_id);

			foreach ($this->request->post['quantity_s_c'] as $id_product_color => $sizes) {
				foreach ($sizes as $id_product_size => $quantity) {
					if($quantity) {

						$printing = array();
						foreach ($this->request->post['views_num_colors'] as $value) {
							$printing[] = array('num_colors' => $value['num_colors'], 'name' => $value['name'], 'need_white_base' => $value['need_white_base']);
						}

						$this->cart->addPrintable($this->request->post['price_id_composition'], $quantity, $id_product_color, $id_product_size);

						$success = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $product_id), $product_info['name'], $this->url->link('checkout/cart'));
					}
				}
			}
			/*$product_color_size_quantity = $this->request->post['quantity_s_c'];
			$printing = $this->request->post['views_num_colors'];
			$id_composition = $this->request->post['price_id_composition'];
			
			$this->cart->removeComposition($id_composition);
			$this->cart->addMulti($id_composition, $product_color_size_quantity, $printing);*/
			
		}				


		
		if (isset($this->request->post['remove'])) {
			$this->cart->remove($this->request->post['remove']);
		}
		
		if (isset($this->request->post['redirect'])) {
			$this->redirect($this->request->post['redirect']);
		}
		
		if(!empty($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if(!empty($success)) {
			$this->data['success'] = $success;
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['continue'] =  $this->url->link('checkout/cart');
		$this->data['button_continue'] =  $this->language->get('button_continue');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/studio/cart.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/studio/cart.tpl';
		} else {
			$this->template = 'default/template/studio/cart.tpl';
		}
			
		$json = array(); 	
		$json['output'] = $this->render();
		//$json['redirect'] =  $this->url->link('checkout/cart');
		
		$this->response->setOutput(json_encode($json));
		//$this->response->setOutput($this->render());
	}
	
	/* private functions */
	private function validateUpdate() {
		
		$this->load->model('product/product');
		$this->load->model('composition/composition');
		$this->load->model('price/product');

		if (empty($this->request->post['price_id_composition'])) {
			$this->error['warning'] = sprintf($this->language->get('error_template'), $this->url->link('information/contact'));
		} elseif (!$this->model_composition_composition->getTotalCompositions(array('filter_id_composition'=>$this->request->post['price_id_composition'], 'filter_editable' => '1'))) {
			$this->error['warning'] = sprintf($this->language->get('error_template'), $this->url->link('information/contact'));
		} elseif (empty($this->request->post['price_id_product'])) {
			$this->error['warning'] = $this->language->get('error_product');
		} elseif (!$this->model_product_product->getTotalProductsByID($this->request->post['price_id_product'])) {
			$this->error['warning'] = $this->language->get('error_product');
		} else if ($this->model_price_product->getMinQuantity($this->request->post['price_id_product'])===false) {
			$this->error['warning'] = $this->language->get('error_not_available');
		} else if(!isset($this->request->post['quantity_s_c'])) {
			$this->error['warning'] = $this->language->get('error_matrix');
		}
		
		if(!$this->error) {
		
			$this->load->model('price/printing');
			$this->load->model('price/quote');
		
			$this->request->post['quantity_s_c'] = $this->model_price_quote->cleanMatrix($this->request->post['quantity_s_c'],$this->request->post['price_id_product']);
			
			$amount_products = $this->cart->countProductsInMatrix($this->request->post['quantity_s_c']);
			$product_minimum = $this->model_price_product->getMinQuantity($this->request->post['price_id_product']);
			if ($amount_products==0) {
				$this->error['warning'] = $this->language->get('error_matrix');
			} elseif ($product_minimum>$amount_products) {
				$this->error['warning'] = sprintf($this->language->get('error_min_quantity'), $product_minimum);
			} elseif (!is_array($this->model_price_product->getPriceArrayFromQuantity($this->request->post['price_id_product'],$amount_products))) {
				$this->error['warning'] = $this->language->get('error_not_available');
			} elseif (!is_array($this->request->post['views_num_colors'])) {
				$this->error['warning'] = $this->language->get('error_printing_empty');
			} elseif ($this->model_price_printing->getMaxColors()===false) {
				$this->error['warning'] = $this->language->get('error_printing_max_colors_error');
			} elseif ($this->model_price_printing->getPriceArrayFromQuantity($amount_products)===false) {
				$this->error['warning'] = $this->language->get('error_printing_price_array');
			} else {
				$max_colors =  $this->model_price_printing->getMaxColors();
				$this->load->model('product/color');
				$all_colors = $this->model_product_color->getColors();
				foreach($this->request->post['quantity_s_c'] as $id_product_color=>$array_sizes) {
					foreach($array_sizes as $id_product_size=>$quantity) {
						if($quantity) { //Only colors and sizes available for this product.
							foreach($this->request->post['views_num_colors'] as $key=>$view) {
								$num_colors = (int)$view["num_colors"];
								
								if($all_colors[$id_product_color]["need_white_base"]=='1') {
									if($view["need_white_base"]=="true")///artwork needs white base
									{
										$num_colors = ($num_colors>0)?$num_colors+1:0; //add 1 color for whitebase
									}	
								}
								
								if($num_colors>$max_colors)
								{
									$this->error['warning'] = sprintf($this->language->get('error_printing_max_colors'), $max_colors, $num_colors);
									break;
								}
							}
						}
					}
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateProduct() {
		if (!isset($this->request->post['price_id_product'])) {
			$this->error['warning'] = $this->language->get('error_product');
			$this->error['hide_matrix'] = true;
		} elseif (!$this->model_opentshirts_product->getTotalProductsByID($this->request->post['price_id_product'])) {
			$this->error['warning'] = $this->language->get('error_product');
			$this->error['hide_matrix'] = true;
		}else if ($this->model_opentshirts_price_product->getMinQuantity($this->request->post['price_id_product'])===false) {
			$this->error['warning'] = $this->language->get('error_not_available');
			$this->error['hide_matrix'] = true;
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateMatrixPrinting() {
		$amount_products = $this->model_opentshirts_price_quote->countProductsInMatrix($this->request->post['quantity_s_c']);
		$product_minimum = $this->model_opentshirts_price_product->getMinQuantity($this->request->post['price_id_product']);
		if ($amount_products==0) {
			$this->error['warning'] = $this->language->get('error_matrix');
		} elseif ($product_minimum>$amount_products) {
			$this->error['warning'] = sprintf($this->language->get('error_min_quantity'), $product_minimum);
		} elseif (!is_array($this->model_opentshirts_price_product->getColorGroupsPriceFromQuantity($this->request->post['price_id_product'],$amount_products))) {
			$this->error['warning'] = $this->language->get('error_not_available');
		} elseif (!is_array($this->request->post['views_num_colors'])) {
			$this->error['warning'] = $this->language->get('error_printing_empty');
		} elseif ($this->model_opentshirts_price_printing->getMaxColors()===false) {
			$this->error['warning'] = $this->language->get('error_printing_max_colors_error');
		} elseif ($this->model_opentshirts_price_printing->getPrintingPricesFromQuantity($amount_products)===false) {
			$this->error['warning'] = $this->language->get('error_printing_price_array');
		} else {
			$max_colors =  $this->model_opentshirts_price_printing->getMaxColors();
			$all_colors = $this->model_opentshirts_product_color->getColors();
			foreach($this->request->post['quantity_s_c'] as $id_product_color=>$array_sizes) {
				foreach($array_sizes as $id_product_size=>$quantity) {
					if($quantity) { //Only colors and sizes available for this product.
						foreach($this->request->post['views_num_colors'] as $key=>$view) {
							$num_colors = (int)$view["num_colors"];
							
							if($all_colors[$id_product_color]["need_white_base"]=='1') {
								if($view["need_white_base"]=="true")///artwork needs white base
								{
									$num_colors = ($num_colors>0)?$num_colors+1:0; //add 1 color for whitebase
								}	
							}
							
							if($num_colors>$max_colors)
							{
								$this->error['warning'] = sprintf($this->language->get('error_printing_max_colors'), $max_colors, $num_colors);
								break;
							}
						}
					}
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

}
?>