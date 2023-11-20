<?php
     session_start();
     include './mysqlFunc.php';
     include './config.php';
     //接收前端发送的注册信息
     $commentId=isset($_POST['commentId'])?$_POST['commentId']:'';
     $artworkId = isset($_POST['artworkId']) ? $_POST['artworkId'] : '';
     $content = isset($_POST['content']) ? $_POST['content'] : '';
     $toName=isset($_POST['toName'])?$_POST['toName']:'';
     $session_id = $_COOKIE['PHPSESSID'];
     $issueTime=date('Y-m-d H:i:s');
     //用户已登录
     if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']){
        //将对应的信息存入数据库
        if(!insertReply($commentId,$artworkId,$_SESSION['id'],$_SESSION['username'],$toName,$content,$issueTime,0,0,0)){
            $response = array(
                'logged_in'=>true,
                'state' => 5000,
                'message' => "数据导入数据库失败，请联系系统管理员！"
            );
            echo json_encode($response);
            exit();
        }
        $response = array(
            'logged_in'=>true,
            'state' => 200,
            'message' => "发布成功！"
        );
        echo json_encode($response);
    }
    //未登录
    else{
        $response=array(
            'logged_in'=>false
        );
        echo json_encode($response);
        exit();
    }