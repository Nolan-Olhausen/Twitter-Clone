<!--
/****************************************************************************************************
 *
 * @file:    followUnfollowHandler.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for following and unfollowing users. It takes the user id of 
 *      the user to follow/unfollow and the previous link.
 *
 ****************************************************************************************************/
-->

<?php 
    session_start();
    require_once 'Dao.php';
    require_once 'Validator.php';
    $dao = new Dao();
    
    $user_id = $_SESSION['user_id'];
    $prev_link = $_GET['prevLink'];
    $user2 = $_GET['follow_id'];
    if($dao->followsYou($user_id , $user2)) {
        $dao->unFollow($user_id , $user2);
    } else {
        $data_follow = [
            'sender' => $user_id ,
            'receiver' => $user2 , 
            'follow_time' => date("Y-m-d H:i:s") ,
        ];

        $dao->create('follow' , $data_follow);
    }
    header("Location: " . $prev_link);
?>