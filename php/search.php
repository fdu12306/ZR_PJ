<?php
    include './mysqlFunc.php';
    include './config.php';
    //接收前端发送的登录信息
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    //根据艺术品名字搜索
    if($type==1){
        $artwork=searchByArtworkName($content);
        $response = array(
            'state' => 200,
            'artwork' => $artwork
        );
        echo json_encode($response);
        exit();
    }
    //根据作者名字搜索
    else if($type==2){
        $artwork=searchByAuthorName($content);
        $response = array(
            'state' => 200,
            'artwork' => $artwork
        );
        echo json_encode($response);
        exit();
    }
    //根据艺术品风格搜索
    else if($type==3){
        $artwork=searchByArtworkStyle($content);
        $response = array(
            'state' => 200,
            'artwork' => $artwork
        );
        echo json_encode($response);
        exit();
    }