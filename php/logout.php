<?php
    session_start();
    include './config.php';
    // 判断用户是否登录
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
        // 注销登录状态
        session_unset();
        session_destroy();
        $response = array(
            'logged_out' => true
        );
    } 
    else {
        $response = array(
            'logged_out' => false
        );
    }
    echo json_encode($response);
?>