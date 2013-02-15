<?php

class DOMAINS extends BaseActiveRecord {
    
    public function relations() {
        return array(
          'site'=>array(self::BELONGS_TO, 'SITES', 'site_id'),
        );
    }
}