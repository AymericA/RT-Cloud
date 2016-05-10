<?php

class Disques extends \_DefaultController {

	public function __construct(){
		
		parent::__construct();
		$this->title="Disques";
		$this->model="Disque";
	}

	public function frm($id=NULL){

		$disabled="";
		$disque=$this->getInstance($id);

		if($disque->getUtilisateur() != NULL) {
			$iduser = $disque->getUtilisateur()->getId();
		} else {
			$iduser = Auth::getUser()->getId();
			$disque = new stdClass();
			$disque->id = 0;
			$disque->nom = "";
		}

		$this->loadView("formulaire/creation_disque.html",array("disque"=>$disque,"disabled"=>$disabled, "iduser"=>$iduser));
	}


	/* (non-PHPdoc)
	 * @see _DefaultController::setValuesToObject()
	 */
	
	protected function setValuesToObject(&$object) {
		parent::setValuesToObject($object);
		if(isset($_POST["idUtilisateur"])) {
			$user = micro\orm\DAO::getOne('Utilisateur', $_POST["idUtilisateur"]);
			$object->setUtilisateur($user);
		}
	}

	/*
 		* Action à exécuter après update
 		* par défaut forward vers l'index du contrôleur en cours
 		* @param array $params
 	*/

	protected function _postUpdateAction($params){
		//$this->forward(get_class(),"index",$params); // l'action par défaut
		$this->forward("MyDisques", "index" );

	}

	protected function onAdd($object){
		$cloud=$GLOBALS["config"]["cloud"];
		$pathname=$cloud["root"].$cloud["prefix"].Auth::getUser()->getLogin()."/".$object->getNom();
		DirectoryUtils::mkDir($pathname);
	}
}



/*

 */