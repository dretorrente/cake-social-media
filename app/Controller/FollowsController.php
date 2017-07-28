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
    public function addFollow()
    {
        $this->autoRender = false;
        $postID = $this->request->params['id'];
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->request->data['follow_id'] = $postID;
//            echo pr( $this->request->data);
//            die();
            $this->Follow->create();
            if ($this->Follow->save($this->request->data)) {
//                $this->Flash->success(__('Your post has been saved.'));
                return $this->redirect(array('controller' => 'posts','action' => 'index'));
            }
        }
    }
}