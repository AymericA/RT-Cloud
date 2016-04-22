<?php
use micro\controllers\Controller;
use micro\js\Jquery;
use micro\utils\RequestUtils;

class MyDisques extends Controller
{
	public function initialize()
	{
		if (!RequestUtils::isAjax()) {
			$this->loadView("main/vHeader.html", array("infoUser" => Auth::getInfoUser()));
		}
	}

	public function index()
	{
		echo Jquery::compile();
		$users = Auth::getUser();
		$disque=micro\orm\DAO::getOneToMany($users, "disques");
		ModelUtils::sizeConverter("Mo");
		$this->loadView("MyDisques/index_disk.html", array("users"=>$users, "disque"=>$disque));
	}
	/*public function index() {
		echo Jquery::compile();
		$user=Auth::getUser();
		$disques=micro\orm\DAO::getOneToMany($user, "disques");
		foreach($disques as $disque){
			$occupation=$disque->getOccupation();
			ModelUtils::sizeConverter("Go");
			$this->loadview("MyDisques/index_disk.html",array("disque"=>$disque,"occu"=>$occupation));
		}

	}*/





	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}
?>