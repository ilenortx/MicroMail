<?php

class AdminBase extends ControllerBase{
	
	public function initialize(){
		$this->view->setTemplateAfter('admin');
		
	}
	
}

