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

    /* use to save the data to Comment model */
    public function addComment($id)
    {
        $this->autoRender = false;
        $postID = $id;
        $userID = $this->Auth->user('id');
        $this->request->data['user_id'] = $userID;
        $this->request->data['post_id'] = $postID;
        //create new comment
        $this->Comment->create();
        //saving new omment
        if ($this->Comment->save($this->request->data)) {
            $comments = $this->Comment->find('all', array(
                'conditions' => array(
                    'Comment.post_id' => $postID
                ),
                'recursive' => 1
            ));
            return json_encode($comments);
        }
        $this->Session->setFlash(__('Unable to add your post.'));
    }
    /* function to edit the save data in Comment Model in edit.ctp View*/
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
    /* function to delete Comment */
    public function delete($id)
    {
        if ($this->Comment->delete($id)) {
            $this->Flash->success(
                __('The comment has been deleted.')
            );
        } else {
            $this->Flash->error(
                __('The comment with id: %s could not be deleted.', h($id))
            );
        }
        return $this->redirect(array('controller' => 'posts', 'action' => 'index'));
    }
}