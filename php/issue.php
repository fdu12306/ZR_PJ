<?php
     session_start();
     include './mysqlFunc.php';
     include './config.php';
     //接收前端发送的注册信息
     $workname = isset($_POST['workname']) ? $_POST['workname'] : '';
     $author = isset($_POST['author']) ? $_POST['author'] : '';
     $width = isset($_POST['width']) ? $_POST['width'] : '';
     $height = isset($_POST['height']) ? $_POST['height'] : '';
     $price = isset($_POST['price']) ? $_POST['price'] : '';
     $introduction = isset($_POST['introduction']) ? $_POST['introduction'] : '';
     $year = isset($_POST['year']) ? $_POST['year'] : '';
     $style = isset($_POST['style']) ? $_POST['style'] : '';
     $session_id = $_COOKIE['PHPSESSID'];
     //存储艺术品图片
     $image=$_FILES['image'];
     $ext=pathinfo($image['name'],PATHINFO_EXTENSION);
     $filename=uniqid().'.'.$ext;
     //图片存储路径
     $dir="./upload/";
     $upload_dir='http://localhost:83/';
     move_uploaded_file($image['tmp_name'],$dir.$filename);
     $imagePath=$upload_dir.$filename;
     $issueTime=date('Y-m-d H:i:s');
     //将对应的信息存入数据库
     if(!insertArtwork($_SESSION['id'],$workname,$author,$year,$width,$height,$style,$price,$introduction,$issueTime,$imagePath)){
        $response = array(
            'state' => 5000,
            'message' => "数据导入数据库失败，请联系系统管理员！"
        );
        echo json_encode($response);
        exit();
     }
     $response = array(
        'state' => 200,
        'message' => "发布成功！"
    );
    echo json_encode($response);



