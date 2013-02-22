<?php

class SITES extends BaseActiveRecord {
    
    public function getDomains($assoc = false){
        $domains = DOMAINS::model()->findAllByAttributes(array('site_id'=>$this->id));
        if($assoc){
            $allDomains = array();
            foreach($domains as $domain){
                $allDomains[$domain->id] = $domain->domain_name;
            }
            return $allDomains;
        }else{
            return $domains;
        }
    }
    
    public function getPageByIndex($pageId){
        $page = PAGES::model()->findByAttributes(array('id'=>intval($pageId), 'site_id'=>$this->id));
        return $page;
    }
    
    public function getPageByCode($code = 'index', $parent = 0){
        $page = PAGES::model()->findByAttributes(array('site_id'=>$this->id,'code'=>$code,'parent'=>intval($parent)));
        return $page;
    }
    
}