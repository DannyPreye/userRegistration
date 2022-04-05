<?php
include_once './inc/functions/checkPost.inc.php';
include_once './inc/functions/connect.inc.php'; 

header('content-type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Origin, X-Requested-With, Accept, Authorization");

$errCode = array();
$jsondata = array();
$registrationError = "";
$registrationSuccesssfull ="";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $checkUsername = $connect_db->check_username($username);
    $checkEmail =  $connect_db->check_userEmail($email);

    if(($checkEmail==false) && ($checkUsername==false)){
        if(empty($error)){
            $response = $connect_db->insert_user_to_db($fullName,$phone_num,$email,$username, $hashPsw);

            if($response==true){
                $result = $connect_db->get_user_data($email, $hashPsw);
                $jsondata["user"]=$result;
                $errCode['code']="00";
           }else{
               $errCode['code']="01";
               $errCode['registration'] = "Registration Failed";
           }
        }else{
            
            array_push($jsondata,$error);
            $errCode['errorCode']="02";
        }
        
    }
    else{
        $errCode['user']="Email or username already registered";
        $errCode['errorCode']="03";
    }
    $jsondata['errcode']=$errCode;
  echo json_encode($jsondata);
}


