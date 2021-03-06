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


    /**
     *this function used to save data in Comment model
     @param int $id will get the value of the post_id
     * $userID int will store the auth user id
     * $comments is a variable with object return data type
     * a date default timezone is set to Asia/Manila for created and modified datetime
     * return type json
     */
    public function addComment($id)
    {
        $this->autoRender = false;
        $postID = $id;
        $userID = $this->Auth->user('id');
        
            date_default_timezone_set('Asia/Manila');
            $this->request->data['user_id'] = $userID;
            $this->request->data['post_id'] = $postID;
            //create new comment
            $this->Comment->create();
             if ($this->Comment->save($this->request->data)) {
                    $commentID = $this->Comment->getLastInsertID();
                    $query = $this->Comment->find('first', array(
                    'conditions' => array(
                        'Post.id' => $postID,
                        'Comment.user_id' => $userID,
                        'Comment.id' => $commentID,
                    ),
                ));
                    echo json_encode($query);
            }
    }
    /**
     * this function used to edit data in comment model
       @param int $id will get the value of the comment id
     * $comment variable to get the last input Comment
     * return type json variable $msg for Comment model object
     */
    public function edit($id = null) {
         $this->autoRender = false;
      
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        if ($this->request->is(array('post', 'put'))) {
            date_default_timezone_set('Asia/Manila');
            $this->Comment->id = $id;
            if ($this->Comment->saveField('comment', $this->request->data['comment'], false)) 
            {
                $comment = $this->Comment->findById($id);
                $msg['comment'] = $comment['Comment']['comment'];
            }
           
          
        }
        if (!$this->request->data) {
            $this->request->data = $post;
        }
         return json_encode($msg);
    }
    /**
     *this function used to delete data in comment model
     @param int $id will get the value of the comment id
     * return type json variable $msg with data type boolean
     */
    public function delete($id)
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            if ($this->Comment->delete($id)) {
                $msg['success'] = true;
            } else {
                $msg['success'] = false;
            }
            echo json_encode($msg);
        }
    }
}