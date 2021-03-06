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


    /**
     * this function check whether a the user already like the post or not and 
     * creating new Like
     * $userid will get
     * a date default timezone is set to Asia/Manila for created and modified datetime
     * $userID int will store the auth user id
     * $respondLike boolean will store the result value isLike in the Like Model
     * $likeCount integer to count all likes in post
     * return type array json 
     */
    
    public function isLike()
    {
        $this->layout = 'layoutUI';
        $this->autoRender = false;
        date_default_timezone_set('Asia/Manila');
        $postID = $this->request->query("post_id");
        $userid = $this->request->query['user_id'];

        $post = $this->Like->find('count', array(
            'conditions' => array('Like.post_id' => $postID)));
        // if theres a post to like
        if($post>0){
            $like = $this->Like->find('first', array(
                'conditions' => array(
                    'Like.user_id' => $userid,
                    'Like.post_id' => $postID
                ),
                'recursive' => 1
            ));
            // if there's a like corresponding to user_id and post_id
            if($like)
            {
                //check the value of isLike
                $like['Like']['isLike'] = $like['Like']['isLike'] ? false : true;
                $this->Like->save($like);
                $respondLike = $like['Like']['isLike'];
                $likeCount = $this->Like->find('count', array(
                    'conditions' => array(
                        'Like.post_id' => $postID,
                        'Like.isLike' => true,

                        )));
                echo json_encode(array("likeCount"=> $likeCount, "respondLike" => $respondLike));
            }
            else {
                //if there's is no like corresponding to user_id and post_id, new Like will be created
                $this->request->data['user_id'] = $this->Auth->user('id'    );
                $this->request->data['isLike'] = true;
                $this->request->data['post_id'] = $postID;
                $this->Like->create();
                $this->Like->save($this->request->data);
                $respondLike = $this->request->data['isLike'] ;
                 $likeCount = $this->Like->find('count', array(
                    'conditions' => array(
                        'Like.post_id' => $postID,
                        'Like.isLike' => true,

                        )));
               echo json_encode(array("likeCount"=> $likeCount, "respondLike" => $respondLike));
        }

        }else{
            //if there's no like corresponding to user_id and post_id, new Like will be created
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->request->data['isLike'] = true;
            $this->request->data['post_id'] = $postID;
            $this->Like->create();
            $this->Like->save($this->request->data);
            $respondLike = $this->request->data['isLike'] ;
            $likeCount = $this->Like->find('count', array(
                    'conditions' => array(
                        'Like.post_id' => $postID,
                        'Like.isLike' => true,

                        )));
               echo json_encode(array("likeCount"=> $likeCount, "respondLike" => $respondLike));
        }
    }
}