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
        
        public function init() {
            
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
            
            $this->site = $DOMAIN->site;
            $this->templateFolder = '//sites/'.$this->site->folder;
            $this->layout = '//sites/'.$this->site->folder.'/template';
            
            return parent::init();
        }
        
        public function showPanel(){
            if(!Yii::app()->getUser()->isGuest) {
                $this->renderPartial('//admin/sitePanel', array());
            }
        }
}