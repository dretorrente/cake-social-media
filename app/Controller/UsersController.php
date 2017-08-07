<?php

class UsersController extends AppController
{

    public $uses = array('Post', 'Comment', 'User','Follow','Like');
    public $helpers = array('Html', 'Form');

    // override the beforeFilter allowing to add and login user
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','register');
    }

     /**
     * this function allows to login existing user
     */
    public function login() {
    $this->layout = 'layoutUI';
    //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(array('action' => 'index'));
        }
        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(__('Invalid username or password'));
            }
        }
    }
     /**
     * this function allows to logout existing user
     */
    public function logout() {
        $this->redirect($this->Auth->logout());
    }
    /**
     * this function allows to register a new user
     */
    public function register() {
        $this->layout = 'layoutUI';
        if ($this->request->is('post')) {
            //uploading image in the root document source image
            if (!empty($this->request->data))
            {
                $file = $this->request->data['User']['upload'];
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                 if(in_array($ext, $arr_ext))
                {
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img' . DS . 'profile' . DS .$file['name']);
                    $filenew = '/img/profile/' . $file['name'];
                    $this->request->data['User']['upload'] = $filenew;
                }

            }
            
            // create new user
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been created'));
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            } else {
                $this->Session->setFlash(__('The user could not be created. Please, try again.'));
            }
        }
        
    }
    /**
     * this function allows to view profile of each user
     */
    public function profile() {
        $this->layout = 'layoutUI';
        $username = $this->request->params['username'];
        $query = $this->User->find('first', array(
                'conditions'=> array(
                    'User.username' => $username,
                ),
                'recursive' => 3)
        );
        $this->set('user', $query);
    }

}