<?php

class PAGES extends BaseActiveRecord {
    
    private $_alphabet = 'абвгдеёжзийклмнопрстуфхцчшщьыъэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФЧЦЧШЩЬЫЪЭЮЯ';
    
    public function rules()
    {
        return array(
            array('site_id, parent, name, content, code, active', 'required'),
            array('name', 'match', 'pattern' => '/^['.$this->_alphabet.'\w\s\.\-]*$/i'),
            array('code', 'match', 'pattern' => '/^[\w\d]*$/i'),
            array('site_id', 'match', 'pattern' => '/^(\d+)$/i'),
            array('parent', 'match', 'pattern' => '/^(\d?)$/i'),
            array('active', 'match', 'pattern' => '/^(\d+)$/i'),
        );
    }
    
   
  public function attributeLabels() {
    return array(
        'site_id'=>'Сайт',
        'parent'=>'Родительский элемент',
        'active' => 'Активность',
        'content'=>'Текст страницы',
        'name'=>'Заголовок страницы',
        'code'=>'URL-код',
      );
  }
    
}