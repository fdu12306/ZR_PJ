<?php
    session_start();
    include './mysqlFunc.php';
    include './config.php';
     //用户已登录
     if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']){
        //根据用户id获取用户数据
        $issuedArtwork=getIssuedArtwork($_SESSION['id']);
        $response=array(
            'logged_in'=>true,
            'state'=>200,
            'data'=>$issuedArtwork
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