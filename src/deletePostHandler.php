<!--
/****************************************************************************************************
 *
 * @file:    deletePostHandler.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for deleting posts. It takes the post_id from the user and deletes the post.
 *
 ****************************************************************************************************/
-->

<?php 
    session_start();
    require_once 'Dao.php';
    $dao = new Dao();
    
    $user_id = $_SESSION['user_id'];
    $post_id = $_GET['post_id'];
    $dao->deletePost($post_id);
    header("Location: index.php");
?>