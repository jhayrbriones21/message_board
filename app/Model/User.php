<?php
// App::uses('AppModel', 'Model');

class User extends AppModel {
	public $name = 'User';
	public $displayField = 'name';

	public $validate = array(
	  'email' => array(
	    'required' => array(
	      'rule' => 'notEmpty',
	      'message' => 'Please enter a email'
	    )
	  ),
	  'password' => array(
	    'required' => array(
	      'rule' => 'notEmpty',
	      'message' => 'Please enter a password'
	    )
	  )
	);

	public $components = array(
        'Flash',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'messages',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish',
                    'fields' => array('email' => 'email')
                )
            ),
        )
    );

	// public function beforeSave($options = array())
	// {
	// 	if(isset($this->data['User']['password']))
	// 	{
	// 		$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
	// 	}



	// 	return true;
	// }

	public function beforeSave($options = array()) {
        if (!empty($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}
