<?php

class SiteController extends BaseController
{
    
    public function init() {

        if($this->startSite()){
            $request_uri = explode('/',$_SERVER['REQUEST_URI']);
            array_shift($request_uri);
            if(!$request_uri || !$request_uri[0])
                $request_uri[0] = 'index';

            $parent = 0;
            foreach($request_uri as $uri){
                if(!$page = PAGES::model()->findByAttributes(array('site_id'=>$this->site->id,'code'=>$uri,'parent'=>$parent))){
                    $error = array('data'=>'File not found','message'=>'File not found');
                    $this->actionError($error);
                }else{
                    $parent = $page->id;
                }
            }
            $content = $this->__replaceCode($page->content);
            $this->renderText($content);
            app()->end();
        }
    }
    
    public function actionError($error = false) {
        if(!$error)
            $error=Yii::app()->errorHandler->error;

        $this->renderPartial('//error', array(
            'data' => $error
        ));
        app()->end();
    }
    
    private function __replaceCode($content){
        // Ищем совпадения по модулю phpcode
        preg_match_all('/\[\?phpcode\(["\'](\w+)["\'](, ([\w&\[\]=,\.]+)?)?\)\?\]/si',$content,$matches);
        foreach($matches[1] as $render){
            if(isset($matches[3])){
                parse_str($matches[3][0],$output);
            }
            $renderPHP = $this->renderPartial('//sites/'.$this->site->folder.'/modules/phpcode/'.$render, $output, true);
            $content = str_replace($matches[0][0], $renderPHP, $content);
        }
        
        return $content;
    }
        
}

?>