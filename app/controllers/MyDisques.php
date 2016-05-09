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

		if (Auth::isAuth()==True) {
			$users = Auth::getUser();
			$disques = micro\orm\DAO::getOneToMany($users, "disques");
			$this->loadView("MyDisques/index_disk.html", array("users"=>$users));
			foreach($disques as $disque) {
				$nom = $disque->getNom();
				$size = DirectoryUtils::formatBytes($disque->getSize());
				$quota = DirectoryUtils::formatBytes($disque->getQuota());
				$occupation = $disque->getOccupation();
				$id = $disque->getId();
				$this->loadView("MyDisques/disque.html",array("nom"=>$nom, "size"=>$size, "quota"=>$quota, "occupation"=>$occupation,
					"id"=>$id));
			}
		}
		else{
			echo "Vous devez vous connecter.";
		}
	}






	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}
?>