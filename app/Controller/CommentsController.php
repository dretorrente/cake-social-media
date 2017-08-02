<?php

/**
 * Created by PhpStorm.
 * User: YNS
 * Date: 27/07/2017
 * Time: 8:28 AM
 */
class CommentsController extends AppController
{
    public $uses = array('Post', 'Comment', 'User', 'Follow', 'Like');
    public $helpers = array('Html', 'Form');
    public function addComment()
    {
        $this->autoRender = false;
        $postID = $this->request->params['id'];
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->request->data['post_id'] = $postID;
            $this->Comment->create();
            if ($this->Comment->save($this->request->data)) {
                $this->redirect($this->referer());
            }
            $this->Session->setFlash(__('Unable to add your post.'));

        }
    }
}