<?php
class Disques extends \_DefaultController
{
	public function __construct()
	{
		parent::__construct();
		$this->title = "Disques";
		$this->model = "Disque";
	}


	public function frm($id=NULL)
	{
		$disque = $this->getInstance($id);
		$tarifs = micro\orm\DAO::getAll("tarif");
		$disabled = "";
		$crumbs = explode("/",$_SERVER["QUERY_STRING"]);
		foreach($crumbs as $crumb) {
			$g = ucwords(str_replace(array("c", "="), array("", ""), $crumb) . ' ');
			$i[] = "$g";
		}
		$this->loadView("formulaire/creation_disque.html", array("disque" => $disque, "disabled" => $disabled,
			"tarifs"=>$tarifs, "i"=>$i));
	}
	public function update(){
		// Si un ID et un nom sont passés en paramètres, il s'agit de mettre à jour un disque
		if($_POST["id"] && $_POST['nom']) {
			// On recupère le chemin du dossier du disque grâce à l'ancien nom du disque et aux variables globales
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
			// Sinon, il s'agit de créer un disque
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
	/* (non-PHPdoc)
	 * @see _DefaultController::setValuesToObject()
	 */
	protected function setValuesToObject(&$object) {
		parent::setValuesToObject($object);
		$object->setUtilisateur(Auth::getUser());
		$object->setDisqueTarifs($object->getTarif());
	}
}
?>