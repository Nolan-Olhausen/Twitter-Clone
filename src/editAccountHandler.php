<!--
/****************************************************************************************************
 *
 * @file:    editAccountHandler.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for editing account information. It takes the user's input and validates it.
 *
 ****************************************************************************************************/
-->

<?php 
     session_start(); 
     require 'vendor/autoload.php';
     // this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
     $s3 = new Aws\S3\S3Client([
         'version'  => 'latest',
         'region'   => 'us-west-2',
     ]);
     $bucket = getenv('S3_BUCKET_NAME')?: die('No "S3_BUCKET" config var in found in env!');
     require_once 'Dao.php'; 
     require_once 'Image.php';
     require_once 'Validator.php';
     $dao = new Dao();
     $user_id = $_SESSION['user_id'];
     $user = $dao->getDataUser($user_id);
     $username =  $dao->getUsername($_SESSION['user_id']);

    if (isset($_POST['update'])) {

        $name = $dao->checkInput($_POST['name']);
        $bio = $dao->checkInput($_POST['bioProf']);
        $image = $_FILES['profile_img'];

        $v = new Validator;
        $v->rules('name', $name, ['max:20']);
        $v->rules('bio', $bio, ['max:140']);
        $v->rules('image', $image['tmp_name'] , ['image']);

        $errors = $v->errors;

        if($name == '') {
            $name = $user->name;
        }
        if($bio == '') {
            $bio = $user->bio;
        }

        if ($errors == []) {
    
            if ($image['name'] !== "") {
                $img = new Image($image); 
                $userImg = $img->new_name ;
            } else $userImg = $user->profile_image;
    
            if ($image['name'] !== "") {    
                $submitGood = $img->uploadImg(); 
            }

            if($submitGood === true || $image['name'] == "") {
                $data = [
                    'name' => $name ,
                    'bio' => $bio ,
                    'profile_image' => $userImg , 
                ];
                $sign = $dao->update('users' , $_SESSION['user_id'], $data); 
            } else {
                $errors = "Error submitting image";
                $_SESSION['inputs'] = $_POST;
                $_SESSION['errors'] = $errors;
                header("Location: editAccount.php");
            }

            if($sign === true) {
                header("Location: profile.php?username=" . $username);
            } else {
                $errors = "Error updating user data";
                $_SESSION['inputs'] = $_POST;
                $_SESSION['errors'] = $errors;
                header("Location: editAccount.php");
            }
            
        } else {
            $_SESSION['inputs'] = $_POST;
            $_SESSION['errors'] = $errors;
            header("Location: editAccount.php");
        }

    } else header("Location: editAccount.php");
?>