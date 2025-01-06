<!--
/****************************************************************************************************
 *
 * @file:    sendMessageHandler.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for sending messages. It takes the message from the user and validates it.
 *
 ****************************************************************************************************/
-->

<?php 
     session_start(); 
     require_once 'Dao.php'; 
     $dao = new Dao();
     $user_id = $_SESSION['user_id'];
     $user2 = $_POST['toUser'];

    if (isset($_POST['sendMessageSubmit'])) {
        $message =  $dao->checkInput($_POST['message']);

        date_default_timezone_set("America/Denver");
        $data = [
            'messageText' => $message ,
            'messageTo' => $user2,
            'messageFrom' => $user_id, 
            'messageTime' => date("Y-m-d H:i:s") ,
        ];
        $message_id = $dao->create('messages', $data); 

        header("Location: sendMessage.php?toUser=" . $user2);
        
    }
?>