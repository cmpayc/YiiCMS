<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseController extends CController
{
    /**
     * @var string the default layout for the controller view.
     */
    public $layout = false;

    public $site = false;
    public $templateFolder = false;
    public $sitePath = false;

    public function showPanel(){
        if(!Yii::app()->getUser()->isGuest) {
            $this->renderPartial('//admin/sitePanel', array());
        }
    }
        
    public function returnFile($filename){
      $file_extension = strtolower(substr(strrchr($filename,"."),1));
      if($file_extension == 'php') app()->end();
      $download = true;
      switch ($file_extension) {
          case "css": $ctype="text/css";$download = false;break;
          case "js": $ctype="text/javascript";$download = false;break;
          case "htm": case "html": $ctype="text/html"; $download = false;break;
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
   
   public function startSite(){
       // Load site info
        $DOMAIN = false;
        if(!$DOMAIN = DOMAINS::model()->findByAttributes(array('domain_name'=> $_SERVER['SERVER_NAME']))){
            $host = explode('.', $_SERVER['SERVER_NAME']);
            if(count($host) == 3){
                if($host[0] == 'www'){
                    $DOMAIN = DOMAINS::model()->findByAttributes(array('domain_name'=> $host[1].'.'.$host[2]));
                }
                if(!$DOMAIN)
                    $DOMAIN = DOMAINS::model()->findByAttributes(array('domain_name'=> '.'.$host[1].'.'.$host[2]));
            }else if(count($host) == 2){
                $DOMAIN = DOMAINS::model()->findByAttributes(array('domain_name'=> 'www.'.$host[0].'.'.$host[1]));
                if(!$DOMAIN)
                    $DOMAIN = DOMAINS::model()->findByAttributes(array('domain_name'=> '.'.$host[1].'.'.$host[2]));
            }
        }
        if(!$DOMAIN || !$DOMAIN->site){
            echo 'Domain not founded';
            app()->end();
        }
        // Пробуем загрузить указанный файл
        if(app()->baseUrl){
            $request = preg_replace('/.*'.str_replace('/','\/',app()->baseUrl).'/', '', strtolower($_SERVER['REQUEST_URI']));
        }else{
            $request = strtolower($_SERVER['REQUEST_URI']);
        }
        $request = str_replace('/',DS,$request);
        if($request != DS.'index.php' && is_file(app()->basePath.DS.'views'.DS.'sites'.DS.$DOMAIN->site->folder.$request)){
            $this->returnFile(app()->basePath.DS.'views'.DS.'sites'.DS.$DOMAIN->site->folder.$request);
        }

        $this->site = $DOMAIN->site;
        $this->sitePath = app()->basePath.DS.'views'.DS.'sites'.DS.$this->site->folder.DS;
        $this->templateFolder = '//sites/'.$this->site->folder;
        $this->layout = '//sites/'.$this->site->folder.'/template';
        
        return true;
   }
}