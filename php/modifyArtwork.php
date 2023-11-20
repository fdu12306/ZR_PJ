<?php
     session_start();
     include './mysqlFunc.php';
     include './config.php';
     //接收前端发送的艺术品信息
     $id=isset($_POST['id'])?$_POST['id']:'';
     $workname = isset($_POST['workname']) ? $_POST['workname'] : '';
     $author = isset($_POST['author']) ? $_POST['author'] : '';
     $width = isset($_POST['width']) ? $_POST['width'] : '';
     $height = isset($_POST['height']) ? $_POST['height'] : '';
     $price = isset($_POST['price']) ? $_POST['price'] : '';
     $introduction = isset($_POST['introduction']) ? $_POST['introduction'] : '';
     $year = isset($_POST['year']) ? $_POST['year'] : '';
     $style = isset($_POST['style']) ? $_POST['style'] : '';
     $session_id = $_COOKIE['PHPSESSID'];
     $fixTime=date('Y-m-d H:i:s');
     //艺术品图片修改
     if(!empty($_FILES['image']['tmp_name'])){
        //删除原有图片
        $dir="./upload/";
        $artwork=getArtWorkDataById($id);
        $imgName=basename($artwork['imagePath']);
        $imgPath=$dir.$imgName;
        unlink($imgPath);
        //添加图片
        $image=$_FILES['image'];
        $ext=pathinfo($image['name'],PATHINFO_EXTENSION);
        $filename=uniqid().'.'.$ext;
        $upload_dir='http://localhost:83/';
        move_uploaded_file($image['tmp_name'],$dir.$filename);
        $imagePath=$upload_dir.$filename;
        //修改数据库中艺术品信息
        if(!modifyArtwork1($id,$workname,$author,$year,$width,$height,$style,$price,$introduction,$fixTime,$imagePath)){
            $response = array(
                    'state' => 5002,
                    'message' => "修改失败，请联系系统管理员！"
                );
            echo json_encode($response);
            exit();
        }
        else{
            //修改购物车中艺术品信息
            modifyShoppinglist1($id,$workname,$author,$price,$introduction,$imagePath);
             $response = array(
                'state' => 200,
                'message' => "修改成功！"
            );
            echo json_encode($response);
            exit();
        }
     }
     //艺术品图片未修改
     else{
        if(!modifyArtwork2($id,$workname,$author,$year,$width,$height,$style,$price,$introduction,$fixTime)){
            $response = array(
                    'state' => 5002,
                    'message' => "修改失败，请联系系统管理员！"
                );
                echo json_encode($response);
                exit();
        }
        else{
            modifyShoppinglist2($id,$workname,$author,$price,$introduction);
             $response = array(
                'state' => 200,
                'message' => "修改成功！"
            );
            echo json_encode($response);
            exit();
        }
     }