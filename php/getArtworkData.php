<?php
    session_start();
    include './mysqlFunc.php';
    include './config.php';
    //获取艺术品id
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    //根据艺术品id获取信息
    $artworkData=getArtWorkDataById($id);
    if($artworkData==null){
        $response=array(
            'state'=>5001,
            'message'=>'获取艺术品数据异常，请联系系统管理员！'
        );
        echo json_encode($response);
        exit();
    }
    else{
        //获取发布者用户名
        $userId=$artworkData['ownerId'];
        $ownerData=getUserDataById($userId);
        $response=array(
            'state'=>200,
            'ownername'=>$ownerData['username'],
            'data'=>$artworkData
        );
        echo json_encode($response);
        exit();
    }
