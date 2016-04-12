<?php
use micro\controllers\Controller;
use micro\js\Jquery;
use micro\utils\RequestUtils;
class MyDisques extends Controller{
	public function initialize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vHeader.html",array("infoUser"=>Auth::getInfoUser()));
		}
	}
	public function index() {
		echo Jquery::compile();
		$utili= Auth::getUser();
		echo "<h3> Mes disques -> $utili </h3>";
		$this->loadView("disk/index_disk.html");
	}

	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}

}