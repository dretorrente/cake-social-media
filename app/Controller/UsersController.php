<?php

/**
 * Created by PhpStorm.
 * User: YNS
 * Date: 26/07/2017
 * Time: 1:40 PM
 */
class UsersController extends AppController
{
//    public $paginate = array(
//        'limit' => 25,
//        'conditions' => array('status' => '1'),
//        'order' => array('User.username' => 'asc' )
//    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login','add');
    }
    public function profile() {
        $this->layout = 'layoutUI';
        $username = $this->request->params['username'];
//        $query = $this->User->find('all');
        $id = $this->Auth->user('id');
        $query = $this->User->find('all', array(
            'conditions'=>array('User.username' => $username)));
        $this->set('users', $query);
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
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('username')));
                $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(__('Invalid username or password'));
            }
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function index() {
        $this->layout = 'layoutUI';
        $this->paginate = array(
            'limit' => 6,
            'order' => array('User.username' => 'asc' )
        );
        $users = $this->paginate('User');
        $this->set(compact('users'));
    }


    public function add() {
        $this->layout = 'layoutUI';
        if ($this->request->is('post')) {
            if (!empty($this->request->data['User']['upload']['name']))
            {
                $file = $this->request->data['User']['upload'];
//                pr($file);
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
//                echo $ext;

                $arr_ext = array('jpg', 'jpeg', 'gif', 'png');

                foreach($arr_ext as $arr)
                {
                    if($arr == $ext)
                    {
                        $filetmp= 'img/' . $file['name'];
//                        echo $filenew;
//                        move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/' . $file['name']);
//                        $this->request->data['upload'] = $filenew;
                          $upload = $this->request->data['User']['upload'];
                        $this->request->data['User']['upload']['name'] = $filetmp;
                        $filenew =  $this->request->data['User']['upload']['name'];
                        $this->request->data['User']['upload'] = $filenew;
//                        pr($this->data['User']['upload']);
                    }
                }
            }
//
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been created'));
                $this->redirect(array('controller' => 'users', 'action' => 'login'));
            } else {
                $this->Session->setFlash(__('The user could not be created. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {

        if (!$id) {
            $this->Session->setFlash('Please provide a user id');
            $this->redirect(array('action'=>'index'));
        }

        $user = $this->User->findById($id);
        if (!$user) {
            $this->Session->setFlash('Invalid User ID Provided');
            $this->redirect(array('action'=>'index'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been updated'));
                $this->redirect(array('action' => 'edit', $id));
            }else{
                $this->Session->setFlash(__('Unable to update your user.'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $user;
        }
    }

    public function delete($id = null) {

        if (!$id) {
            $this->Session->setFlash('Please provide a user id');
            $this->redirect(array('action'=>'index'));
        }

        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided');
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField('status', 0)) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function activate($id = null) {

        if (!$id) {
            $this->Session->setFlash('Please provide a user id');
            $this->redirect(array('action'=>'index'));
        }

        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided');
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField('status', 1)) {
            $this->Session->setFlash(__('User re-activated'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not re-activated'));
        $this->redirect(array('action' => 'index'));
    }
}