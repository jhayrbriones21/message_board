<?php
 
class Reply extends AppModel {

 	public $belongsTo = array(
        'Message' => array(
            'className' => 'Message',
            'foreignKey' => 'message_id'
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
    
}