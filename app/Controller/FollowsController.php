<?php

class FollowsController extends AppController
{
    public $uses = array('Post', 'Comment', 'User','Follow', 'Like');
    public $helpers = array('Html', 'Form');

    /**
     * this function used to add data in Follow model
     * @param int $id will get the value of the user id you want to follow
     * $msg is a variable with object return data type
     * a date default timezone is set to Asia/Manila for created and modified datetime
     * $userID int will store the auth user id
     * $respondFollow boolean will store the result value isFollow in the Follow Model
     * return type json
     */
    public function addFollow($id)
    {
        // API use only
        $this->autoRender = false;
        date_default_timezone_set('Asia/Manila');
        //getting user_id in Auth user
        $this->request->data['user_id'] = $this->Auth->user('id');
        $userID =  $this->request->data['user_id'];
        //getting follow_id in data send by ajax


        //find if there's an existing Follow record
        $follow = $this->Follow->find('first', array(
            'conditions' => array(
                'Follow.user_id' => $userID,
                'Follow.follow_id' => $id
            ),
            'recursive' => 1
        ));
        // if there's a follow corresponding to user_id and follow_id
        if(!empty($follow))
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
            echo json_encode(array("followCount"=> $followCount, "respondFollow" => $respondFollow));
        }
        else {
            //if there's no Follow corresponding to user_id and post_id, new follow will be created
            $this->request->data['user_id'] = $userID;
            $this->request->data['isFollow'] = true;
            $this->request->data['follow_id'] = $id;
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