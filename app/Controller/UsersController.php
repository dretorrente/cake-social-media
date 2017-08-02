<?php

/**
 * Created by PhpStorm.
 * User: YNS
 * Date: 26/07/2017
 * Time: 1:40 PM
 */
class UsersController extends AppController
{

    public $uses = array('Post', 'Comment', 'User','Follow','Like');
    public $helpers = array('Html', 'Form');

    public function beforeFilter() {
        parent::beforeFilter();
        // override the beforeFilter allowing to add and login user
        $this->Auth->allow('login','register');
    }

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

    public function logout() {
        $this->redirect($this->Auth->logout());
    }


    public function register() {
        $this->layout = 'layoutUI';
        if ($this->request->is('post')) {
            if (!empty($this->request->data['User']['upload']['name']))
            {
                $file = $this->request->data['User']['upload'];
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                $arr_ext = array('jpg', 'jpeg', 'gif', 'png');

                foreach($arr_ext as $arr)
                {
                    if($arr == $ext)
                    {
                        $filetmp= 'img/' . $file['name'];
                        $this->request->data['User']['upload']['name'] = $filetmp;
                        $filenew =  $this->request->data['User']['upload']['name'];
                        $this->request->data['User']['upload'] = $filenew;
                    }
                }
            }
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been created'));
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            } else {
                $this->Session->setFlash(__('The user could not be created. Please, try again.'));
            }
        }
    }

    public function profile() {
        $this->layout = 'layoutUI';
        $username = $this->request->params['username'];
        $query = $this->User->find('first', array(
                'conditions'=> array(
                    'User.username' => $username,
                ),
                'recursive' => 3)
        );
        $this->set('posts', $query['Post']);
    }

}