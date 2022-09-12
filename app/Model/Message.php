<?php
 
class Message extends AppModel {

 	public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );

    public $hasMany = array(
	    'Reply'=>array(
	        'className'=>'Reply',
	        'foreignKey'=>'message_id'
	        )
	);

    public $validate = array(
        'description' => array(
            'nonEmpty' => array(
                'rule' => array('notBlank'),
                'message' => 'Description is required',
                'allowEmpty' => false
            ),
        )
    );

}