<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {
    public $actsAs = array('Containable');

/**
 * Validation rules
 *
 * @var array
 */

    public $hasMany = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'user_id'

        ),
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'user_id',
            'dependent' => true

        ),
        'Follow' => array(
            'className' => 'Follow',
            'foreignKey' => 'user_id'

        ),
        'Like' => array(
            'className' => 'Like',
            'foreignKey' => 'user_id'

        )
    );

	public $validate = array(
		'username' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'A username is required'

            ),
			'alphaNumeric' => array(
				'rule' => array('alphaNumeric'),
			),
            'between' => array(
                'rule' => array('between', 5, 15),
                'required' => true,
                'message' => 'Usernames must be between 5 to 15 characters'
            ),

            'unique' => array(
                'rule'    => array('isUniqueUsername'),
                'message' => 'This username is already in use'
            ),
		),
		'password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'A password is required'
            ),
            'min_length' => array(
                'rule' => array('minLength', '6'),
                'message' => 'Password must have a mimimum of 6 characters'
            )
		),
        'upload' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Please provide a your profile picture.'
            ),

        ),
		'email' => array(
			'required' => array(
				'rule' => array('email',true),
                'message' => 'Please provide a valid email address.'
			),
            'unique' => array(
                'rule'    => array('isUniqueEmail'),
                'message' => 'This email is already in use',
            ),

		),
        'password_confirm' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Please confirm your password'
            ),
            'equaltofield' => array(
                'rule' => array('equaltofield','password'),
                'message' => 'Both passwords must match.'
            )
        ),
	);
    // for checking confirm password to password input
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
    // for checking a username if exist in database
    function isUniqueUsername($check) {

        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id',
                    'User.username'
                ),
                'conditions' => array(
                    'User.username' => $check['username']
                )
            )
        );

        if(!empty($username)){

                return false;

        }else{
            return true;
        }
    }

    /**
     * Before isUniqueEmail
     * @param array $options
     * @return boolean
     */
    // for checking a email if exist in database
    function isUniqueEmail($check) {

        $email = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.id'
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

    // hashing password before saving it
    public function beforeSave($options = array()) {
        // hash our password
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        // if we get a new password, hash it
        // fallback to our parent
        return parent::beforeSave($options);
    }
}
