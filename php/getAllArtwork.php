<?php
    include './mysqlFunc.php';
    include './config.php';
    $allArtworks=getAllArtworks();
    $response=array(
        'state'=>200,
        'data'=>$allArtworks
    );
    echo json_encode($response);