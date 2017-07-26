<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property User $User
 */
class Post extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
//    public $hasMany = array(
//        'Like' => array(
//            'className' => 'Like',
//            'foreignKey' => 'user_id'
//
//        ),
//        'Comment' => array(
//            'className' => 'Comment',
//            'foreignKey' => 'user_id'
//
//        )
//    );

    public $validate = array(

        'status' => array(
            'rule' => 'notBlank'
        )
    );
}
