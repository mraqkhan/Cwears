<?php
class ControllerProductRegion extends Controller {
	
  	public function form($data = array()) {
		
		$this->load->language('product/region');
		
		$this->data['length_unit'] = $this->length->getUnit($this->config->get('config_length_class_id'));
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_width'] = sprintf($this->language->get('entry_width'),$this->data['length_unit']);
		$this->data['entry_height'] = sprintf($this->language->get('entry_height'),$this->data['length_unit']);
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['text_x'] = $this->language->get('text_x');
		$this->data['text_y'] = $this->language->get('text_y');
		$this->data['text_default'] = $this->language->get('text_default');
		
		if (!empty($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$this->load->model('product/product');
			$product = $this->model_product_product->getProduct($this->request->get['product_id']);	
			$default_region = $product['default_view'].'_'.$product['default_region'];
		}
		

		if (!empty($data)) {
			$view_index = $data['view_index'];
			$region_index = $data['region_index'];
			$name = $data['name'];
			$x = $data['x'];
			$y = $data['y'];
			$width = $data['width'];
			$height = $data['height'];
		}

		if (isset($view_index)) { 
			$this->data['view_index'] = $view_index;
		} else {
			$this->data['view_index'] = $this->request->get['view_index'];
		}
		
		if (isset($region_index)) { 
			$this->data['region_index'] = $region_index;
		} else {
			$this->data['region_index'] = mt_rand();
		}
		
		if (!empty($name)) { 
			$this->data['name'] = $name;
		} else {
			$this->data['name'] = 'print area';
		}
		
		if (!empty($x)) { 
			$this->data['x'] = $x;
		} else {
			$this->data['x'] = '10';
		}
		
		if (!empty($y)) { 
			$this->data['y'] = $y;
		} else {
			$this->data['y'] = '15';
		}

		if (!empty($width)) { 
			$this->data['width'] = $width;
		} else {
			$this->data['width'] = '10';
		}

		if (!empty($height)) { 
			$this->data['height'] = $height;
		} else {
			$this->data['height'] = '10';
		}
		
		if (isset($this->request->post['default_region'])) { 
			$this->data['default_region'] = $this->request->post['default_region'];
		} else if (isset($default_region)) { 
			$this->data['default_region'] = $default_region;
		} else {
			$this->data['default_region'] = '';
		}
		
		$this->template = 'product/region_item.tpl';
		$this->response->setOutput($this->render());

	}
}
?>