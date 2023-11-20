<?php
   session_start();
   include './mysqlFunc.php';
   include './config.php';
   //接收前端发送的注册信息
   $olderPassword = isset($_POST['olderPassword']) ? $_POST['olderPassword'] : '';
   $newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';
   $session_id = $_COOKIE['PHPSESSID'];
   //验证原密码是否正确
   $userData=getUserDataById($_SESSION['id']);
   // 哈希加盐处理密码
   $salt = $userData['salt']; // 随机生成一个盐值
   $hashed_password = hash('sha256', $olderPassword . $salt); // 将密码和盐值拼接后进行哈希加密
   if($hashed_password!=$userData['password']){
       $response = array(
           'state' => 4004,
           'message' => '原密码不正确！'
       );
       echo json_encode($response);
       exit();
   }
   else{
        //插入新密码
        //用哈希加盐对密码进行加密
        //生成随机盐
        $salt=bin2hex(random_bytes(16));
        $hashed_password=hash('sha256',$newPassword.$salt);
        if(!modifyPassword($_SESSION['id'],$hashed_password,$salt)){
            $response = array(
                'state' => 5002,
                'message' => "修改失败，请联系系统管理员！"
            );
            echo json_encode($response);
            exit();
        }
        $response = array(
            'state' => 200,
            'message' => "修改成功！"
            );
        echo json_encode($response);
        exit();
   }