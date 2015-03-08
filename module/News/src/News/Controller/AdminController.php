<?php
namespace News\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
class AdminController extends AbstractActionController {
	function indexAction() {
		$auth=new AuthenticationService();
		echo print_r($auth->getIdentity());
		$this->layout('layout/layout_admin');
		$view=new ViewModel();
		
	}
}