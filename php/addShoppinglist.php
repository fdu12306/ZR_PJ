<?php
     session_start();
     include './mysqlFunc.php';
     include './config.php';
     //获取艺术品id
     $artworkId=isset($_POST['artworkId'])?$_POST['artworkId']:'';
      //用户已登录
      if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']){
        //艺术品已经在购物车中
        if(!selectShoppinglist($_SESSION['id'],$artworkId)){
            $response=array(
                'logged_in'=>true,
                'state'=>4007,
                'message'=>"该艺术品已在购物车中！"
            );
            echo json_encode($response);
            exit();
        }
        //添加进入购物车中
        else{
            //获取艺术品
            $artwork=getArtWorkDataById($artworkId);
            //加入购物车
            if(!insertShoppinglist($_SESSION['id'],$artworkId,$artwork['workname'],$artwork['author'],$artwork['price'],$artwork['introduction'],$artwork['imagePath'])){
                $response=array(
                    'logged_in'=>true,
                    'state'=>5000,
                    'message'=>"数据导入数据库失败，请联系系统管理员！"
                );
                echo json_encode($response);
                exit();
            }
            else{
                $response=array(
                    'logged_in'=>true,
                    'state'=>200,
                    'message'=>"加入购物车成功！"
                );
                echo json_encode($response);
                exit();
            }
        }
    }
    //未登录
    else{
        $response=array(
            'logged_in'=>false
        );
        echo json_encode($response);
        exit();
    }
