<?php

/**
 * Created by PhpStorm.
 * User: YNS
 * Date: 27/07/2017
 * Time: 3:04 PM
 */
class FollowsController extends AppController
{
    public $uses = array('Post', 'Comment', 'User','Follow', 'Like');
    public $helpers = array('Html', 'Form');
    // function to follow a user
    public function addFollow()
    {
        $this->autoRender = false;
        $postID = $this->request->params['id'];
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->request->data['follow_id'] = $postID;
            $this->Follow->create();
            if ($this->Follow->save($this->request->data)) {
                 return $this->redirect(array('controller' => 'posts','action' => 'index'));
            }
        }
    }
}