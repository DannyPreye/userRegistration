<?php
include_once 'inc\functions\validate.inc.php'; 
include_once './inc/functions/connect.inc.php'; 
include_once './inc/functions/checkGet.php'; 


$jsondata = array();
$errCode = array();


if($_SERVER['REQUEST_METHOD']=='POST'){

    if(empty($error)){ 
        //if error array is empty fetch user details from the database
        $result = $connect_db->get_user_data($email,$password);

        if(!empty($result)){
            // if the data was fetched sucessfully from the db, store the data in the json array for encoding
            array_push($jsondata,$result);
            $errCode['code']="00";
        }
        else{
            // Else store the error code in the errcode array
            $errCode['code']="01";
            $errCode['login'] = "Login Failed";
        }
    }
    else{
        
        array_push($jsondata,$error);
        $errCode['errorCode']="02";
    }
  
}
header('content-type:application/json');
array_push($jsondata,$errCode);
echo json_encode($jsondata);


