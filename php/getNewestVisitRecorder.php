<?php
session_start();
    include './mysqlFunc.php';
    include './config.php';
    $newestVisitRecorder=getNewestVisitRecorderLimit($_SESSION['id']);
    $response=array(
        'state'=>200,
        'data'=>$newestVisitRecorder
    );
    echo json_encode($response);