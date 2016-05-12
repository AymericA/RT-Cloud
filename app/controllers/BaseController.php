<?php
use micro\controllers\Controller;
use micro\utils\RequestUtils;
/**
 * Classe abstraite des contrôleurs Cloud
 * @author jcheron
 * @version 1.2
 * @package cloud.controllers
 */
abstract class BaseController extends Controller {
	public function initialize(){
		/**
		 * fais quelque chose mais ne l'affiche pas
		 */
		$crumbs = explode("/",$_SERVER["QUERY_STRING"]);
		foreach($crumbs as $crumb) {
			$g= ucwords(str_replace(array("c", "="), array("", ""), $crumb) . ' ');
			$i[]="$g";
		}
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vHeader.html",array("infoUser"=>Auth::getInfoUser(),"i"=>$i));
		}
	}

	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}