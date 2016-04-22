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
klkk
	public function index()
	{
		echo Jquery::compile();
		$utili = Auth::getUser();
		$disques = micro\orm\DAO::getOneToMany($utili, "disques");
		#foreach ($disques as $disque) {
			#$i=ModelUtils::getDisqueTarif($disques);

		#}
		$this->loadView("MyDisques/index_disk.html",array("utili"=>$utili,"disque"=>$disques));
	}





	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}
?>