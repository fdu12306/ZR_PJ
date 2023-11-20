<?php
    session_start();
    include './mysqlFunc.php';
    include './config.php';
    $id=isset($_POST['id']) ? $_POST['id']:'';
    $type=isset($_POST['type'])?$_POST['type']:'';
    //comment
    if($type==1){
        if(!deleteComment($id)){
            $response = array(
                'state' => 5002,
                'message' => "修改失败，请联系系统管理员！"
            );
            echo json_encode($response);
            exit();
        }
        $response = array(
            'state' => 200,
            'message' => "删除成功！"
        );
        echo json_encode($response);
    }
    //reply
    else if($type==2){
        if(!deleteReply($id)){
            $response = array(
                'state' => 5002,
                'message' => "修改失败，请联系系统管理员！"
            );
            echo json_encode($response);
            exit();
        }
        $response = array(
            'state' => 200,
            'message' => "删除成功！"
        );
        echo json_encode($response);
    }