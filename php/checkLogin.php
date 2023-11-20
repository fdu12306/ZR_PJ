<?php
    session_start();
    include './config.php';
    include './mysqlFunc.php';
    //用户已登录
    if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']){
        $userData=getUserDataById($_SESSION['id']);
        $response=array(
            'logged_in'=>true,
            'username'=>$userData['username']
        );
        echo json_encode($response);
        exit();
    }
    //未登录
    else{
        $response=array(
            'logged_in'=>false
        );
        echo json_encode($response);
        exit();
    }