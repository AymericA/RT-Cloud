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
		$users = micro\orm\DAO::getAll('Utilisateur');
		foreach ($users as $user) {
			micro\orm\DAO::getOneToMany($user, 'disques');
			$user->nbDisques = count($user->getDisques());
			foreach ($user->getDisques() as $disque) {
				micro\orm\DAO::getOneToMany($disque, 'disqueTarifs');
				if ($disque->getTarif() != NULL) {
					$user->prixTotal = $disque->getTarif()->getPrix();
				}
			}
		}
		$this->loadView('admin/user.html', array("users" => $users));
	}

	public function disques($idUtilisateur = false)
	{
		if (!$this->isAdmin()){
			return false;
		}

		$users = ($idUtilisateur) ? [micro\orm\DAO::getOne('utilisateur', 'id = '. $idUtilisateur)] : micro\orm\DAO::getAll('utilisateur');
		$i = 0;
		foreach($users as $user) {
			if($user->getAdmin() == 0)
				$user->status = 'Utilisateur';
			elseif ($user->getAdmin() == 1)
				$user->status = 'Administrateur';
			$user->disks = micro\orm\DAO::getAll('disque', 'idUtilisateur = '. $user->getId());
			if(empty($user->disks))
				unset($users[$i]);
			foreach($user->disks as $disk)
				$disk->tarif = ModelUtils::getDisqueTarif($disk);
			$i++;
		}
		$this->loadView('Admin/disque.html', array('users' => $users));
	}
}