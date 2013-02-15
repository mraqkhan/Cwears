<?php
class ControllerModuleOpentshirts extends Controller {
	private $error = array(); 
	 
	public function index() {   
		$this->load->language('module/opentshirts');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('opentshirts', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_bitmap'] = $this->language->get('text_bitmap');
		$this->data['text_bitmaps'] = $this->language->get('text_bitmaps');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');	
		$this->data['text_category'] = $this->language->get('text_category');
		$this->data['text_clipart'] = $this->language->get('text_clipart');
		$this->data['text_cliparts'] = $this->language->get('text_cliparts');
		$this->data['text_composition'] = $this->language->get('text_composition');
		$this->data['text_compositions'] = $this->language->get('text_compositions');
		$this->data['text_design_color'] = $this->language->get('text_design_color');
		$this->data['text_font'] = $this->language->get('text_font');
		$this->data['text_fonts'] = $this->language->get('text_fonts');
		$this->data['text_installer'] = $this->language->get('text_installer');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_printing'] = $this->language->get('text_printing'); 
		$this->data['text_printing_pricing'] = $this->language->get('text_printing_pricing'); 
		$this->data['text_products'] = $this->language->get('text_products'); 
		$this->data['text_product'] = $this->language->get('text_product'); 
		$this->data['text_product_color'] = $this->language->get('text_product_color'); 
		$this->data['text_product_size'] = $this->language->get('text_product_size'); 

		$this->data['entry_logo'] = $this->language->get('entry_logo');
		$this->data['entry_template'] = $this->language->get('entry_template');
		$this->data['entry_theme'] = $this->language->get('entry_theme');
		$this->data['entry_video_tutorial_link'] = $this->language->get('entry_video_tutorial_link');
		$this->data['entry_home_button_link'] = $this->language->get('entry_home_button_link');
		$this->data['entry_printing_colors_limit'] = $this->language->get('entry_printing_colors_limit');

		$this->data['tab_data'] = $this->language->get('tab_data'); 

		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_save'] = $this->language->get('button_save');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/opentshirts', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/opentshirts', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];

		$this->data['bitmap'] = $this->url->link('bitmap/bitmap', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['bitmap_category'] = $this->url->link('bitmap/category', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['clipart'] = $this->url->link('clipart/clipart', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['clipart_category'] = $this->url->link('clipart/category', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['composition'] = $this->url->link('opentshirts/composition', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['composition_category'] = $this->url->link('opentshirts/composition_category', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['design_color'] = $this->url->link('design_color/design_color', 'token=' . $this->session->data['token'], 'SSL');	
		$this->data['font'] = $this->url->link('font/font', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['font_category'] = $this->url->link('font/category', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['installer'] = $this->url->link('content_pack/install', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['printing_pricing'] = $this->url->link('price/printing', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['product'] = $this->url->link('product/product', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['product_color'] = $this->url->link('product/color', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['product_size'] = $this->url->link('product/size', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['product_manufacturer'] = $this->url->link('product/manufacturer', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['product_category'] = $this->url->link('product/category', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['ot_config_logo'])) {
			$this->data['ot_config_logo'] = $this->request->post['ot_config_logo'];
		} else {
			$this->data['ot_config_logo'] = $this->config->get('ot_config_logo');			
		}

		$this->load->model('tool/image');

		if ($this->config->get('ot_config_logo') && file_exists(DIR_IMAGE . $this->config->get('ot_config_logo')) && is_file(DIR_IMAGE . $this->config->get('ot_config_logo'))) {
			$this->data['ot_logo'] = $this->model_tool_image->resize($this->config->get('ot_config_logo'), 370, 70);		
		} else {
			$this->data['ot_logo'] = $this->model_tool_image->resize('no_image.jpg', 370, 70);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 370, 70);

		if (isset($this->request->post['video_tutorial_embed'])) {
			$this->data['video_tutorial_embed'] = $this->request->post['video_tutorial_embed'];
		} else {
			$this->data['video_tutorial_embed'] = $this->config->get('video_tutorial_embed');			
		}

		if (isset($this->request->post['home_button_link'])) {
			$this->data['home_button_link'] = $this->request->post['home_button_link'];
		} else {
			$this->data['home_button_link'] = $this->config->get('home_button_link');			
		}

		if (isset($this->request->post['printing_colors_limit'])) {
			$this->data['printing_colors_limit'] = $this->request->post['printing_colors_limit'];
		} else if($this->config->get('printing_colors_limit')) {
			$this->data['printing_colors_limit'] = $this->config->get('printing_colors_limit');			
		} else {
			$this->data['printing_colors_limit'] = 5;	
		}

		$this->data['config_template'] = $this->config->get('config_template');
		
		$this->data['themes'] = array();
		
		$directories = glob(DIR_CATALOG . 'view/theme/'.$this->config->get('config_template').'/stylesheet/*', GLOB_ONLYDIR);
		
		foreach ($directories as $directory) {
			$this->data['themes'][] = basename($directory);			
		}	

		if (!$directories) {
			$this->data['themes'][] = $this->language->get('text_none');	
		}
		
		if (isset($this->request->post['config_theme'])) {
			$this->data['config_theme'] = $this->request->post['config_theme'];
		} else {
			$this->data['config_theme'] = $this->config->get('config_theme');
		}					

		$this->template = 'module/opentshirts.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/opentshirts')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	public function theme_thumb() {
		$template = basename($this->request->get['template']);
		$theme = basename($this->request->get['theme']);
		
		if (file_exists(DIR_IMAGE . 'templates/' . $template . '/' . $theme . '.png')) {
			$image = HTTP_IMAGE . 'templates/' . $template . '/' . $theme . '.png';
		} else {
			$image = HTTP_IMAGE . 'no_image.jpg';
		}
		
		$this->response->setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
	}		

	
	public function uninstall() {		
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "bitmap`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "bitmap_category`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "bitmap_bitmap_category`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "bitmap_keyword`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "clipart`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "clipart_category`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "clipart_clipart_category`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "clipart_keyword`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "clipart_layers`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "composition`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "composition_to_order`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "composition_category`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "composition_composition_category`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "composition_keyword`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "design`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "design_color`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "design_element`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "font`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "font_category`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "font_font_category`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "font_keyword`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printing_quantity`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printing_quantity_price`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product`;");
		//$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_category`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_color`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_color_flat_color`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_color_group`;");
		//$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_keyword`;");		
		//$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_manufacturer`;");
		//$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_product_category`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_product_color_product_size`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_quantity`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_quantity_price`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_size`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_size_upcharge`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_view`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_view_fill`;");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "printable_product_view_region`;");

		$this->load->model('catalog/option');
		if($this->config->get('product_color_option_id')) {
			$this->model_catalog_option->deleteOption($this->config->get('product_color_option_id'));
		}
		if($this->config->get('product_size_option_id')) {
			$this->model_catalog_option->deleteOption($this->config->get('product_size_option_id'));
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = 'opentshirts'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = 'opentshirts_setting'");

	}
	public function install() {
		
		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "bitmap` (
			  `id_bitmap` char(36) COLLATE utf8_bin NOT NULL,
			  `name` varchar(50) COLLATE utf8_bin NOT NULL,
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `image_file` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `colors` text COLLATE utf8_bin NOT NULL,
			  `deleted` tinyint(1) NOT NULL,
			  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `from_customer` tinyint(1) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id_bitmap`),
			  FULLTEXT KEY `name` (`name`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "bitmap_category` (
			  `id_category` char(36) COLLATE utf8_bin NOT NULL,
			  `parent_category` char(36) COLLATE utf8_bin DEFAULT NULL,
			  `description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  PRIMARY KEY (`id_category`),
			  KEY `index` (`parent_category`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "bitmap_bitmap_category` (
			  `id_bitmap` char(36) COLLATE utf8_bin NOT NULL,
			  `id_category` char(36) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`id_bitmap`,`id_category`),
			  KEY `fk_id_bitmap` (`id_bitmap`),
			  KEY `fk_id_category` (`id_category`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "bitmap_keyword` (
			  `id_bitmap` char(36) COLLATE utf8_bin NOT NULL,
			  `keyword` varchar(50) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`id_bitmap`,`keyword`),
			  KEY `fk_id_bitmap` (`id_bitmap`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "clipart` (
			  `id_clipart` char(36) COLLATE utf8_bin NOT NULL,
			  `name` varchar(50) COLLATE utf8_bin NOT NULL,
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `swf_file` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `vector_file` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `vector_file_2` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `image_file` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `deleted` tinyint(1) NOT NULL,
			  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id_clipart`),
			  FULLTEXT KEY `name` (`name`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "clipart_category` (
			  `id_category` char(36) COLLATE utf8_bin NOT NULL,
			  `parent_category` char(36) COLLATE utf8_bin DEFAULT NULL,
			  `description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  PRIMARY KEY (`id_category`),
			  KEY `index` (`parent_category`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "clipart_clipart_category` (
			  `id_clipart` char(36) COLLATE utf8_bin NOT NULL,
			  `id_category` char(36) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`id_clipart`,`id_category`),
			  KEY `fk_ot_clipart_clipart_category_ot_clipart` (`id_clipart`),
			  KEY `fk_ot_clipart_clipart_category_ot_clipart_category` (`id_category`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "clipart_keyword` (
			  `id_clipart` char(36) COLLATE utf8_bin NOT NULL,
			  `keyword` varchar(50) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`id_clipart`,`keyword`),
			  KEY `fk_ot_clipart_keyword_ot_clipart` (`id_clipart`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "clipart_layers` (
			  `id_clipart` char(36) COLLATE utf8_bin NOT NULL,
			  `sorting` smallint(6) NOT NULL,
			  `name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `id_design_color` char(36) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`id_clipart`,`sorting`),
			  KEY `fk_ot_clipart_layers_ot_clipart` (`id_clipart`),
			  KEY `fk_ot_clipart_layers_ot_design_color` (`id_design_color`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "composition` (
			  `id_composition` char(36) COLLATE utf8_bin NOT NULL,
			  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `id_author` bigint(20) NOT NULL,
			  `id_product_color` char(36) COLLATE utf8_bin NOT NULL,
			  `product_id` int(11) NOT NULL,
			  `status` tinyint(1) NOT NULL DEFAULT '0',
			  `deleted` tinyint(1) NOT NULL DEFAULT '0',
			  `editable` tinyint(1) NOT NULL DEFAULT '1',
			  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id_composition`),
			  KEY `fk_ot_composition_ot_user1` (`id_author`),
			  KEY `fk_ot_composition_ot_product_color1` (`id_product_color`),
			  KEY `fk_ot_composition_ot_product1` (`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "composition_to_order` (
			  `id_composition` char(36) COLLATE utf8_bin NOT NULL,
			  `order_id` int(11) NOT NULL,
			  PRIMARY KEY (`id_composition`,`order_id`),
			  KEY `fk_id_composition` (`id_composition`),
			  KEY `fk_order_id` (`order_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "composition_category` (
			  `id_category` char(36) COLLATE utf8_bin NOT NULL,
			  `parent_category` char(36) COLLATE utf8_bin DEFAULT NULL,
			  `description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  PRIMARY KEY (`id_category`),
			  KEY `index` (`parent_category`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "composition_composition_category` (
			  `id_composition` char(36) COLLATE utf8_bin NOT NULL,
			  `id_category` char(36) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`id_composition`,`id_category`),
			  KEY `fk_ot_composition_composition_category_ot_composition_category1` (`id_category`),
			  KEY `fk_id_composition` (`id_composition`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "composition_keyword` (
			  `keyword` varchar(50) COLLATE utf8_bin NOT NULL,
			  `id_composition` char(36) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`keyword`,`id_composition`),
			  KEY `fk_ot_composition_keyword_ot_composition1` (`id_composition`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "design` (
			  `id_composition` char(36) COLLATE utf8_bin NOT NULL,
			  `id_design` char(36) COLLATE utf8_bin NOT NULL,
			  `xml` longtext COLLATE utf8_bin,
			  `num_colors` TINYINT NOT NULL DEFAULT '0',
			  `need_white_base` TINYINT NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id_design`),
			  KEY `fk_ot_design_ot_composition1` (`id_composition`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "design_color` (
			  `id_design_color` char(36) COLLATE utf8_bin NOT NULL,
			  `name` varchar(50) COLLATE utf8_bin NOT NULL,
			  `hexa` varchar(6) COLLATE utf8_bin NOT NULL,
			  `alpha` smallint(6) NOT NULL DEFAULT '100',
			  `code` varchar(20) COLLATE utf8_bin NOT NULL,
			  `need_white_base` tinyint(1) NOT NULL DEFAULT '1',
			  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
			  `available` tinyint(1) NOT NULL,
			  `deleted` tinyint(1) NOT NULL,
			  PRIMARY KEY (`id_design_color`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "design_element` (
			  `id_design` char(36) COLLATE utf8_bin NOT NULL,
			  `sorting` tinyint(3) unsigned NOT NULL,
			  `id_design_element` char(36) COLLATE utf8_bin NOT NULL,
			  `type` tinyint(1) unsigned NOT NULL,
			  PRIMARY KEY (`id_design`,`sorting`),
			  KEY `type` (`type`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "font` (
			  `id_font` char(36) COLLATE utf8_bin NOT NULL,
			  `name` varchar(50) COLLATE utf8_bin NOT NULL,
			  `status` tinyint(1) NOT NULL,
			  `swf_file` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `ttf_file` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `deleted` tinyint(1) NOT NULL DEFAULT '0',
			  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id_font`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "font_category` (
			  `id_category` char(36) COLLATE utf8_bin NOT NULL,
			  `parent_category` char(36) COLLATE utf8_bin DEFAULT NULL,
			  `description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  PRIMARY KEY (`id_category`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "font_font_category` (
			  `id_font` char(36) COLLATE utf8_bin NOT NULL,
			  `id_category` char(36) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`id_font`,`id_category`),
			  KEY `fk_ot_font_font_category_ot_font1` (`id_font`),
			  KEY `fk_ot_font_font_category_ot_font_category1` (`id_category`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "font_keyword` (
			  `id_font` char(36) COLLATE utf8_bin NOT NULL,
			  `keyword` varchar(50) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`id_font`,`keyword`),
			  KEY `fk_ot_font_keyword_ot_font1` (`id_font`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printing_quantity` (
			  `quantity_index` int(11) NOT NULL,
			  `quantity` int(11) DEFAULT NULL,
			  PRIMARY KEY (`quantity_index`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printing_quantity_price` (
			  `quantity_index` int(11) NOT NULL,
			  `num_colors` int(11) NOT NULL,
			  `price` float DEFAULT NULL,
			  PRIMARY KEY (`quantity_index`,`num_colors`),
			  KEY `fk_ot_printing_quantity_quantity_index` (`quantity_index`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product` (
			  `product_id` int(11) NOT NULL,
			  `default_view` int(11) DEFAULT NULL,
			  `default_region` int(11) DEFAULT NULL,
			  `default_color` char(36) COLLATE utf8_bin DEFAULT NULL,
			  `colors_number` smallint(6) NOT NULL,
			  PRIMARY KEY (`product_id`),
			  KEY `fk_default_view` (`default_view`),
			  KEY `fk_default_region` (`default_region`),
			  KEY `fk_default_color` (`default_color`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		/*$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_category` (
			  `id_category` char(36) COLLATE utf8_bin NOT NULL,
			  `parent_category` char(36) COLLATE utf8_bin DEFAULT NULL,
			  `description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  PRIMARY KEY (`id_category`),
			  KEY `index` (`parent_category`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");*/

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_color` (
			  `id_product_color` char(36) COLLATE utf8_bin NOT NULL,
			  `name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `num_colors` smallint(6) NOT NULL DEFAULT '1',
			  `need_white_base` tinyint(1) NOT NULL,
			  `deleted` tinyint(1) NOT NULL DEFAULT '0',
			  `id_product_color_group` int(11) NOT NULL,
			  `option_value_id` int(11) NOT NULL,
			  PRIMARY KEY (`id_product_color`),
			  KEY `fk_ot_product_color_ot_product_color_group1` (`id_product_color_group`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_color_flat_color` (
			  `id_product_color` char(36) COLLATE utf8_bin NOT NULL,
			  `flat_color_index` int(11) NOT NULL,
			  `hexa` varchar(6) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`id_product_color`,`flat_color_index`),
			  KEY `fk_ot_product_color_simple_color_ot_product_color1` (`id_product_color`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_color_group` (
			  `id_product_color_group` int(11) NOT NULL AUTO_INCREMENT,
			  `description` varchar(30) COLLATE utf8_bin NOT NULL,
			  `color` varchar(6) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`id_product_color_group`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;
		");


		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_product_color_product_size` (
			  `product_id` int(11) NOT NULL,
			  `id_product_color` char(36) COLLATE utf8_bin NOT NULL,
			  `id_product_size` char(36) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`product_id`,`id_product_color`,`id_product_size`),
			  KEY `fk_id_product_color` (`id_product_color`),
			  KEY `fk_product_id` (`product_id`),
			  KEY `fk_id_product_size` (`id_product_size`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_quantity` (
			  `product_id` int(11) NOT NULL,
			  `quantity_index` int(11) NOT NULL,
			  `quantity` int(11) NOT NULL,
			  PRIMARY KEY (`product_id`,`quantity_index`),
			  KEY `fk_product_id` (`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_quantity_price` (
			  `product_id` int(11) NOT NULL,
			  `quantity_index` int(11) NOT NULL,
			  `id_product_color_group` int(11) NOT NULL,
			  `price` float NOT NULL,
			  PRIMARY KEY (`product_id`,`quantity_index`,`id_product_color_group`),
			  KEY `fk_quantity_index_product_id` (`quantity_index`,`product_id`),
			  KEY `fk_id_product_color_group` (`id_product_color_group`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_size` (
			  `id_product_size` char(36) COLLATE utf8_bin NOT NULL,
			  `description` varchar(255) COLLATE utf8_bin NOT NULL,
			  `initials` varchar(10) COLLATE utf8_bin NOT NULL,
			  `apply_additional_cost` tinyint(1) NOT NULL DEFAULT '0',
			  `sort` smallint(6) NOT NULL DEFAULT '0',
			  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=no 1=yes',
			  `option_value_id` int(11) NOT NULL,
			  PRIMARY KEY (`id_product_size`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_size_upcharge` (
			  `product_id` int(11) NOT NULL,
			  `id_product_size` char(36) COLLATE utf8_bin NOT NULL,
			  `upcharge` float DEFAULT NULL,
			  PRIMARY KEY (`product_id`,`id_product_size`),
			  KEY `fk_id_product_size` (`id_product_size`),
			  KEY `fk_product_id` (`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_view` (
			  `product_id` int(11) NOT NULL,
			  `view_index` int(11) NOT NULL,
			  `name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `regions_scale` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '0',
			  `shade` varchar(255) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`view_index`,`product_id`),
			  KEY `fk_product_id` (`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_view_fill` (
			  `product_id` int(11) NOT NULL,
			  `view_index` int(11) NOT NULL,
			  `view_fill_index` int(11) NOT NULL,
			  `file` varchar(255) COLLATE utf8_bin NOT NULL,
			  PRIMARY KEY (`product_id`,`view_index`,`view_fill_index`),
			  KEY `fk_view_index_product_id` (`view_index`,`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");

		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "printable_product_view_region` (
			  `product_id` int(11) NOT NULL,
			  `view_index` int(11) NOT NULL,
			  `region_index` int(11) NOT NULL,
			  `name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `x` float NOT NULL,
			  `y` float NOT NULL,
			  `width` float NOT NULL,
			  `height` float NOT NULL,
			  PRIMARY KEY (`product_id`,`view_index`,`region_index`),
			  KEY `fk_view_index_product_id` (`view_index`,`product_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
		");


		

		//--  INSERTS ---------------------------------------------------------------


		$this->db->query("
			INSERT INTO `" . DB_PREFIX . "design_color` (`id_design_color`, `name`, `hexa`, `alpha`, `code`, `need_white_base`, `isdefault`, `available`, `deleted`) VALUES
			('b4571a94-8e48-11e1-a524-00e05290a0fd', 'White', 'ffffff', 100, '', 1, 1, 1, 0),
			('b4645fce-8e48-11e1-a524-00e05290a0fd', 'Black', '000000', 100, '', 0, 1, 1, 0),
			('b48179b0-8e48-11e1-a524-00e05290a0fd', 'Red', 'd5422d', 100, '', 1, 1, 1, 0),
			('b478ffb2-8e48-11e1-a524-00e05290a0fd', 'Grass Green', '64AF3A', 100, '', 1, 1, 1, 0),
			('b47b4cd5-8e48-11e1-a524-00e05290a0fd', 'Brown', '844E0D', 100, '', 1, 1, 1, 0),
			('b453ae35-8e48-11e1-a524-00e05290a0fd', 'Grey', 'acacac', 100, '', 1, 1, 1, 0),
			('b4846e01-8e48-11e1-a524-00e05290a0fd', 'Yellow', 'f1df37', 100, '', 1, 1, 1, 0),
			('b4867cd4-8e48-11e1-a524-00e05290a0fd', 'Green', '65b294', 100, '', 1, 1, 1, 0),
			('b47e8e1c-8e48-11e1-a524-00e05290a0fd', 'Light Orange', 'FFB387', 100, '', 1, 1, 1, 0),
			('b47af505-8e48-11e1-a524-00e05290a0fd', 'Blue', '2704a1', 100, '', 1, 1, 1, 0),
			('b47d3b48-8e48-11e1-a524-00e05290a0fd', 'Light Blue', '199CFF', 100, '', 1, 1, 1, 0),
			('b4835130-8e48-11e1-a524-00e05290a0fd', 'Light grey', 'E6E6E6', 100, '', 1, 1, 1, 0),
			('b47f3256-8e48-11e1-a524-00e05290a0fd', 'Dark Grey', '5E5D5D', 100, '', 1, 1, 1, 0),
			('b4803088-8e48-11e1-a524-00e05290a0fd', 'Skin', 'FFDAC2', 100, '', 1, 1, 1, 0),
			('b47cca08-8e48-11e1-a524-00e05290a0fd', 'Magenta', 'B7006C', 100, '', 1, 1, 1, 0),
			('b48733a6-8e48-11e1-a524-00e05290a0fd', 'Orange', 'd26e13', 100, '', 1, 1, 1, 0),
			('b47a3d0e-8e48-11e1-a524-00e05290a0fd', 'Medium Orange', 'D97F1A', 100, '', 1, 1, 1, 0),
			('b487b009-8e48-11e1-a524-00e05290a0fd', 'Purple', '9f24b2', 100, '', 1, 1, 1, 0);
		");

		$this->db->query("
			INSERT INTO `" . DB_PREFIX . "printable_product_color_group` (`id_product_color_group`, `description`, `color`) VALUES
			(1, 'light', 'FFFFFF'),
			(2, 'medium', 'DDDDDD'),
			(3, 'dark', '888888');
		");

		$this->db->query("			
			INSERT INTO `" . DB_PREFIX . "setting` (`group`, `key`, `value`, `serialized`) VALUES
			('opentshirts', 'video_tutorial_embed', '', 0),
			('opentshirts', 'printing_colors_limit', '10', 0),
			('opentshirts', 'config_max_product_color_combination', '5', 0),
			('opentshirts', 'config_theme', 'redmond', 0);
		");

		///option product_color
		$this->db->query("INSERT INTO `" . DB_PREFIX . "option` SET type = 'select', sort_order = '1'");		
		$option_id = $this->db->getLastId();		
		global $languages;
		foreach($languages as $language) {
			$data['option_description'][$language['language_id']] = array('name'=>'Product Color');
		}	
		foreach ($data['option_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "option_description SET option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `group` = 'opentshirts_setting', `key` = 'product_color_option_id', `value` = '" . $option_id . "'");

		///option product_size
		$this->db->query("INSERT INTO `" . DB_PREFIX . "option` SET type = 'select', sort_order = '1'");		
		$option_id = $this->db->getLastId();		
		global $languages;
		foreach($languages as $language) {
			$data['option_description'][$language['language_id']] = array('name'=>'Product Size');
		}	
		foreach ($data['option_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "option_description SET option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}
		$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `group` = 'opentshirts_setting', `key` = 'product_size_option_id', `value` = '" . $option_id . "'");


	}
}
?>