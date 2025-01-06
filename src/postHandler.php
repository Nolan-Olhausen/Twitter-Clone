<?php 
    session_start();
    require_once 'Dao.php';
    require_once 'Image.php';
    require_once 'Validator.php';
    $dao = new Dao();

    if ($dao->checkLogIn() === false) {
        header("Location: login.php"); 
    }

    if (isset($_POST['post'])) {

        $status =  $dao->checkInput($_POST['status']) ;

        $img = $_FILES['post_img'];
        
        if ($_POST['status'] == '' && $img['name'] == '' ) {
            $_SESSION['errors'] = ['Either text or an image is required'];
            header("Location: createPost.php"); 
            exit();
        }

        $validate = new Validator;
        $validate->rules('status' , $status , ['max:140']);
        if ($img['name'] != '') {
            $validate->rules('image' , $img['tmp_name'] , ['image']);
        }

        $errors = $validate->errors;
        
        if ($errors == []) { 
            
            if ($img['name'] != '') {
            $image = new Image($img , "post"); 
            $postImg = $image->new_name ;
        
            } else {
                $postImg = null;
            }
    
            date_default_timezone_set("America/Denver");
            $data = [
                'user_id' => $_SESSION['user_id'] , 
                'posted_time' => date("Y-m-d H:i:s") ,
            ];
            
            $post_id =   $dao->create('posts' , $data);
            
            $data_post = [
                'post_id' => $post_id ,
                'text' => $status , 
                'img' => $postImg
            ];

            $dao->create('postContent' , $data_post);
            if ($img['name'] != '') {
                $image->uploadImg(); 
            }
            header("Location: index.php");
        } else {
            $_SESSION['inputs'] = $_POST;
            $_SESSION['errors'] = $errors;
            header("Location: createPost.php");
        }   
    } else {
        header("Location: createPost.php");
    }
?>