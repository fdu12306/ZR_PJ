<?php
     session_start();
     include './mysqlFunc.php';
     include './config.php';
     //获取艺术品id
     $artworkId=isset($_POST['artworkId'])?$_POST['artworkId']:'';
     //判断用户是否登录
     if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']){
        //判断用户是否有访问记录
        $num=getVisitRecorderTotal($_SESSION['id'],$artworkId);
        //无访问记录
        if($num==0){
            //修改艺术品访问量
            $artwork=getArtWorkDataById($artworkId);
            $visited=$artwork['visited']+1;
            if(!updateArtworkVisited($artworkId,$visited)){
                $response=array(
                    'state'=>5002,
                    'message'=>'修改艺术品数据异常，请联系系统管理员！'
                );
                echo json_encode($response);
                exit();
            }
            //添加访问记录
            $visitTime=date('Y-m-d H:i:s');
            if(!insertVisitRecorder($_SESSION['id'],$artworkId,$artwork['workname'],$visitTime)){
                $response=array(
                    'state'=>5000,
                    'message'=>'添加访问记录数据异常，请联系系统管理员！'
                );
                echo json_encode($response);
                exit();
            }
            $response=array(
                'state'=>200
            );
            echo json_encode($response);
        }
        //有访问记录，判断两次访问记录时间间隔是否小于半小时
        else{
            //获取用户最新的访问记录
            $newsetVisitRecorder=getNewestVisitRecorder($_SESSION['id'],$artworkId);
            $now=date('Y-m-d H:i:s');
            // 将日期时间字符串转换为Unix时间戳
            $timestamp1 = strtotime($now);
            $timestamp2 = strtotime($newsetVisitRecorder['visitTime']);
            // 计算两个时间戳之间的差值
            $interval = abs($timestamp1 - $timestamp2);
            // 两次时间间隔大于半小时则产生访问记录
            if ($interval >= 1800){
                //修改艺术品访问量
                $artwork=getArtWorkDataById($artworkId);
                $visited=$artwork['visited']+1;
                if(!updateArtworkVisited($artworkId,$visited)){
                    $response=array(
                        'state'=>5002,
                        'message'=>'修改艺术品数据异常，请联系系统管理员！'
                    );
                    echo json_encode($response);
                    exit();
                }
                //添加访问记录
                if(!insertVisitRecorder($_SESSION['id'],$artworkId,$artwork['workname'],$now)){
                    $response=array(
                        'state'=>5000,
                        'message'=>'添加访问记录数据异常，请联系系统管理员！'
                    );
                    echo json_encode($response);
                    exit();
                }
                $response=array(
                    'state'=>200
                );
                echo json_encode($response);
                exit();
            }
            else{
                $response=array(
                    'state'=>200
                );
                echo json_encode($response);
                exit();
            }
        }
    }
    else{
        $response=array(
            'state'=>200
        );
        echo json_encode($response);
    }