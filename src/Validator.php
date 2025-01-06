<!--
/****************************************************************************************************
 *
 * @file:    Validator.php
 * @author:  Nolan Olhausen
 * @date: 2024-04-5
 *
 * @brief:
 *      This file is the validator. It validates the input from the user.
 *
 ****************************************************************************************************/
-->

<?php
    class Validator {

        public $errors = [];

        public function __construct() {
            $this->errors = [];
        }

        public function rules ($name , $value , array $rules) {
            foreach ($rules as $rule) {
                if ($rule == 'required') {
                    if (strlen($value) == 0) {
                        $error = "$name is required";
                    } else {
                        $error = '';
                    }
                } else if ($rule == 'email') {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL) ) {
                        $error = "$name is not valid email";
                    } else {
                        $error = '';
                    }
                } else if ($rule == 'max:20') {
                    if (strlen($value) > 20) {
                        $error = "$name must be 20 chars or less";
                    } else {
                        $error = '';
                    }
                } else if ($rule == 'max:100') {
                    if (strlen($value) > 100) {
                        $error = "$name must be 100 chars or less";
                    } else {
                        $error = '';
                    }
                } else if ($rule == 'max:140') {
                    if (strlen($value) > 140) {
                        $error = "$name must be 140 chars or less";
                    } else {
                        $error = '';
                    }
                } else if ($rule == 'min:5') {
                    if (strlen($value) < 5) {
                        $error = "$name must be at least 5 chars";
                    } else {
                        $error = '';
                    }
                } else if ($rule == 'numeric') {
                    if (strlen($value) > 0 && !is_numeric($value)) {
                        $error = "$name must be number";
                    } else {
                        $error = '';
                    }
                } else if ($rule == 'image') {
                    $types = ['image/jpg','image/jpeg','image/png' ];
                    if (strlen($value) > 0 && !in_array(mime_content_type($value), $types)) {
                        $error = "$name must be a jpg, jpeg, or png image";
                    } else {
                        $error = '';
                    }
                } else {
                    $error = '';
                }

                if ($error !== '') {
                    $this->errors[$name] = $error;
                }
            }
        }
    }
?>