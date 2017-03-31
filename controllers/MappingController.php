<?php

class MappingController extends CommunecterController {

  protected function beforeAction($action)
  {
	parent::initPage();
	return parent::beforeAction($action);
  }

	public function actions()
	{
		return array(
		'save'   				=> 'citizenToolKit.controllers.mapping.SaveAction',
		'update'   				=> 'citizenToolKit.controllers.mapping.UpdateAction',
		'delete'   				=> 'citizenToolKit.controllers.mapping.DeleteAction'
		);
	}	
}