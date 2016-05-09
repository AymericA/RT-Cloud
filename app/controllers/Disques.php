<?php

class Disques extends \_DefaultController {

	public function __construct(){
		
		parent::__construct();
		$this->title="Disques";
		$this->model="Disque";
	}

	public function frm($id=NULL){
		$disque=$this->getInstance($id);
		$disabled="";
		$this->loadView("formulaire/creation_disque.html",array("disque"=>$disque,"disabled"=>$disabled));
	}

	/*
	 * Action à exécuter après update
	 * par défaut forward vers l'index du contrôleur en cours
	 * @param array $params
	 */

	protected function _postUpdateAction($params){
		//$this->forward(get_class(),"index",$params); // l'action par défaut que j'ai mis en commentaire


	}

	/* (non-PHPdoc)
	 * @see _DefaultController::setValuesToObject()
	 */
	
	protected function setValuesToObject(&$object) {
		parent::setValuesToObject($object);
		$object->setUtilisateur(Auth::getUser());
	}

}
