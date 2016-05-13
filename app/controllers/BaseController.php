<?php
use micro\controllers\Controller;
use micro\utils\RequestUtils;
use micro\js\Jquery;
/**
 * Classe abstraite des contrôleurs Cloud
 * @author jcheron
 * @version 1.2
 * @package cloud.controllers
 */
abstract class BaseController extends Controller {
	public function initialize() {
		$crumbs = explode("/",$_SERVER["QUERY_STRING"]);
		foreach($crumbs as $crumb) {
			$g= ucwords(str_replace(array("c", "="), array("", ""), $crumb) . ' ');
			$i[]="$g";
		}

		if (!RequestUtils::isAjax()) {
			$this->loadView("main/vHeader.html", array ("infoUser" => Auth::getInfoUser() ));
		} else {
			$breadcrumb="<a href='" . $GLOBALS['config']['siteUrl'] . "'>
			<span class='glyphicon glyphicon-home' aria-hidden='true'></span>&nbsp;Accueil</a>
			</li><li>$i[0]</li>";
			Jquery::setHtml('.breadcrumb', $breadcrumb);
			echo Jquery::compile();
		}
	}

	public function finalize(){
		if(!RequestUtils::isAjax()){
			$this->loadView("main/vFooter.html");
		}
	}
}