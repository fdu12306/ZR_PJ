<?php
    session_start();
    include './mysqlFunc.php';
    include './config.php';
    //接收前端发送的信息
    $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
    //充值失败
    if(!recharge($_SESSION['id'],$amount)){
        $response = array(
            'state' => 5002,
            'message' => '充值失败！'
         );
         echo json_encode($response);
         exit();
    }
    else{
        $response = array(
            'state' => 200,
            'message' => '充值成功！'
         );
         echo json_encode($response);
         exit();
    }
