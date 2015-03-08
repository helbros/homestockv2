<?php

namespace News\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Select;


class IndexController extends AbstractActionController {
	protected $userTable;
		
	function indexAction(){
		$this->getServiceLocator()->get('ViewHelperManager')->get('HeadTitle')->set('Chứng khoán HomeStock - Đầu Tư Tương Lai');					
		$select=new Select('article');
		$select->order('created DESC');
		$adapterPaginator=new DbSelect($select, $this->getDbAdapter());
		$paginator=new Paginator($adapterPaginator);
		$paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
		$paginator->setItemCountPerPage(8);

		$view_chatbox=new ViewModel();
		$view_chatbox->setTemplate('view_chat');
		
		$view_stock=new ViewModel();
		$result=$this->forward()->dispatch('News\Controller\Stock',array('action'=>'index'));		
		//echo print_r($result);		
		
		$view_stock->setTemplate('news/stock/index');		
		$view_stock->setVariable('stock_most_increase',$result->stock_most_increase);
		$view_stock->setVariable('stock_most_down',$result->stock_most_down);
		$view_stock->setVariable('stock_most_match',$result->stock_most_match);
		
		$view=new ViewModel();
		$view->addChild($view_chatbox,'chatbox');
		$view->addChild($view_stock,'view_stock');
		$view->setVariable('paginator', $paginator);				
		return $view;
		
	}
	function errorAction(){
	
	}
	function getDbAdapter() {
		return $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Adapter' );
	}
}
