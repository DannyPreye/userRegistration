<?php
    include_once 'inc\classes\baseClass.php'; 
    include_once 'inc\functions\validate.inc.php'; 
    include_once 'inc\functions\connect.inc.php'; 

   

    $fullName =$phone_num=$email=$password=$username="";
    // connect to db
    $error =array();
    if($_SERVER['REQUEST_METHOD']=='POST'){

        // $rawData = file_get_contents("php://input"); //get the data from the front-end
        // $decodeData = json_decode($rawData,true); //decode the data

        // check name
        $name = (isset($_POST['Name'])) ? $_POST['Name']:"";
        $email1 = (isset($_POST['email'])) ? $_POST['email']:"";
        $pass = (isset($_POST['password'])) ? $_POST['password']:"";
        
        if(validate_name($name)==true){
    
        // check email
        if( validate_email($email1)==true){
            $error['email'] = "Enter a validate email address";
        }else{
            $email = santize_data($email1);
        }
       

        // check password
        if(validate_password($pass)==true){
            $error['password']="password must not be empty and must 8 or more character long";
        }else{
            $password = santize_data($pass);
        }
        
        $hashPsw = md5($password); //Encrypted password
    
       }
    }

