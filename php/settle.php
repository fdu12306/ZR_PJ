<?php
    session_start();
    include './mysqlFunc.php';
    include './config.php';
    //接收前端发送的信息
    $idStr = isset($_POST['id']) ? $_POST['id'] : '';
    $total = isset($_POST['total']) ? $_POST['total'] : '';
    //判断用户余额是否充足
    $userData=getUserDataById($_SESSION['id']);
    if($total>$userData['pocket']){
        $response = array(
            'state' => 4008,
            'message' => '余额不足！'
         );
         echo json_encode($response);
         exit();
    }
    else{
        //用户扣除余额
        $remaining=$userData['pocket']-$total;
        if(!modifyPocket($_SESSION['id'],$remaining)){
            $response = array(
                'state' => 5001,
                'message' => '修改用户余额失败，请联系系统管理员！'
             );
             echo json_encode($response);
             exit();
        }
        $arr=explode(',',$idStr);
        for($i=0;$i<count($arr);$i++){
            //根据id获得艺术品id
            $shoppingData=getShoppinglistById($arr[$i]);
            $artworkId=$shoppingData['artworkId'];
            $price=$shoppingData['price'];
            //根据艺术品id获得卖方id
            $artworkData=getArtWorkDataById($artworkId);
            $sellerId=$artworkData['ownerId'];
            //卖方余额增加
            $sellerData=getUserDataById($sellerId);
            $pocket=$sellerData['pocket']+$price;
            if(!modifyPocket($sellerId,$pocket)){
                $response = array(
                    'state' => 5001,
                    'message' => '修改用户余额失败，请联系系统管理员！'
                    );
                    echo json_encode($response);
                    exit();
            }
            //艺术品状态改为已售出
            $soldTime=date('Y-m-d H:i:s');
            if(!modifySoldState($artworkId,$soldTime,1)){
                $response = array(
                    'state' => 5001,
                    'message' => '修改艺术品状态出错，请联系系统管理员！'
                    );
                    echo json_encode($response);
                    exit();
            }
            //将购物车中艺术品信息改为已售出
            if(!modifySoldStateInShoppinglist($artworkId,1)){
                $response = array(
                    'state' => 5001,
                    'message' => '修改艺术品状态出错，请联系系统管理员！'
                    );
                    echo json_encode($response);
                    exit();
            }
            //添加到已下单中
            if(!insertOrders($_SESSION['id'],$shoppingData['artworkId'],$shoppingData['workname'],$shoppingData['price'],$soldTime)){
                $response = array(
                    'state' => 5000,
                    'message' => '添加已下单出错，请联系系统管理员！'
                    );
                    echo json_encode($response);
                    exit();
            }
            //从购物车中删除
            if(!deleteShoppinglist($arr[$i])){
                $response = array(
                    'state' => 5003,
                    'message' => '删除购物车信息，请联系系统管理员！'
                    );
                    echo json_encode($response);
                    exit();
            }
        }
        $response = array(
            'state' => 200,
            'message' => '结算成功！'
            );
            echo json_encode($response);
            exit();
    }