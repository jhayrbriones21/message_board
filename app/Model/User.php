<?php
App::uses('AuthComponent', 'Controller/Component');
 
class User extends AppModel {
     
    // public $avatarUploadDir = 'img/avatars';
    // public $hasOne = 'Profile';

    // public $hasOne = array(
    //     'Reply'=>array(
    //         'className'=>'Reply',
    //         'foreignKey'=>'user_id'
    //     )
    // );

    // public $belongsTo = array(
    //     'Profile' => array(
    //         'className' => 'Profile',
    //         'foreignKey' => 'user_id'
    //     )
    // );
     
    public $validate = array(
        'name' => array(
            'nonEmpty' => array(
                'rule' => array('notBlank'),
                'message' => 'Name is required',
                'allowEmpty' => false
            ),
            'min_length' => array(
                'rule' => array('minLength', '5'),  
                'message' => 'Name must have a mimimum of 6 characters'
            ),
            'max_length' => array(
                'rule' => array('maxLength', '20'),  
                'message' => 'Name must have a maximum of 20 characters'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A password is required'
            )
        ),
         
        'password_confirm' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Please confirm your password'
            ),
             'equaltofield' => array(
                'rule' => array('equaltofield','password'),
                'message' => 'Confim passwords not match.'
            )
        ),
         
        'email' => array(
            'required' => array(
                'rule' => array('email', true),    
                'message' => 'Please provide a valid email address.'   
            ),
             'unique' => array(
                'rule'    => array('isUniqueEmail'),
                'message' => 'This email is already in use',
            ),
            'between' => array( 
                'rule' => array('between', 6, 60), 
                'message' => 'Usernames must be between 6 to 60 characters'
            )
        ),
         
         
        'password_update' => array(
            'min_length' => array(
                'rule' => array('minLength', '6'),   
                'message' => 'Password must have a mimimum of 6 characters',
                'allowEmpty' => true,
                'required' => false
            )
        ),
        'password_confirm_update' => array(
             'equaltofield' => array(
                'rule' => array('equaltofield','password_update'),
                'message' => 'Both passwords must match.',
                'required' => false,
            )
        )
 
         
    );
     
        /**
     * Before isUniqueUsername
     * @param array $options
     * @return boolean
     */
 
    /**
     * Before isUniqueEmail
     * @param array $options
     * @return boolean
     */
    function isUniqueEmail($check) {
 
        $email = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.email'
                ),
                'conditions' => array(
                    'User.email' => $check['email']
                )
            )
        );
 
        if(!empty($email)){
            return false;
        }else{
            return true; 
        }
    }
     
    public function equaltofield($check,$otherfield) 
    { 
        //get name of field 
        $fname = ''; 
        foreach ($check as $key => $value){ 
            $fname = $key; 
            break; 
        } 
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname]; 
    } 
 
    /**
     * Before Save
     * @param array $options
     * @return boolean
     */
     public function beforeSave($options = array()) {
        // hash our password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
         
        // if we get a new password, hash it
        if (isset($this->data[$this->alias]['password_update']) && !empty($this->data[$this->alias]['password_update'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password_update']);
        }
     
        // fallback to our parent
        return parent::beforeSave($options);
    }
 
}