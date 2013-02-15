<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
    
        private $_id;

	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
            $USER = USERS::model()->findByAttributes(array('username' => $this->username));
            if(!$USER){
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                //if(md5($this->password.Yii::app()->params['salt']) !== $USER->password)
                if($this->password !== $USER->password)
                   $this->errorCode = self::ERROR_PASSWORD_INVALID;
                else {
                  $this->_id = $USER->id;
                  $this->setState('username', $USER->username);
                  $this->setState('id', $USER->id);
                  $this->errorCode=self::ERROR_NONE;
                }
            }
            return !$this->errorCode;
	}

        public function getId() {
          return $this->_id;
        }
}