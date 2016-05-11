<?php
class Disques extends \_DefaultController {
	public function __construct(){
		parent::__construct();
		$this->title="Disques";
		$this->model="Disque";
	}
	public function frm($id=NULL)
	{
		$disque = $this->getInstance($id);
		$tarifs = micro\orm\DAO::getAll("tarif");


		$disabled = "";
		$this->loadView("formulaire/creation_disque.html", array("disque" => $disque, "disabled" => $disabled, "tarifs"=>$tarifs));
	}

	public function changeTarif() {
		$valid_input = ['disqueId', 'userId', 'tarif'];

		$disque = micro\orm\DAO::getOne('disque', 'id = '. $_GET['disqueId']);
		$disqueTarif = micro\orm\DAO::getOne('disquetarif', 'idDisque = '. $_GET['disqueId']);

		$size=var_dump($disque->getSize());
		ModelUtils::sizeConverter($size);
		$tarif = micro\orm\DAO::getOne('tarif', 'id = '. $_GET['tarif']);
		$i=$disqueTarif->setTarif($tarif);
		$u=micro\orm\DAO::update($i);
		if ($u) {
			header('Location: /RT-Cloud/Scan/show/' . $_GET['disqueId']);
			return false;
		} else {
			echo '<div class="alert alert-danger">Une erreur est survenue, veuillez rééssayer ultérieurement</div>';
		}
	}

	public function update(){

		// Si un ID et un nom sont passés en paramètres, il s'agit de mettre à jour un disque ***
		if($_POST["id"] && $_POST['nom']) {
			// On recupère le chemin ABSOLU du dossier (disque) grace à l'ancien nom du disque disque et au variable globale
			$oldfolder = micro\orm\DAO::getOne('Disque', $_POST['id'])->getNom();
			$basepath = (dirname(dirname(__DIR__))."/files/".$GLOBALS['config']['cloud']['prefix'].Auth::getUser()->getLogin().'/');
			$actualpath = $basepath.$oldfolder;
			$newpath = $basepath.$_POST['nom'];
			// Ensuite une exception classique pour tester si tout s'est bien passé !
			try {
				rename($actualpath, $newpath);
			} catch (Exception $e) {
				die("Erreur pour renommer le dossier");
			}
			// *** Sinon, il s'agit de créer un disque
		} else {
			if ($_POST['nom']) {
				// On recupère le chemin ABSOLU du dossier (disque) comme au dessus
				$basepath = (dirname(dirname(__DIR__))."/files/".$GLOBALS['config']['cloud']['prefix'].Auth::getUser()->getLogin().'/');
				$newpath = $basepath.$_POST['nom'];
				// Ensuite une exception classique pour tester si la création a fonctionné !
				try {
					mkdir($newpath);
				} catch (Exception $e) {
					die("Erreur de créer le dossier");
				}
			}
		}
		// On appelle ensuite la fonction update du DefaultController pour mettre à jour les paramètres en base de données.
		parent::update();
	}
	// Réecriture de la fonction parente
	// On "set" l'objet utilisateur dans l'objet disque afin de pouvoir utiliser la fonction toString de Disque

	/* (non-PHPdoc)
	 * @see _DefaultController::setValuesToObject()
	 */
	protected function setValuesToObject(&$object) {
		parent::setValuesToObject($object);
		$object->setUtilisateur(Auth::getUser());
	}
}


/*
	/*
 		* Action à exécuter après update
 		* par défaut forward vers l'index du contrôleur en cours
 		* @param array $params


	protected function _postUpdateAction($params){
		$this->forward(get_class(),"index",$params); // l'action par défaut
		//$this->forward("MyDisques", "index" );

	}

	/*protected function onAdd($object){
		$cloud=$GLOBALS["config"]["cloud"];
		$pathname=$cloud["root"].$cloud["prefix"].Auth::getUser()->getLogin()."/".$object->getNom();
		DirectoryUtils::mkDir($pathname);
	}
}

 */