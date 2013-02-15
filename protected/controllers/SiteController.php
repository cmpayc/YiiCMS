<?php

class SiteController extends BaseController
{
    
    public function beforeAction($action) {
        $action_id = strtolower($action->id);
        if(!$action_id){
            $action_id = 'index';
        }
        $this->render($this->templateFolder.'/'.$action_id);
        app()->end();
    }
    
    public function actionIndex(){
        die('WWWW');
    }
    
    public function actionError() {
        $error=Yii::app()->errorHandler->error;
    
        $this->renderPartial('//error', array(
            'data' => $error,
        ));
    }
        
}

?>