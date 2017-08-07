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
    public $helpers = array('Html', 'Form', 'Time');

    //view for the dashboard renamed in routes index.ctp
    public function index() {
         $this->layout = 'layoutUI';

        $query = $this->Post->find('all', array(
             'contain' => array(
             'User',
             'Like',
             'Comment' => array('User',
                 'order' => array('Comment.modified' => 'ASC')
             )
         ),
         'order' => array('Post.modified' => 'DESC')
        
        )
    );
        $this->set('posts', $query);

    }
    //add new post
    public function add() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            date_default_timezone_set('Asia/Manila');
            $this->request->data['user_id'] = $this->Auth->user('id');
            $userID =$this->request->data['user_id'];
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $id = $this->Post->getLastInsertID();
                $query = $this->Post->find('first', array(
                'conditions' => array(
                    'Post.id' => $id,
                ),
            ));
                echo json_encode(array("userID" => $userID, "query" => $query));
            }
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
         $this->autoRender = false;
      
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        if ($this->request->is(array('post', 'put'))) {
            date_default_timezone_set('Asia/Manila');
            $this->Post->id = $id;
            if ($this->Post->saveField('status', $this->request->data['status'], false)) 
            {
                $post = $this->Post->findById($id);
                $msg['status'] = $post['Post']['status'];
            }
           
          
        }
        if (!$this->request->data) {
            $this->request->data = $post;
        }
         return json_encode($msg);
    }
    //delete existing post
    public function delete($id) {

        $this->autoRender = false;

        $likes = $this->Post->find('first', array(
            'conditions' => array(
                    'id' => $id
                ),
                'contain' => array(
                    'Like'
                )
        ));
       $comments = $this->Post->find('first', array(
            'conditions' => array(
                    'id' => $id
                ),
                'contain' => array(
                    'Comment'
                )
        ));
        
        if ($this->Post->delete($id)) {
            foreach($likes['Like'] as $like)
            {
                 $this->Like->delete($like['id']);
             }
             foreach($comments['Comment'] as $comment)
            {
                 $this->Comment->delete($comment['id']);
             }
            $msg['success'] = true;
        } else {
            $msg['success'] = false;
        }

       return json_encode($msg);
    }
}