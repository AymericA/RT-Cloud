<?php
echo"coucou";
use micro\orm\DAO;
use micro\js\Jquery;
use micro\controllers\Controller;
use micro\utils\RequestUtils;

/**
 * Created by PhpStorm.
 * User: AA
 * Date: 30/03/2016
 * Time: 13:46
 */

class Exemples extends \BaseController
{

    public function index()
    {
        echo "<h1> Services </h1>";
        $services = \micro\orm\DAO::getAll("Service");

        #Pour chaque services dans $service faire.....
        foreach ($services as $service) {
            echo "<b>" . $service->getNom() . "</b> ";
            echo $service->getPrix() . "<br>";
        }
    }

    public function hello($qui = "world", $etAutre = "")
    {
        echo "Hello " . $qui . $etAutre;
    }

    public function utilisateur()
    {

        $users = \micro\orm\DAO::getAll("Utilisateur");
        $this->loadView("exemple/users", array("users" => $users));

    }

    public function disque()
    {
        $disques = \micro\orm\DAO::getAll("Disque");
        $this->loadView("exemple/disques.html", array("disques" => $disques));
    }

    public function sorte_d_utilisateur($field = "login", $order = "ASC")
    {
        #Dernière partie du getAll() correspond à la fin d'un requête SQL
        $users = \micro\orm\DAO::getAll("Utilisateur", "0=0 ORDER BY {$field} {$order}");
        $this->loadView("exemple/sortedUser.html", array("users" => $users, "field" => $field, "order" => $order));
    }

    public function utilisateurDisques()
    {
        $users = \micro\orm\DAO::getAll("Utilisateur");
        foreach ($users as $user) {
            \micro\orm\DAO::getOneToMany($user, "disques");
            if (sizeof($user->getDisques()) > 0)
                $this->loadView("exemple/userDisques.html", array("user" => $user));
        }
    }

    public function displayService($id = null)
    {
        #Pour savoir si ID est affecté ou pas (se lit "is set"
        if (isset($id)) {
            #Si ID appelle le service correspondant
            $service = \micro\orm\DAO::getOne("Service", $id);
        } else {
            #Sinon en crée un nouveau
            $service = new Service();
            $service->setNom("Nouveau service");
        }
        $this->loadView("exemple/displayService.html", array("service" => $service));

    }

    public function serviceAdd($nom,$prix=0){
        $service = new Service();
        $service->setNom($nom);
        $service->setDescription("Coucou je suis le petit nouveau du groupe ! Wait and see for my description");
        $service->setPrix($prix);
        \micro\orm\DAO::insert($service);
        $this->displayService($service->getId());
    }
}
