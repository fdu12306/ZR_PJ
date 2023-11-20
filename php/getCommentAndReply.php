<?php
    session_start();
    include './mysqlFunc.php';
    include './config.php';
    //获取艺术品id
    $artworkId = isset($_POST['artworkId']) ? $_POST['artworkId'] : '';
    //根据艺术品id获取comment和reply
    $comment=getCommentByArtworkId($artworkId);
    $reply=getReplyByArtworkId($artworkId);
    if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']){
        for($i=0;$i<count($comment);$i++){
            //查询commentLikes
            if(queryCommentLikes($comment[$i]['id'],$_SESSION['id'])>0){
                $comment[$i]['likeState']=1;
            }
            if($comment[$i]['userId']==$_SESSION['id']&&$comment[$i]['deleteState']==0){
                $comment[$i]['deleteState']=1;
            }
        }
        for($j=0;$j<count($reply);$j++){
            if(queryReplyLikes($reply[$j]['id'],$_SESSION['id'])>0){
                $reply[$j]['likeState']=1;
            }
            if($reply[$j]['userId']==$_SESSION['id']&&$reply[$j]['deleteState']==0){
                $reply[$j]['deleteState']=1;
            }
        }
    }
    $response=array(
        'state'=>200,
        'comment'=>$comment,
        'reply'=>$reply
    );
    echo json_encode($response);