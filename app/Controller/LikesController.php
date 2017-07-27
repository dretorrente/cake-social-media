<?php

/**
 * Created by PhpStorm.
 * User: YNS
 * Date: 27/07/2017
 * Time: 3:36 PM
 */
class LikesController extends AppController
{

    public $uses = array('Post', 'Comment', 'User','Follow', 'Like');
    public $helpers = array('Html', 'Form');


    public function isLike($id)
    {

        $this->layout = 'layoutUI';
        $this->autoRender = false;


        $this->request->data['user_id'] = $this->Auth->user('id');
        $userid = $this->request->data['user_id'];


        $like = $this->Like->find('first', array(
            'conditions' => array('Like.post_id' => $id)));

        if(empty($like))
        {
            if ($this->request->is('get')) {
                pr("dasda");
                $this->request->data['user_id'] = $this->Auth->user('id');
                $this->request->data['isLike'] = true;
                $this->request->data['post_id'] = $id;
                $this->Like->create();
                if ($this->Like->save($this->request->data)) {
//                $this->Flash->success(__('Your post has been saved.'));
                    return $this->redirect(array('controller' => 'posts','action' => 'index'));
                }
            }
        }
        else{
            $this->Like->delete();
            return $this->redirect(array('controller' => 'posts','action' => 'index'));
        }




    }



}