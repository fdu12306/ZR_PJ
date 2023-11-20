<?php
    session_start();
    include './mysqlFunc.php';
    include './config.php';
    //获取全部艺术品
    $artworks=getAllArtworks();
    //为每件商品进行推荐评分

    //根据用户访问量进行加分
    usort($artworks,"cmpVisited");
    $maxVisited=$artworks[0]['visited'];
    for($i=0;$i<count($artworks);$i++){
        //根据访问量进行打分，总分5分
        $visitedScore=number_format(5*$artworks[$i]['visited']/$maxVisited,2);
        $artworks[$i]['score']+=$visitedScore;
    }

    //用户已登录，根据用户访问记录进行加分
    $now=time();
    if(isset($_SESSION['logged_in'])&&$_SESSION['logged_in']){
        for($i=0;$i<count($artworks);$i++){
            //根据用户是否访问过该艺术品进行打分
            //获取用户对于艺术品全部的访问记录
            $visitRecorders=getVisitRecorders($_SESSION['id'],$artworks[$i]['id']);
            if(count($visitRecorders)>0){
                for($j=0;$j<count($visitRecorders);$j++){
                    $targetTime=strtotime($visitRecorders[$j]['visitTime']);
                    //访问时间与现在相隔小于1天，加5分
                    if(($now-$targetTime)<86400){
                        $artworks[$i]['score']+=5;
                    }
                    //访问时间与现在相隔小于3天，加4分
                    else if(($now-$targetTime)<259200){
                        $artworks[$i]['score']+=4;
                    }
                    //访问时间与现在相隔小于7天，加3分
                    else if(($now-$targetTime)<604800){
                        $artworks[$i]['score']+=3;
                    }
                    //小于一个月，加2分
                    else if(($now-$targetTime)<2592000){
                        $artworks[$i]['score']+=2;
                    }
                    //其余加1分
                    else{
                        $artworks[$i]['score']+=1;
                    }
                }
            }
        }
    }

    //根据评分进行排序
    usort($artworks,'cmpScore');
    $response=array(
        'state'=>200,
        'data'=>$artworks
    );
    echo json_encode($response);

    //访问量排序函数
    function cmpVisited($a, $b) {
        if ($a['visited'] == $b['visited']) {
            return 0;
        }
        return ($a['visited'] > $b['visited']) ? -1 : 1;
    }

    //评分排序函数
    function cmpScore($a,$b){
        if ($a['score'] == $b['score']) {
            return 0;
        }
        return ($a['score'] > $b['score']) ? -1 : 1;
    }