<?php

class BaseAdminController extends CController {
  public $user;
  public $canAccess = false;
  public $salt = null;
    
  public function init() {
    $this->salt = Yii::app()->params['salt'];
    $this->layout = 'admin';

    if(!Yii::app()->getUser()->isGuest) {
      $this->user = USERS::model()->findByPk(user()->id);
      $action = preg_replace("/.*?".$this->id."\//", '', $_SERVER['REQUEST_URI']);
      if($action == $_SERVER['REQUEST_URI'])
        $action = 'index';
      $action = strtolower($action);
      // Если совсем не имеет доступа к администраторскому разделу
      if($this->__checkAccess($action) == -1){
          app()->user->logout();
          $this->redirect(app()->createUrl('admin/login'));
      // Если не имеет доступа к данному экшену
      }else if(!$this->__checkAccess($action)){
          $this->canAccess = false;
          $this->render('//admin/accessError');
          app()->end();
      }
    } else if (!preg_match('|/admin/login|',Yii::app()->request->url)) {
      $this->redirect(app()->createUrl('admin/login'));
    }

    return parent::init();
  }
  
  private function __checkAccess($action){
      $canAccess = -1;
      $access = CJSON::decode($this->user->role->access);
      if(isset($access['allow'][app()->controller->id])){
          if($access['allow'][app()->controller->id] == '*' || isset($access['allow'][app()->controller->id][$action]))
            $canAccess = 1;
      }
      if(isset($access['deny'][app()->controller->id])){
          if($access['deny'][app()->controller->id] == '*' || isset($access['deny'][app()->controller->id][$action]))
            $canAccess = 0;
      }
      return $canAccess;
  }
 
}