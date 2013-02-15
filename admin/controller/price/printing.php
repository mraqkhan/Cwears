<?php
class ControllerPricePrinting extends Controller {
	private $error = array();

  	public function index() {
		
		$this->load->language('price/printing');
		
		$this->load->model('price/printing');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('price/printing', 'token=' . $this->session->data['token'] , 'SSL'),
			'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('price/printing/save', 'token=' . $this->session->data['token'] , 'SSL');


		$price = $this->model_price_printing->getPrice();
		$quantities = $this->model_price_printing->getQuantities();
		$max_colors = $this->model_price_printing->getMaxColors();
		
		$this->data['text_add_quantity'] = $this->language->get('text_add_quantity');
		
		$this->data['symbol_right'] = $this->currency->getSymbolRight();
		$this->data['symbol_left'] = $this->currency->getSymbolLeft();
		$this->data['text_minimum_quantity'] = $this->language->get('text_minimum_quantity');
		$this->data['text_increment'] = $this->language->get('text_increment');
		$this->data['text_colors'] = $this->language->get('text_colors');
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_save'] = $this->language->get('button_save');


		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}


		if (isset($this->request->post['quantities'])) {
			$this->data['quantities'] = $this->request->post['quantities'];
		} elseif (!empty($quantities)) { 
			$this->data['quantities'] = $quantities;
		} else {
			$this->data['quantities'] = array('0','12');
		}
		
		if (isset($this->request->post['price'])) {
			$this->data['price'] = $this->request->post['price'];
		} elseif (!empty($price)) { 
			$this->data['price'] = $price;
		} else {
			$this->data['price'] = array();
			$this->data['price'][1][0] = 1.5;
			$this->data['price'][1][1] = 1.4;
			$this->data['price'][2][0] = 2.9;
			$this->data['price'][2][1] = 2.8;
		}
		
		if (isset($this->request->post['max_colors'])) {
			$this->data['max_colors'] = $this->request->post['max_colors'];
		} elseif (!empty($max_colors)) { 
			$this->data['max_colors'] = $max_colors;
		} else {
			$this->data['max_colors'] = 2;
		}
		
		$this->data['printing_colors_limit'] = ($this->config->get('printing_colors_limit'))?$this->config->get('printing_colors_limit'):5;
		
		if (isset($this->error['error_quantities'])) {
			$this->data['error_quantities'] = $this->error['error_quantities'];
		} else {
			$this->data['error_quantities'] = '';
		}

		if (isset($this->error['error_price'])) {
			$this->data['error_price'] = $this->error['error_price'];
		} else {
			$this->data['error_price'] = '';
		}
		
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->template = 'printing/price.tpl';
		
		$this->response->setOutput($this->render());
  	}
	
	public function save() {
		
		$this->load->language('price/printing');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
					
			$this->load->model('price/printing');
			
			$this->model_price_printing->savePrice($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$this->redirect($this->url->link('price/printing', 'token=' . $this->session->data['token'] , 'SSL'));
		}
		
    	$this->index();
  	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'price/printing')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if(!isset($this->request->post['quantities']) || !is_array($this->request->post['quantities'])) {
			$this->error['error_quantities'] = $this->language->get('error_quantities');
		} else {
			foreach($this->request->post['quantities'] as $value) {
				if(!preg_match("/^[0-9]+$/",$value)) {
					$this->error['error_quantities'] = $this->language->get('error_quantities');
				}
			}
		}
		
		if(!isset($this->request->post['price']) || !is_array($this->request->post['price'])) {
			$this->error['error_price'] = $this->language->get('error_price');
		} else {
			foreach($this->request->post['price'] as $prices) {
				foreach($prices as $value) {
					if(!preg_match("/^[0-9]+(.[0-9]+)?$/",$value)) {
						$this->error['error_price'] = $this->language->get('error_price');
					}
				}
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    


			
}
?>