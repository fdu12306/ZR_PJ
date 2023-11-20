<?php
    $coon=mysqli_connect('localhost','root','1234','pjdatabase') or die('连接数据库失败');
   // var_dump($coon);
   //设置字符集
   $r=mysqli_set_charset($coon,'utf8mb4');
   $sql="Select * from user";
   $result=mysqli_query($coon,$sql);
   $row=mysqli_fetch_assoc($result);
   var_dump($row['username']);