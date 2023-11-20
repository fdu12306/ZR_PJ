<?php
   session_start();
   include './mysqlFunc.php';
   include './config.php';
   //接收前端发送的注册信息
   $username = isset($_POST['username']) ? $_POST['username'] : '';
   $password = isset($_POST['password']) ? $_POST['password'] : '';
   $email = isset($_POST['email']) ? $_POST['email'] : '';
   $phone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
   $address = isset($_POST['address']) ? $_POST['address'] : '';
   $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
   $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
   $captcha = isset($_POST['captcha']) ? $_POST['captcha'] : '';
   $session_id = $_COOKIE['PHPSESSID'];
    // 判断验证码是否正确
    if($captcha!=$_SESSION['captcha']){
         $response = array(
            'state' => 4005,
            'message' => '验证码不正确！'
         );
         echo json_encode($response);
         exit();
   }
   //检查用户名是否重复
   if(!checkUsername($username)){
      $response = array(
         'state' => 4000,
         'message' => '用户名'.$username.'重复！'
     );
     echo json_encode($response);
     exit();
   }

   //检测邮箱是否重复
   if(!checkEmail($email)){
      $response = array(
         'state' => 4001,
         'message' => '邮箱'.$email.'已经被注册了！'
     );
     echo json_encode($response);
     exit();
   }

   //检测电话号码是否重复
   if(!checkPhone($phone)){
      $response = array(
         'state' => 4002,
         'message' => '电话号码'.$phone.'已经被注册了！'
     );
     echo json_encode($response);
     exit();
   }

   //用哈希加盐对密码进行加密
   //生成随机盐
   $salt=bin2hex(random_bytes(16));
   $hashed_password=hash('sha256',$password.$salt);
   if(!insertUserData($username,$hashed_password,$phone,$email,$address,$gender,$birthday,$salt)){
      $response = array(
         'state' => 5000,
         'message' => '用户数据插入数据库出现问题，请联系系统管理员！'
     );
     echo json_encode($response);
     exit();
   }
   $response = array(
      'state' => 200,
      'message' => '注册成功！'
  );
  echo json_encode($response);

   
  
