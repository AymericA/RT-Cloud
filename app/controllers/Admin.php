<?php
use micro\orm\DAO;
class Admin extends \BaseController {

	public function index() {

	}


	public function users() {
		$users = \micro\orm\DAO::getAll("Utilisateur");
		foreach ($users as $user){
			$login = $user->getLogin();
			$disque = $user->getDisques();
			$nbdisque = count($disque);

			$this->loadView("exemple/sortedUser.html", array("users" => $users, "login"=>$login, "nbdisque"=>$nbdisque));
		}

	}
}