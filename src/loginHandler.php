<!--
/****************************************************************************************************
 *
 * @file:    loginHandler.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the handler for logging in. It takes the username/email and password from the 
 *      user and validates it.
 *
 ****************************************************************************************************/
-->

<?php
    session_start();
    require_once 'Dao.php';
    require_once 'Validator.php';
    $dao = new Dao();
    
    if (isset($_POST['login']) && !empty($_POST['login'])) {
        $username_email = $_POST['username/email'];
        $password = $_POST['password'];

        if(!empty($email) && !empty($password)) {
        $username_email = $dao->checkInput($username_email);
        $password = $dao->checkInput($password); 
        } 

        $validate = new Validator; 
        $validate->rules('username/email',$username_email,['required','username/email']);
        $validate->rules('password',$password,['required']);
        $errors = $validate->errors;

        if($errors == []) {
            $dao->login($username_email,$password);
            if($dao->login($username_email,$password) === false ) {
                $_SESSION['inputs'] = $_POST;
                $_SESSION['errors'] = ['The username/email or password is incorrect'];
                header("Location: login.php");
            }
        } else {
            $_SESSION['inputs'] = $_POST;
            $_SESSION['errors'] = $errors;
            header("Location: login.php");
        }
    } else  header("Location: login.php");
?>