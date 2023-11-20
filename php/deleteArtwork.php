<?php
    session_start();
    include './mysqlFunc.php';
    include './config.php';
    //获取艺术品id
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    //获取艺术品文件路径,删除图片
    $dir="./upload/";
    $artwork=getArtWorkDataById($id);
    $imgName=basename($artwork['imagePath']);
    $imgPath=$dir.$imgName;
    unlink($imgPath);
    //从数据库中删除
    if(!deleteArtwork($id)){
        $response=array(
            'state'=>5003,
            'message'=>'删除艺术品数据异常，请联系系统管理员！'
        );
        echo json_encode($response);
        exit();
    }
    //修改购物车中艺术品的状态
    modifyBusinessState($id,-1);
    $response=array(
        'state'=>200,
        'message'=>'删除成功！'
    );
    echo json_encode($response);
    exit();