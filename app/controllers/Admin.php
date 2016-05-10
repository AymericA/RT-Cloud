<?php
use micro\orm\DAO;
class Admin extends \BaseController {

	private function isAdmin() {
		if(Auth::isAuth()) {
			if(Auth::isAdmin()) {
				return true;
			}
		}
		$msg = new DisplayedMessage();
		$msg->setContent('Accès à une ressource non autorisée')
			->setType('danger')
			->setDismissable(false)
			->show($this);
		return false;
	}
	public function index() {
		if ($this->isAdmin() != true){
			return false;
		}

		$count = (object)[];
		$count->all = (object)[];
		$count->today = (object)[];
		$count->all->user = micro\orm\DAO::count('utilisateur');
		$count->all->disk = micro\orm\DAO::count('disque');
		$count->all->tarif = micro\orm\DAO::count('tarif');
		$count->all->service = micro\orm\DAO::count('service');
		$count->today->user = micro\orm\DAO::count('utilisateur', 'DAY(createdAt) = DAY(NOW())');
		$count->today->disk = micro\orm\DAO::count('disque', 'DAY(createdAt) = DAY(NOW())');
		$this->loadView('Admin/index.html', array("count"=>$count));
	}


	public function users() {
		$users = \micro\orm\DAO::getAll("Utilisateur");
		$this->loadView("Admin/en_tete_user.html");

		foreach ($users as $user){
			$login = $user->getLogin();
			$this->loadView("Admin/user.html", array("users" => $users, "login"=>$login));
		}



	}
}