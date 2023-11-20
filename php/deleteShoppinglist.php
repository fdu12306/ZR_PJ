<?php
    session_start();
    include './mysqlFunc.php';
    include './config.php';
    //获取id
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    //从数据库中删除
    if(!deleteShoppinglist($id)){
        $response=array(
            'state'=>5003,
            'message'=>'删除数据异常，请联系系统管理员！'
        );
        echo json_encode($response);
        exit();
    }

    $response=array(
        'state'=>200,
        'message'=>'移出购物车成功！'
    );
    echo json_encode($response);
    exit();