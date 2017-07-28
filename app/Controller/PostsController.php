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



    public function index() {
        $this->layout = 'layoutUI';

        $id = $this->Auth->user('id');
//        $query = $this->Post->find('all', array(
//            'conditions'=>array('Post.user_id' => $id)));
        $query = $this->Post->find('all', array(
            'order' => 'Post.modified DESC',
            'recursive' => 2
        ));
//        $query = $this->Post->find('all');
        $this->set('posts', $query);


    }

    public function view($id = null) {
        $this->layout = 'layoutUI';
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $auth = false;
//        if($this->isAuthorized())
//        {
//            $auth = true;
//        }
//
////        $this->set('post', $post);
//
//        $this->set(array('post' => $post, 'auth' => $auth));
    }

    public function add() {
        $this->layout = 'layoutUI';
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->Auth->user('id');
//            pr($this->request->data);
//            die();
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Flash->success(__('Your post has been saved.'));
                return $this->redirect(array('controller' => 'posts','action' => 'index'));
            }
            $this->Flash->error(__('Unable to add your post.'));
        }
    }


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

    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        if ($this->Post->delete($id)) {
            $this->Flash->success(
                __('The post with id: %s has been deleted.', h($id))
            );
        } else {
            $this->Flash->error(
                __('The post with id: %s could not be deleted.', h($id))
            );
        }

        return $this->redirect(array('action' => 'index'));
    }



}