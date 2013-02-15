<?php 
class ControllerXmlXml extends Controller { 

	public function index() {
		
		$this->data['gateway'] = HTTP_SERVER . 'amfphp/php/';
		$this->template = 'default/template/xml/index.tpl';
		
		$this->response->addHeader("Content-type: text/xml");
		$this->response->setOutput($this->render());
  	}
}
?>