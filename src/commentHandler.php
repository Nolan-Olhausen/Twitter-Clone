<!--
/****************************************************************************************************
 *
 * @file:    commentHandler.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for comments. It takes the comment from the user and validates it.
 *
 ****************************************************************************************************/
-->
<?php 
     session_start(); 
     require_once 'Dao.php'; 
     require_once 'Validator.php';
     $dao = new Dao();
     $user_id = $_SESSION['user_id'];
     
    if (isset($_POST['commentSubmit'])) {
        $comment = $dao->checkInput($_POST['comment']);
        $post_id = $_POST['postId'];

        $validate = new Validator; 
        $validate->rules('comment',$comment,['max:140']);
        $errors = $validate->errors;

        if ($errors != []) {
            $_SESSION['inputs'] = $_POST;
            $_SESSION['errors'] = $errors;  
            header("Location: status.php?post_id=".$post_id);
            exit();
        } 

        date_default_timezone_set("America/Denver");
        $data = [
            'comment_text' => $comment ,
            'user_id' => $user_id,
            'post_id' => $post_id, 
            'comment_time' => date("Y-m-d H:i:s") ,
        ];
        $comment_id = $dao->create('comments', $data); 

        header("Location: status.php?post_id=" . $post_id); 
    }
?>