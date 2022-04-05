<?php
    include_once 'inc\classes\baseClass.php'; 

    $server = '127.0.0.1';
    $username = 'Daniel';
    $dbName = 'daniel';
    $password = '12345678';
    $table = 'Racks_Blog';

    $connect_db = new db($server,$username,$password,$dbName,$table);
    
    //connect db
    $connect_db->dbConnect();

    // Create the table
    $connect_db->create_blog();