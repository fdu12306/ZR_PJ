<?php
     session_start();
     include './mysqlFunc.php';
     include './config.php';
     //接收前端发送的注册信息
     $id=isset($_POST['id'])?$_POST['id']:'';
     $type=isset($_POST['type'])?$_POST['type']:'';
     $likes=isset($_POST['likes'])?$_POST['likes']:'';
     $likeState=isset($_POST['likeState'])?$_POST['likeState']:'';
     $session_id = $_COOKIE['PHPSESSID'];
     //用户已登录
     if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']){
        //将对应的信息存入数据库
        //点赞评论
        if($type==1){
            if(!modifyCommentLikes($id,$likes)){
                $response = array(
                    'logged_in'=>true,
                    'state' => 5002,
                    'message' => "修改数据库数据失败，请联系系统管理员！"
                );
                echo json_encode($response);
                exit();
            }
            if($likeState==0){
                insertCommentLikes($id,$_SESSION['id']);
            }
            else if($likeState==1){
                deleteCommentLikes($id,$_SESSION['id']);
            }
            $response = array(
                'logged_in'=>true,
                'state' => 200,
                'message' => "点赞成功！"
            );
            echo json_encode($response);
        }
        //点赞回复
        else if($type==2){
            if(!modifyReplyLikes($id,$likes)){
                $response = array(
                    'logged_in'=>true,
                    'state' => 5002,
                    'message' => "修改数据库数据失败，请联系系统管理员！"
                );
                echo json_encode($response);
                exit();
            }
            if($likeState==0){
                insertReplyLikes($id,$_SESSION['id']);
            }
            else if($likeState==1){
                deleteReplyLikes($id,$_SESSION['id']);
            }
            $response = array(
                'logged_in'=>true,
                'state' => 200,
                'message' => "点赞成功！"
            );
            echo json_encode($response);
        }
    }
    //未登录
    else{
        $response=array(
            'logged_in'=>false
        );
        echo json_encode($response);
        exit();
    }