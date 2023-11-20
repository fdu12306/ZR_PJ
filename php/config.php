<?php
    //成功状态 200
    //用户名重复 4000
    //邮箱重复 4001
    //电话号码重复 4002
    //用户名不正确 4003
    //密码不正确 4004
    //验证码不正确 4005
    //用户未登录 4006
    //已在购物车中 4007
    //余额不足 4008
    //数据插入数据库出错 5000
    //获取数据异常 5001
    //修改数据异常 5002
    //删除数据异常 5003


    
    //跨域
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    header('Access-Control-Allow-Origin: http://localhost:82');
    header('Access-Control-Allow-Credentials: true');