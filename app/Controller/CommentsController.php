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
     *this function used to save data in comment model
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
            $comments = $this->Comment->find('all', array(
                'conditions' => array(
                    'Comment.post_id' => $postID,

                ),
                'recursive' => 1
            ));
            return json_encode($comments);
        }
        $this->Session->setFlash(__('Unable to add your post.'));
    }
    /**
     *this function used to edit data in comment model in the edit.ctp view
      @param int $id will get the value of the comment id
     */
    public function edit($id = null) {
        $this->layout = 'layoutUI';
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $comment = $this->Comment->findById($id);
        if (!$comment) {
            throw new NotFoundException(__('Invalid post'));
        }

        if ($this->request->is(array('post', 'put'))) {
            $this->Comment->id = $id;
            if ($this->Comment->save($this->request->data)) {
                $this->layout = 'layoutUI';
                $this->Flash->success(__('Your comment has been updated.'));
                return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
            }
            $this->Flash->error(__('Unable to update your post.'));
        }
        if (!$this->request->data) {
            $this->request->data = $comment;
        }
    }
    /**
     *this function used to delete data in comment model
     @param int $id will get the value of the comment id
     * $msg is a variable with object return data type
     * return type json
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