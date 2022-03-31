<?php
include_once 'inc\functions\validate.inc.php'; 
include_once './inc/functions/connect.inc.php'; 

$jsondata = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

    $email= santize_data($_POST['email']);
    $password = santize_data($_POST['password']);
    $hashPsw = md5($password);
  
    if($email !== "" && $hashPsw !==""){
      
        $users = $connect_db->get_user_data($email,$hashPsw);
    
        if(count($users)>0){
            $alp ='qsjd'.rand(1000,5000);
        echo str_shuffle($alp);
                $jsondata['fullname'] = $users[0]['fullName'];
                $jsondata['phone'] = $users[0]['phoneNumber'];
                $jsondata['email'] = $users[0]['email'];
                
           
          
        }
        else{
            header("HTTP/1.0 401 Unauthorized"); 
            echo 'failed';
        }
    }
}
header('content-type:application/json');
echo json_encode($jsondata);


