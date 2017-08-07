<?php


class PostsController extends AppController
{
    public $uses = array('Post', 'Comment', 'User', 'Follow', 'Like');
    public $helpers = array('Html', 'Form', 'Time');


    /**
     * this function used render the view for the dashboard renamed in routes   
     * index.ctp
     * $query contains all the posts that will be sent to view index.ctp
     */
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
    /**
     *this function used to add post in Post model
     * $userID int will store the auth user id
     * a date default timezone is set to Asia/Manila for created and modified 
     * $comments is a variable with object return data type
     * return type array json passing the user_id and the post to be added;
     */
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
  
     /**
     * this function used to edit existing post
       @param int $id will get the value of the post id
     * $post variable to get the last input post
     * return type json variable $msg for Post model status
     */
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
     /**
     * this function used to delete existing post
       @param int $id will get the value of the post id
     * it will also delete the likes and comments contain in the post
     * return type json variable $msg for boolean success
     */
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