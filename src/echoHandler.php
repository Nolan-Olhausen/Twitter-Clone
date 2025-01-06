<!--
/****************************************************************************************************
 *
 * @file:    echoHandler.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for echoes. It takes the echo from the user and validates it.
 *
 ****************************************************************************************************/
-->

<?php 
     session_start(); 
     require_once 'Dao.php'; 
     require_once 'Validator.php';
     $dao = new Dao();
     $user_id = $_SESSION['user_id'];
     date_default_timezone_set("America/Denver");

    if (isset($_POST['echoSubmit'])) {
        if(!empty($_POST['comment'])){
            $postContent_id  = $_POST['postContent_id'];
            $get_id = $_POST['user_id'];
            $flag = $_POST['echo_comment'];
            $echoed = $_POST['user_echoed'];
            $qoq = $_POST['qoq'];
            $echo_sign = $_POST['echo_sign'];
            $comment = $dao->checkInput($_POST['comment']);
            $echo = $dao->getEcho($postContent_id);

            $validate = new Validator; 
            $validate->rules('comment',$comment,['required','max:140']);
            $errors = $validate->errors;

            if ($errors != []) {
                $_SESSION['inputs'] = $_POST;
                $_SESSION['errors'] = $errors;  
                header("Location: echo.php?postContent_id=".$postContent_id."&user_id=".$get_id."&user_echoed=".$echoed."&echo_sign=".$echo_sign."&echo_comment=".$comment."&qoq=".$qoq);
                exit();
            } 

                date_default_timezone_set("America/Denver");

                $data = [
                    'user_id' => $_SESSION['user_id'] , 
                    'posted_time' => date("Y-m-d H:i:s") ,
                ];
                // create function can handle with all tables and return last inserted id
                $post_id = $dao->create('posts' , $data);
                // qoq is check if this echo qoute of qoute or not
                if (!empty($_POST['comment'])) {
        
                // if flag true then the echoed post is qoute post and the fk is echo_id
                        if ($flag && !$qoq) {
                            if($dao->isEcho($postContent_id)) {

                                $data_post = [
                                    'post_id' => $post_id ,
                                    'echo_msg' => $comment , 
                                    'echo_id' => $echo->post_id ,
                                    'postContent_id' => null
                                ];
                            } else {
                                $data_post = [
                                    'post_id' => $post_id ,
                                    'echo_msg' => $comment , 
                                    'echo_id' => $postContent_id ,
                                    'postContent_id' => null
                                ];
                            }
                            
                        } else if ($qoq) {

                                if ($echo->echo_msg == null ) {
                                $data_post = [
                                    'post_id' => $post_id ,
                                    'echo_msg' => $comment , 
                                    'echo_id' => $echo->post_id ,
                                    'postContent_id' => null
                                ];
                            }	else {
                                $data_post = [
                                    'post_id' => $post_id ,
                                    'echo_msg' => $comment , 
                                    'echo_id' => $postContent_id ,
                                    'postContent_id' => null
                                ];
                            }
                        } else {
                                if($dao->isEcho($postContent_id)) {
                                    $data_post = [
                                        'post_id' => $post_id ,
                                        'echo_msg' => $comment , 
                                        'postContent_id' => $echo->postContent_id ,
                                        'echo_id' => null
                                    ];
                                } else {
                                    $data_post = [
                                        'post_id' => $post_id ,
                                        'echo_msg' => $comment , 
                                        'postContent_id' => $postContent_id ,
                                        'echo_id' => null
                                    ]; 
                                }
                        }
                    
            } else if (empty($_POST['comment'])) {
                if ($flag) {
                    if($dao->isEcho($postContent_id)) {
                        $data_post = [
                            'post_id' => $post_id ,
                            'echo_msg' => null , 
                            'echo_id' => $echo->post_id,
                            'postContent_id' => null
                        ];
                    } else {
                        $data_post = [
                            'post_id' => $post_id ,
                            'echo_msg' => null , 
                            'echo_id' => $postContent_id,
                            'postContent_id' => null
                        ];
                    }
                } else if ($qoq) {
                    if ($echo->echo_msg == null ) {
                    $data_post = [
                        'post_id' => $post_id ,
                        'echo_msg' => null , 
                        'echo_id' => $echo->post_id ,
                        'postContent_id' => null
                    ];
                } else {
                    $data_post = [
                        'post_id' => $post_id ,
                        'echo_msg' => null , 
                        'echo_id' => $postContent_id ,
                        'postContent_id' => null
                    ];
                } 
                } else {
                    $data_post = [
                        'post_id' => $post_id ,
                        'echo_msg' => null , 
                        'postContent_id' => $postContent_id,
                        'echo_id' => null
                    ];
                }
            }
            $dao->create('echoes' , $data_post);
        } else {
            $postContent_id  = $_POST['postContent_id'];
            $get_id = $_POST['user_id'];
            $flag = $_POST['echo_comment'];
            $qoq = $_POST['qoq'];
            $echo = $dao->getEcho($postContent_id);

            date_default_timezone_set("America/Denver");

            $data = [
                'user_id' => $_SESSION['user_id'] , 
                'posted_time' => date("Y-m-d H:i:s") ,
            ];
            // create function can handle with all tables and return last inserted id
            $post_id = $dao->create('posts' , $data);

            // if flag true then the echoed post is qoute post and the fk is echo_id
            if ($flag) {
                    if($dao->isEcho($postContent_id)) {
                    $data_post = [
                        'post_id' => $post_id ,
                        'echo_msg' => null , 
                        'echo_id' => $echo->post_id,
                        'postContent_id' => null
                    ];
                } else {
                    $data_post = [
                        'post_id' => $post_id ,
                        'echo_msg' => null , 
                        'echo_id' => $postContent_id,
                        'postContent_id' => null
                    ];
                }
            } else if ($qoq) {

                if($dao->isEcho($postContent_id) && $echo->echo_msg == null) {
                    $data_post = [
                        'post_id' => $post_id ,
                        'echo_msg' => null , 
                        'echo_id' => $echo->post_id,
                        'postContent_id' => null
                    ];
                } else {
                    $data_post = [
                        'post_id' => $post_id ,
                        'echo_msg' => null , 
                        'echo_id' => $postContent_id,
                        'postContent_id' => null
                    ];
                }
            } else {
                
                if ($dao->isEcho($postContent_id)) {
                    
                    $data_post = [
                        'post_id' => $post_id ,
                        'echo_msg' => null , 
                        'postContent_id' => $echo->postContent_id,
                        'echo_id' => null
                    ];
                } else {

                    $data_post = [
                        'post_id' => $post_id ,
                        'echo_msg' => null , 
                        'postContent_id' => $postContent_id,
                        'echo_id' => null
                    ];
                }
            }
            $dao->create('echoes' , $data_post);
    } 
}

	if($_POST['user_echoed'] == 'true'){

        $postContent_id  = $_POST['postContent_id'];
		$user_id = $_POST['user_id'];

		$dao->undoEcho($user_id , $postContent_id );

	}
    header("Location: index.php");

?>