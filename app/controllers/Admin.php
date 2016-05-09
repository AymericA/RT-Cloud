<?php
use micro\orm\DAO;
class Admin extends \BaseController {

	public function index() {
		$this->loadView("Admin/index.html");


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