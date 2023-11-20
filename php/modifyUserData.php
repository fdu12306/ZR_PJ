<?php
   session_start();
   include './mysqlFunc.php';
   include './config.php';
   //接收前端发送的注册信息
   $username = isset($_POST['username']) ? $_POST['username'] : '';
   $email = isset($_POST['email']) ? $_POST['email'] : '';
   $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
   $address = isset($_POST['address']) ? $_POST['address'] : '';
   $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
   $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
   $session_id = $_COOKIE['PHPSESSID'];
   //检查用户名是否重复
   if(!checkUsernameById($username,$_SESSION['id'])){
        $response = array(
        'state' => 4000,
        'message' => '用户名'.$username.'重复！'
        );
        echo json_encode($response);
        exit();
    }
    //检测邮箱是否重复
    if(!checkEmailById($email,$_SESSION['id'])){
        $response = array(
        'state' => 4001,
        'message' => '邮箱'.$email.'已经被注册了！'
        );
        echo json_encode($response);
        exit();
    }
    //检测电话号码是否重复
    if(!checkPhoneById($phone,$_SESSION['id'])){
        $response = array(
        'state' => 4002,
        'message' => '电话号码'.$phone.'已经被注册了！'
        );
        echo json_encode($response);
        exit();
    }
    modifyUserData($_SESSION['id'],$username,$phone,$email,$address,$gender,$birthday);
    $response = array(
        'state' => 200,
        'message' => "修改成功！"
    );
    echo json_encode($response);
    exit();