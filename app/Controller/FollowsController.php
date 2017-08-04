<?php

class FollowsController extends AppController
{
    public $uses = array('Post', 'Comment', 'User','Follow', 'Like');
    public $helpers = array('Html', 'Form');

    // function to to create and update followed user
    public function addFollow()
    {
        // API use only
        $this->autoRender = false;
        date_default_timezone_set('Asia/Manila');
        //getting user_id in Auth user
        $this->request->data['user_id'] = $this->Auth->user('id');
        $userID =  $this->request->data['user_id'];
        //getting follow_id in data send by ajax
        $followID = $this->request->data['follow_id'];
        //find if there's an existing Follow record
        $follow = $this->Follow->find('first', array(
            'conditions' => array(
                'Follow.user_id' => $userID,
                'Follow.follow_id' => $followID
            ),
            'recursive' => 1
        ));
        // if there's a follow corresponding to user_id and follow_id
        if($follow)
        {
            //check the value of isFollow
            $follow['Follow']['isFollow'] = $follow['Follow']['isFollow'] ? false : true;
            //update the database
            $this->Follow->save($follow);
            $respondFollow = $follow['Follow']['isFollow'];
            $followCount = $this->Follow->find('count', array(
                'conditions' => array(
                    'Follow.user_id' => $userID,
                    'Follow.isFollow' => true,

                )));
            echo json_encode(array("followCount"=> $followCount, "$respondFollow" => $respondFollow));
        }
        else {
            //if there's no Follow corresponding to user_id and post_id, new follow will be created
            $this->request->data['user_id'] = $userID;
            $this->request->data['isFollow'] = true;
            $this->request->data['follow_id'] = $followID;
            $this->Follow->create();
            $this->Follow->save($this->request->data);
            $respondFollow = $this->request->data['isFollow'] ;
            $followCount = $this->Follow->find('count', array(
                'conditions' => array(
                    'Follow.user_id' => $userID,
                    'Follow.isFollow' => true,
                )));
            echo json_encode(array("followCount"=> $followCount, "respondFollow" => $respondFollow));
        }
    }
}