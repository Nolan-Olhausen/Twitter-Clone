<!--
/****************************************************************************************************
 *
 * @file:    createAccountHandler.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for creating an account. It takes the user input and validates it.
 *
 ****************************************************************************************************/
-->

<?php 
    session_start();
    require_once 'Dao.php';
    require_once 'Validator.php';
    $dao = new Dao();

    if (isset($_POST['createAccount'])) {
    
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($email) || !empty($password) || !empty($name) || !empty($username))   {
            $email = $dao->checkInput($email);
            $password = $dao->checkInput($password);
            $name = $dao->checkInput($name);
            $username = $dao->checkInput($username);
        } 

        $validate = new Validator; 
        $validate->rules('name',$name,['required','max:20']);
        $validate->rules('username',$username,['required','max:20']);
        $validate->rules('email',$email,['required','email']);
        $validate->rules('password',$password,['min:5']);
        $errors = $validate->errors;
        
        if ($errors == []){
            $username = str_replace(' ','',$username);
            
            if($dao->checkEmail($email) === true) {
                $error = 'This Email is already in use';
                $errors2['email'] = $error;
                $_SESSION['errors'] = $errors2;
            }
            if ($dao->checkUserName($username) === true) {
                $error = 'This Username is already in use';
                $errors2['username_use'] = $error;
                $_SESSION['errors'] = $errors2;
            } 
            if (!preg_match("/^[a-zA-Z0-9_]*$/",$username)) {
                $error = 'Only Characters and Numbers allowed in Username';
                $errors2['username_format'] = $error;
                $_SESSION['errors'] = $errors2;
            } 
            if (isset($_SESSION['errors'])) {
                $_SESSION['inputs'] = $_POST;
                header("Location: createAccount.php");
            } else {
                $dao->createAccount($email,$password,$name,$username);   
            }
        } else { 
            $_SESSION['inputs'] = $_POST;
            $_SESSION['errors'] = $errors;  
            header("Location: createAccount.php");
        }
            
    } else header("Location: createAccount.php");
?>