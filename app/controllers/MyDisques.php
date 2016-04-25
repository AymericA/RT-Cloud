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






	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}
?>