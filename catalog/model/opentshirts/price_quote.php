<?php
class ModelOpentshirtsPriceQuote extends Model {

	public function countProductsInMatrix($matrix_color_size_quantity)
	{
		$total_number_products = 0;
		foreach($matrix_color_size_quantity as $id_product_color=>$sizes)
		{
			foreach($sizes as $id_product_size=>$quantity)
			{
				if(is_numeric($quantity) && (int)$quantity>0)
				{
					$total_number_products += (int)($quantity);
				}
			}
		}
		return $total_number_products;
	}
	
	/*
	* Check what sizes and colors are valid for this particular product 
	* and verifies that the values ​​of quantities received are integers.
	*/
	public function cleanMatrix($matrix_color_size_quantity, $id_product)
	{
		$this->load->model('opentshirts/product');

		//product colors and sizes
		$distinct_product_colors = $this->model_opentshirts_product->getColors($id_product);
		$distinct_product_sizes = $this->model_opentshirts_product->getSizes($id_product);	
		$available_colors_sizes = $this->model_opentshirts_product->getColorsSizes($id_product);
		
		$validMatrix = array();
		foreach($distinct_product_colors as $id_product_color) {
			foreach($distinct_product_sizes as $id_product_size) {
				if(isset($available_colors_sizes[$id_product_color][$id_product_size])) { //Only colors and sizes available for this product.
					//validate quantities
					if(!empty($matrix_color_size_quantity[$id_product_color][$id_product_size]) && is_numeric($matrix_color_size_quantity[$id_product_color][$id_product_size]) && (int)$matrix_color_size_quantity[$id_product_color][$id_product_size]>0) {
						$quantity = (int)$matrix_color_size_quantity[$id_product_color][$id_product_size];
					} else {
						$quantity = 0;
					}
					///hold quantities for each product size/color available for this product
					$validMatrix[$id_product_color][$id_product_size] = $quantity;
				} else {
					$validMatrix[$id_product_color][$id_product_size] = false;
				}
			}
		}
		return $validMatrix;		
	}
	
	private function getMatrixColorSizePrice($total_number_products, $id_product)
	{
		$this->load->model('opentshirts/price_product');
		$this->load->model('opentshirts/product');
		$this->load->model('opentshirts/product_color');

		///count matrix		
		$color_group_price_array = $this->model_opentshirts_price_product->getPriceArrayFromQuantity($id_product, $total_number_products);
		
		$sizes_upcharge_array = $this->model_opentshirts_price_product->getSizesUpcharge($id_product);
		
		$all_colors = $this->model_opentshirts_product_color->getColors();
		
		$available_colors_sizes = $this->model_opentshirts_product->getColorsSizes($id_product);
		
		$matrix_color_size_price = array();
		foreach($available_colors_sizes as $id_product_color=>$product_sizes) {
			foreach($product_sizes as $id_product_size=>$boolean) {
				
				//get id_product_color_group from id_product_color
				$id_product_color_group = $all_colors[$id_product_color]["id_product_color_group"];
				$matrix_color_size_price[$id_product_color][$id_product_size] = $color_group_price_array[$id_product_color_group];
				
				///add upcharge based on size
				$upcharge = (!empty($sizes_upcharge_array[$id_product_size]))?$sizes_upcharge_array[$id_product_size]:0;
				$matrix_color_size_price[$id_product_color][$id_product_size] += $upcharge;
			}
		}
		return $matrix_color_size_price;
	}
	/**
	*** Returs True if at least one product color is dark or medium (that means that we need a white base)
	***/
	public function needWhiteBase($matrix_color_size_quantity)
	{
		$this->load->model('opentshirts/product_color');

		$all_colors = $this->model_opentshirts_product_color->getColors(); //all color on the DB
		
		foreach($matrix_color_size_quantity as $id_product_color=>$sizes)
		{
			foreach($sizes as $id_product_size=>$quantity)
			{
				if(is_numeric($quantity) && $quantity>0)
				{
					//if at least one product needs white base, printer needs to make a whitebase screen
					if($all_colors[$id_product_color]["need_white_base"]=='1')
					{
						return true;
					}
				}
			}
		}
		return false;
	}
	/**
	* 	Product Price
	*/
	public function getProductQuote($id_product, $matrix_color_size_quantity)
	{
		
		$this->load->model('opentshirts/price_product');
		
		//$clean_matrix_color_size_quantity = $this->cleanMatrix($matrix_color_size_quantity, $id_product);
		$clean_matrix_color_size_quantity = $matrix_color_size_quantity;

		$product_total = 0;
		$upcharge_larger_size = 0;

		//$product_data = $this->model_product_product->getProduct($id_product);
		$product_sizes_upcharge = $this->model_opentshirts_price_product->getSizesUpcharge($id_product);
		$number_products = $this->countProductsInMatrix($clean_matrix_color_size_quantity);
		$matrix_color_size_price = $this->getMatrixColorSizePrice($number_products, $id_product);
		
		foreach($clean_matrix_color_size_quantity as $id_product_color=>$sizes)
		{
			foreach($sizes as $id_product_size=>$quantity)
			{
				if($quantity!==false) {
					$unitPrice = $matrix_color_size_price[$id_product_color][$id_product_size];
					$product_total += $unitPrice * $quantity;
					$upcharge = (!empty($product_sizes_upcharge[$id_product_size]))?$product_sizes_upcharge[$id_product_size]:0;
					$upcharge_larger_size += $upcharge * $quantity;
				}
			}
		}
		$price_per_product = round($product_total/$number_products, 2);
		
		$return = array();			
		$return["number_products"] = $number_products;
		$return["matrix_color_size_price"] = $matrix_color_size_price;
		$return["price_per_product"] = $price_per_product;
		$return["upcharge_larger_size"] = $upcharge_larger_size;
		$return["product_total"] = $product_total;
		
		return $return;
		
	}
	
	/**
	*	--- PRINTING PRICE ---
	**/
	public function getPrintQuote($views_num_colors, $number_products)
	{
		$this->load->model('opentshirts/price_printing');
		
		$printing_subtotal = array();
		$printing_unit_price = array();
		$printing_total = 0;
		if (!empty($views_num_colors))
		{
			foreach($views_num_colors as $key=>$view)
			{							
				if($unitPrice = $this->model_opentshirts_price_printing->getUnitPrice($view['num_colors'],$number_products))
				{
					$printing_unit_price[$key] = (float)$unitPrice;
					$printing_subtotal[$key] = (float)$unitPrice * $number_products;
					$printing_total += (float)$printing_subtotal[$key];
				}
			}				
		}
				
		$return = array();
		$return["number_products"] = $number_products;
		$return["printing_subtotal"] = $printing_subtotal;
		$return["printing_unit_price"] = $printing_unit_price;
		$return["printing_total"] = $printing_total;
		
		return $return;
	}

}
?>