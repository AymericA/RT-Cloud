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
		$result= ModelUtils::getDisqueOccupation($GLOBALS["config"]["cloud"],$this);
		return $result;

		#$i= ModelUtils::getDisqueOccupation($GLOBALS["config"]["cloud"],jAppelbaum);

		$this->loadView("MyDisques/index_disk.html",array("utili"=>$utili,"resultat"=>$i));

	}

	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}
?>