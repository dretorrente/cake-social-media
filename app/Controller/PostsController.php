<?php

/**
 * Created by PhpStorm.
 * User: YNS
 * Date: 24/07/2017
 * Time: 2:59 PM
 */
class PostsController extends AppController
{
    public $uses = array('Post', 'Comment', 'User', 'Follow', 'Like');
    public $helpers = array('Html', 'Form');

    //view for the dashboard renamed in routes index.ctp
    public function index() {
        $this->layout = 'layoutUI';

        $query = $this->Post->find('all', array(
            'order' => 'Post.modified DESC',
            'recursive' => 2
        ));
        $this->set('posts', $query);
    }
    //add new post
    public function add() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $msg['success'] = true;
                $msg['type'] = 'add';
                echo json_encode($msg);
            }
            $msg['success'] = false;
        }
    }
    public function showAllPost(){
        $this->autoRender = false;
        $authID = $this->Auth->user('id');
        $query = $this->Post->find('all', array(
            'order' => 'Post.modified DESC',
            'recursive' => 1
        ));
        $comments = $this->Comment->find('all', array(
            'recursive' => 1
        ));
        echo json_encode(array("authID" => $authID, "query" => $query, "comments" => $comments));

    }
    //edit existing post
    public function edit($id = null) {
        $this->layout = 'layoutUI';
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->Post->id = $id;
            if ($this->Post->save($this->request->data)) {
                $this->layout = 'layoutUI';
                $this->Flash->success(__('Your post has been updated.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to update your post.'));
        }
        if (!$this->request->data) {
            $this->request->data = $post;
        }
    }
    //delete existing post
    public function delete($id) {
        $this->autoRender = false;
        if ($this->Post->delete($id)) {
            $msg['success'] = true;
        } else {
            $msg['success'] = false;
        }
        echo json_encode($msg);
    }

}