<?php
    session_start();
    Header("Content-type:image/PNG");//说明PNG格式
    $image=imagecreate(120,40);//创建画布 120*40
    $backgroungcolor=imagecolorallocate($image,245,245,245);//设置背景颜色
    //生成随机字符串
    $length=4;
    $code='';
    $chars='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for($i=0;$i<$length;$i++){
        $code .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    //将随机字符串存储到session中
    $_SESSION['captcha']=$code;
    //绘制图像
    imagefill($image,0,0,$backgroungcolor);
    for($j=0;$j<$length;$j++){
        $font=imagecolorallocate($image,rand(100,255),rand(0,100),rand(100,255));//随机设置颜色
        imagestring($image,20,25+$j*20,15,$code[$j],$font);
    }
    for($k=0;$k<200;$k++){
        $randcolor=imagecolorallocate($image,rand(0,255),rand(0,255),rand(0,255));
        imagesetpixel($image,rand()%150,rand()%150,$randcolor);
    }
    imagepng($image);
    imagedestroy($image);

?>