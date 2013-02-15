<?php

class USERS extends BaseActiveRecord {
    
    public function rules()
    {
      return array(
        array('password', 'authenticate', 'on' => 'login'),
      );
    }
    
    /**
    * Сценарий аутентификации
    * 
    * @param string $attribute не используется
    * @param stdclass параметры формы
    * @link http://www.yiiframework.com/doc/api/1.1/IUserIdentity#authenticate-detail
    */
    public function authenticate($attribute, $params)
    {
      if(!$this->hasErrors())
      {
        $identity= new UserIdentity($this->username, $this->password);
        $identity->authenticate();

        switch($identity->errorCode) {
          case UserIdentity::ERROR_NONE: {
            user()->login($identity, 3600*24*14); //Remeber for 2 weeks
            break;
          }
          case UserIdentity::ERROR_USERNAME_INVALID: {
            $this->addError('login', 'User doesn\'t exists!');
            break;
          }
          case UserIdentity::ERROR_PASSWORD_INVALID: {
            $this->addError('passwd', 'Неверный логин или пароль!');
            break;
          }
        }
      }
    }
    
    public function relations() {
        return array(
          'role'=>array(self::BELONGS_TO, 'ROLES', 'role_id'),
        );
    }
    
}