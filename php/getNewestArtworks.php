<?php
    include './mysqlFunc.php';
    include './config.php';
    $newestArtworks=getNewestArtworks();
    $response=array(
        'state'=>200,
        'data'=>$newestArtworks
    );
    echo json_encode($response);