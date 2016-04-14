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
		$utili=Auth::getUser();


		#$i= ModelUtils::getDisqueOccupation($GLOBALS["config"]["cloud"],["1".$utili]);

		$this->loadView("MyDisques/index_disk.html",array("utili"=>$utili));

	}

	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}
?>