<?php

class BaseActiveRecord extends CActiveRecord {
    
    public static function model($className=null) {
        return parent::model(get_called_class());
    }

    public function tableName() {
        return get_class($this);
    }
}