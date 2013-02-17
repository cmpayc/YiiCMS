<?php

class BaseAdminController extends CController {
  public $user;
  public $canAccess = false;
  public $salt = null;
    
  public function init() {
    $this->salt = Yii::app()->params['salt'];
    $this->layout = 'admin';
    
    $request = preg_replace("/.*admin\//", '', strtolower($_SERVER['REQUEST_URI']));
    $request = str_replace('/',DS,$request);
    if(is_file(app()->basePath.DS.'views'.DS.'admin'.DS.$request)){
        $this->returnFile(app()->basePath.DS.'views'.DS.'admin'.DS.$request);
    }

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
  
  public function returnFile($filename){
      $file_extension = strtolower(substr(strrchr($filename,"."),1));
      $download = true;
      switch ($file_extension) {
          case "css": $ctype="text/css";$download = false;break;
          case "js": $ctype="text/javascript";$download = false;break;
          case "pdf": $ctype="application/pdf"; break;
          case "exe": $ctype="application/octet-stream"; break;
          case "zip": $ctype="application/zip"; break;
          case "doc": $ctype="application/msword"; break;
          case "xls": $ctype="application/vnd.ms-excel"; break;
          case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
          case "gif": $ctype="image/gif"; break;
          case "png": $ctype="image/png"; break;
          case "jpe": case "jpeg":
          case "jpg": $ctype="image/jpg"; break;
          default: $ctype="application/force-download";
      }
      if (!is_file($filename)) {
          die("File not found.");
      }  

      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Cache-Control: private",false);
      header("Content-Type: $ctype");
      if($download){
          header("Content-Disposition: attachment; filename=\"".basename($filename)."\";");
          header("Content-Transfer-Encoding: binary");
      }
      header("Content-Length: ".@filesize($filename));
      set_time_limit(0);
      @readfile("$filename") or die("File not found.");
      app()->end();
  }
 
}