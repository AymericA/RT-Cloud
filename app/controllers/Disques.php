<?php
class Disques extends \_DefaultController {

	public function __construct(){
		parent::__construct();
		$this->title="Disques";
		$this->model="Disque";
	}

	public function frm($id = NULL){
		if (array_key_exists("id",$_POST)) {
			$id = $_POST["id"];
			$name = $_POST["name"];
			$user= $_POST["user"];
			$createdate= $_POST["createdate"];
			$tarif= $_POST["tarif"];
		}

		$disque=new Disque();
		$disque->setId($id);
		$disque->setNom($name);
		$disque->setUtilisateur($user);
		$disque->setTarifs($tarif);
		$disque->setCreatedAt($createdate);
		$this->loadView("formulaire/creation_disque.html", array("id"=> $id));
		#parent::frm($id); // TODO: Change the autogenerated stub
	}
}
?>