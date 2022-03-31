<?php 

// Sanitize input 
    function santize_data($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
         
        return $data;
    }

// Validate name
function validate_name($name){
    $name = str_replace(" ","",$name);
    if(empty($name) || !ctype_alpha($name)){
        return true;
    }
}

// Validate phone
function validate_phone($phone){
    if(empty($phone) || !ctype_digit($phone)){
        return true;
    }
}

// validate email
function validate_email($email){
    if(empty($email)|| !filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }
}

// validate password
function validate_password($password){
    if(empty($password) || (strlen($password)<8)){
        return true;
    }
}

// validate username
function validate_username($username){
    if(empty($username)){
        return true;
    }
}