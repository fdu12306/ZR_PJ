<?php
    include './mysqlModel.php';
    //检查用户名是否重复函数 4000
    // function checkUsername($username){
    //     $sql="select * from user where username='$username'";
    //     $result=total($sql);
    //     if($result>0){
    //         return false;
    //     }
    //     return true;
    // }
    function checkUsername($username) {
        $sql = "SELECT * FROM user WHERE username = ?";
        $params = array($username);
        $result = total($sql, $params);
        return ($result == 0);
    }

    //检测邮箱是否重复 4001
    // function checkEmail($email){
    //     $sql="select * from user where email='$email'";
    //     $result=total($sql);
    //     if($result>0){
    //         return false;
    //     }
    //     return true;
    // }
    function checkEmail($email) {
        $sql = "SELECT * FROM user WHERE email = ?";
        $params = array($email);
        $result = total($sql, $params);
        return ($result == 0);
    }

    //检测手机号是否重复 4002
    // function checkPhone($phone){
    //     $sql="select * from user where phone='$phone'";
    //     $result=total($sql);
    //     if($result>0){
    //         return false;
    //     }
    //     return true;
    // }
    function checkPhone($phone) {
        $sql = "SELECT * FROM user WHERE phone = ?";
        $params = array($phone);
        $result = total($sql, $params);
        return ($result == 0);
    }

    //根据用户名获取用户数据 4003
    // function getUserDataByUserName($username){
    //     $sql="select * from user where username='$username'";
    //     return get($sql);
    // }
    function getUserDataByUserName($username) {
        $sql = "SELECT * FROM user WHERE username = ?";
        $params = array($username);
        return get($sql, $params);
    }

    //将用户数据插入数据库 5000
    // function insertUserData($username,$password,$phone,$email,$address,$gender,$birthday,$salt){
    //     $sql="insert into user (username,password,phone,email,address,gender,birthday,pocket,salt) values ('$username','$password','$phone','$email','$address','$gender','$birthday',0.00,'$salt')";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function insertUserData($username, $password, $phone, $email, $address, $gender, $birthday, $salt) {
        $sql = "INSERT INTO user (username, password, phone, email, address, gender, birthday, pocket, salt) VALUES (?, ?, ?, ?, ?, ?, ?, 0.00, ?)";
        $params = array($username, $password, $phone, $email, $address, $gender, $birthday, $salt);
        $result = dml($sql, $params);
        return ($result > 0);
    }

    //根据用户id获取用户数据
    // function getUserDataById($id){
    //     $sql="select * from user where id='$id'";
    //     return get($sql);
    // }
    function getUserDataById($id) {
        $sql = "SELECT * FROM user WHERE id = ?";
        $params = array($id);
        return get($sql, $params);
    }

    //根据用户id充值
    // function recharge($id,$amount){
    //     $sql1="select pocket from user where id='$id'";
    //     $pocket=get($sql1);
    //     $pocket=intval($pocket['pocket']);
    //     $sum=$pocket+$amount;
    //     $sql2="update user set pocket='$sum' where id='$id'";
    //     $result=dml($sql2);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function recharge($id, $amount){
        $sql1 = "SELECT pocket FROM user WHERE id= ?";
        $params1 = array($id);
        $pocket = get($sql1, $params1);
        $pocketVal = floatval($pocket['pocket']);
        $sum = $pocketVal + $amount;
        $sql2 = "UPDATE user SET pocket= ? WHERE id= ?";
        $params2 = array($sum, $id);
        $result = dml($sql2, $params2);
        return ($result > 0);
    }

    //将商品信息导入数据库
    // function insertArtwork($ownerId,$workname,$author,$year,$width,$height,$style,$price,$introduction,$issueTime,$imagePath){
    //     $sql1="insert into artwork (ownerId,workname,author,year,width,height,style,price,introduction,visited,soldState,issueTime,imagePath,score) values ('$ownerId','$workname','$author','$year','$width','$height','$style','$price','$introduction',0,0,'$issueTime','$imagePath',0.00)";
    //     $result=dml($sql1);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function insertArtwork($ownerId, $workname, $author, $year, $width, $height, $style, $price, $introduction, $issueTime, $imagePath) {
        $sql = "INSERT INTO artwork (ownerId, workname, author, year, width, height, style, price, introduction, visited, soldState, issueTime, imagePath, score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0, ?, ?, 0.00)";
        $params = array($ownerId, $workname, $author, $year, $width, $height, $style, $price, $introduction, $issueTime, $imagePath);
        $result = dml($sql, $params);
        return ($result > 0);
    }

     //根据艺术品id获取艺术品数据
    //  function getArtWorkDataById($id){
    //     $sql="select * from artwork where id='$id'";
    //     return get($sql);
    // }
    function getArtWorkDataById($id) {
        $sql = "SELECT * FROM artwork WHERE id= ?";
        $params = array($id);
        return get($sql, $params);
    }

    //获取已发布的艺术品
    // function getIssuedArtwork($ownerId){
    //     $sql="select * from artwork where ownerId='$ownerId' and soldState=0 ";
    //     return select($sql);
    // }
    function getIssuedArtwork($ownerId) {
        $sql = "SELECT * FROM artwork WHERE ownerId = ? AND soldState = 0";
        $params = array($ownerId);
        return select($sql, $params);
    }
    
    
    //获取已出售的艺术品
    // function getSoldArtwork($ownerId){
    //     $sql="select * from artwork where ownerId='$ownerId' and soldState=1 ";
    //     return select($sql);
    // }
    function getSoldArtwork($ownerId) {
        $sql = "SELECT * FROM artwork WHERE ownerId= ? AND soldState=1";
        $params = array($ownerId);
        return select($sql, $params);
    }
    

    //获取已下单的艺术品
    // function getOrderArtwork($userId){
    //     $sql="select * from orders where userId='$userId'";
    //     return select($sql);
    // }
    function getOrderArtwork($userId) {
        $sql = "SELECT * FROM orders WHERE userId= ?";
        $params = array($userId);
        return select($sql, $params);
    }
    


    //删除艺术品
    // function deleteArtwork($id){
    //     $sql="delete from artwork where id='$id'";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function deleteArtwork($id){
        $sql = "DELETE FROM artwork WHERE id=?";
        $params=array($id);
        $result = dml($sql, $params);
        return ($result>0);
    }


    //修改艺术品信息，包括图片路径
    // function modifyArtwork1($id,$workname,$author,$year,$width,$height,$style,$price,$introduction,$fixTime,$imagePath){
    //     $sql="update artwork set workname='$workname',author='$author',year='$year',width='$width',height='$height',style='$style',price='$price',introduction='$introduction',fixTime='$fixTime',imagePath='$imagePath' where id='$id' ";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function modifyArtwork1($id, $workname, $author, $year, $width, $height, $style, $price, $introduction, $fixTime, $imagePath) {
        $sql = "UPDATE artwork SET workname=?, author=?, year=?, width=?, height=?, style=?, price=?, introduction=?, fixTime=?, imagePath=? WHERE id=?";
        $params = array($workname, $author, $year, $width, $height, $style, $price, $introduction, $fixTime, $imagePath, $id);
        $result = dml($sql, $params);
        return ($result>0);
    }
    

     //修改艺术品信息，不包括图片路径
    //  function modifyArtwork2($id,$workname,$author,$year,$width,$height,$style,$price,$introduction,$fixTime){
    //     $sql="update artwork set workname='$workname',author='$author',year='$year',width='$width',height='$height',style='$style',price='$price',introduction='$introduction',fixTime='$fixTime' where id='$id' ";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function modifyArtwork2($id, $workname, $author, $year, $width, $height, $style, $price, $introduction, $fixTime) {
        $sql = "UPDATE artwork SET workname=?, author=?, year=?, width=?, height=?, style=?, price=?, introduction=?, fixTime=? WHERE id=?";
        $params = array($workname, $author, $year, $width, $height, $style, $price, $introduction, $fixTime, $id);
        $result = dml($sql, $params);
        return ($result>0);
    }
    

    //修改购物车信息，包括图片路径
    // function modifyShoppinglist1($artworkId,$workname,$author,$price,$introduction,$imagePath){
    //     $sql="update shoppinglist set workname='$workname',author='$author',price='$price',introduction='$introduction',imagePath='$imagePath' where artworkId='$artworkId' ";
    //     dml($sql);
    // }
    function modifyShoppinglist1($artworkId, $workname, $author, $price, $introduction, $imagePath) {
        $sql = "UPDATE shoppinglist SET workname=?, author=?, price=?, introduction=?, imagePath=? WHERE artworkId=?";
        $params = array($workname, $author, $price, $introduction, $imagePath, $artworkId);
        dml($sql, $params);
    }
    

     //修改购物车信息，不包括图片路径
    //  function modifyShoppinglist2($artworkId,$workname,$author,$price,$introduction){
    //     $sql="update shoppinglist set workname='$workname',author='$author',price='$price',introduction='$introduction' where artworkId='$artworkId' ";
    //     dml($sql);
    // }
    function modifyShoppinglist2($artworkId, $workname, $author, $price, $introduction) {
        $sql = "UPDATE shoppinglist SET workname=?, author=?, price=?, introduction=? WHERE artworkId=?";
        $params = array($workname, $author, $price, $introduction, $artworkId);
        dml($sql, $params);
    }
    

    //获取购物车
    // function getShoppinglist($userId){
    //     $sql="select * from shoppinglist where userId='$userId' ";
    //     return select($sql);
    // }
    function getShoppinglist($userId) {
        $sql = "SELECT * FROM shoppinglist WHERE userId = ?";
        $params = array($userId);
        return select($sql, $params);
    }    

    //移出购物车
    // function deleteShoppinglist($id){
    //     $sql="delete from shoppinglist where id='$id'";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function deleteShoppinglist($id) {
        $sql = "DELETE FROM shoppinglist WHERE id=?";
        $params = array($id);
        $result = dml($sql, $params);
        return ($result>0);
    }
    

    //根据艺术品id和用户id查询购物车
    // function selectShoppinglist($userId,$artworkId){
    //     $sql="select * from shoppinglist where userId='$userId' and artworkId='$artworkId'";
    //     $result=total($sql);
    //     if($result>0){
    //         return false;
    //     }
    //     return true;
    // }
    function selectShoppinglist($userId, $artworkId) {
        $sql = "SELECT * FROM shoppinglist WHERE userId=? AND artworkId=?";
        $params = array($userId, $artworkId);
        $result = total($sql, $params);
        if ($result > 0) {
            return false;
        }
        return true;
    }
    

    //添加进入购物车中
    // function insertShoppinglist($userId,$artworkId,$workname,$author,$price,$introduction,$imagePath){
    //     $sql="insert into shoppinglist (userId,artworkId,workname,author,price,introduction,imagePath,businessState) values ('$userId','$artworkId','$workname','$author','$price','$introduction','$imagePath',0)";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function insertShoppinglist($userId, $artworkId, $workname, $author, $price, $introduction, $imagePath) {
        $sql = "INSERT INTO shoppinglist (userId, artworkId, workname, author, price, introduction, imagePath, businessState) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        $params = array($userId, $artworkId, $workname, $author, $price, $introduction, $imagePath);
        $result = dml($sql, $params);
        return ($result>0);
    }
    

    //修改艺术品状态
    // function modifyBusinessState($artworkId,$businessState){
    //     $sql="update shoppinglist set businessState='$businessState' where artworkId='$artworkId' ";
    //     dml($sql);
    // }
    function modifyBusinessState($artworkId, $businessState) {
        $sql = "UPDATE shoppinglist SET businessState=? WHERE artworkId=?";
        $params = array($businessState, $artworkId);
        dml($sql, $params);
    }
    

    //修改余额
    // function modifyPocket($id,$pocket){
    //     $sql="update user set pocket='$pocket' where id='$id' ";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function modifyPocket($id, $pocket) {
        $sql = "UPDATE user SET pocket=? WHERE id=?";
        $params = array($pocket, $id);
        $result = dml($sql, $params);
        return ($result>0);
    }
    

    //根据id获取购物车数据
    // function getShoppinglistById($id){
    //     $sql="select * from shoppinglist where id='$id' ";
    //     return get($sql);
    // }
    function getShoppinglistById($id) {
        $sql = "SELECT * FROM shoppinglist WHERE id = ?";
        $params = array($id);
        return get($sql, $params);
    }    

    //修改艺术品出售状态
    // function modifySoldState($id,$soldTime,$soldState){
    //     $sql="update artwork set soldState='$soldState',soldTime='$soldTime' where id='$id' ";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function modifySoldState($id, $soldTime, $soldState) {
        $sql = "UPDATE artwork SET soldState=?, soldTime=? WHERE id=?";
        $params = array($soldState, $soldTime, $id);
        $result = dml($sql, $params);
        return ($result>0);
    }
    

    //获取评论
    // function getCommentByArtworkId($artworkId){
    //     $sql="select * from comment where artworkId='$artworkId' ";
    //     return select($sql);
    // }
    function getCommentByArtworkId($artworkId) {
        $sql = "SELECT * FROM comment WHERE artworkId=?";
        $params = array($artworkId);
        return select($sql, $params);
    }
    

    //获取评论回复
    // function getReplyByArtworkId($artworkId){
    //     $sql="select * from reply where artworkId='$artworkId' ";
    //     return select($sql);
    // }
    function getReplyByArtworkId($artworkId) {
        $sql = "SELECT * FROM reply WHERE artworkId=?";
        $params = array($artworkId);
        return select($sql, $params);
    }
    

    //插入评论
    // function insertComment($userId,$artworkId,$username,$content,$issueTime,$likes,$likeState,$deleteState){
    //     $sql="insert into comment (userId,artworkId,username,content,issueTime,likes,likeState,deleteState) values ('$userId','$artworkId','$username','$content','$issueTime','$likes','$likeState','$deleteState')";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function insertComment($userId, $artworkId, $username, $content, $issueTime, $likes, $likeState, $deleteState) {
        $sql = "INSERT INTO comment (userId, artworkId, username, content, issueTime, likes, likeState, deleteState) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = array($userId, $artworkId, $username, $content, $issueTime, $likes, $likeState, $deleteState);
        $result = dml($sql, $params);
        return ($result>0);
    }
    

    //插入回复
    // function insertReply($commentId,$artworkId,$userId,$fromName,$toName,$content,$issueTime,$likes,$likeState,$deleteState){
    //     $sql="insert into reply (commentId,artworkId,userId,fromName,toName,content,issueTime,likes,likeState,deleteState) values ('$commentId','$artworkId','$userId','$fromName','$toName','$content','$issueTime','$likes','$likeState','$deleteState')";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function insertReply($commentId, $artworkId, $userId, $fromName, $toName, $content, $issueTime, $likes, $likeState, $deleteState) {
        $sql = "INSERT INTO reply (commentId, artworkId, userId, fromName, toName, content, issueTime, likes, likeState, deleteState) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = array($commentId, $artworkId, $userId, $fromName, $toName, $content, $issueTime, $likes, $likeState, $deleteState);
        $result = dml($sql, $params);
        return ($result>0);
    }
    

    //修改评论点赞数
    // function modifyCommentLikes($id,$likes){
    //     $sql="update comment set likes='$likes' where id='$id' ";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function modifyCommentLikes($id, $likes) {
        $sql = "UPDATE comment SET likes=? WHERE id=?";
        $params = array($likes, $id);
        $result = dml($sql, $params);
        return ($result>0);
    }
    

     //修改回复点赞数
    //  function modifyReplyLikes($id,$likes){
    //     $sql="update reply set likes='$likes' where id='$id' ";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function modifyReplyLikes($id, $likes) {
        $sql = "UPDATE reply SET likes=? WHERE id=?";
        $params = array($likes, $id);
        $result = dml($sql, $params);
        return ($result>0);
    }
    

    //插入评论点赞
    // function insertCommentLikes($commentId,$userId){
    //     $sql="insert into commentlikes (commentId,userId) values ('$commentId','$userId')";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function insertCommentLikes($commentId,$userId){
        $sql="insert into commentlikes (commentId,userId) values (?,?)";
        $params=array($commentId,$userId);
        $result=dml($sql,$params);
        return ($result>0);
    }

    //删除评论点赞
    // function deleteCommentLikes($commentId,$userId){
    //     $sql="delete from commentlikes where commentId='$commentId' and userId='$userId'";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function deleteCommentLikes($commentId, $userId) {
        $sql = "DELETE FROM commentlikes WHERE commentId=? AND userId=?";
        $params = array($commentId, $userId);
        $result = dml($sql, $params);
        return ($result > 0);
    }    


    //插入评论回复点赞
    // function insertReplyLikes($replyId,$userId){
    //     $sql="insert into replylikes (replyId,userId) values ('$replyId','$userId')";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function insertReplyLikes($replyId, $userId) {
        $sql = "INSERT INTO replylikes (replyId, userId) VALUES (?, ?)";
        $params = array($replyId, $userId);
        $result = dml($sql, $params);
        return ($result > 0);
    }
    

    //删除评论回复点赞
    // function deleteReplyLikes($replyId,$userId){
    //     $sql="delete from replylikes where replyId='$replyId' and userId='$userId'";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function deleteReplyLikes($replyId, $userId) {
        $sql = "DELETE FROM replylikes WHERE replyId=? AND userId=?";
        $params = array($replyId, $userId);
        $result = dml($sql, $params);
        return ($result > 0);
    }
    

    //查询commentLikes
    // function queryCommentLikes($commentId,$userId){
    //     $sql="select * from commentLikes where commentId='$commentId' and userId='$userId'";
    //     return total($sql);
    // }
    function queryCommentLikes($commentId, $userId) {
        $sql = "SELECT * FROM commentlikes WHERE commentId=? AND userId=?";
        $params = array($commentId, $userId);
        return total($sql, $params);
    }
    

    //查询replyLikes
    // function queryReplyLikes($replyId,$userId){
    //     $sql="select * from replyLikes where replyId='$replyId' and userId='$userId'";
    //     return total($sql);
    // }
    function queryReplyLikes($replyId, $userId) {
        $sql = "SELECT * FROM replylikes WHERE replyId=? AND userId=?";
        $params = array($replyId, $userId);
        return total($sql, $params);
    }
    

    //删除评论
    // function deleteComment($id){
    //     $sql="update comment set deleteState=-1 where id='$id'";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function deleteComment($id) {
        $sql = "UPDATE comment SET deleteState=-1 WHERE id=?";
        $params = array($id);
        $result = dml($sql, $params);
        return ($result > 0);
    }
    

    //删除回复
    // function deleteReply($id){
    //     $sql="update reply set deleteState=-1 where id='$id'";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function deleteReply($id) {
        $sql = "UPDATE reply SET deleteState=-1 WHERE id=?";
        $params = array($id);
        $result = dml($sql, $params);
        return ($result > 0);
    }

    //修改用户信息
    // function modifyUserData($id,$username,$phone,$email,$address,$gender,$birthday){
    //     $sql="update user set username='$username',phone='$phone',email='$email',address='$address',gender='$gender',birthday='$birthday' where id='$id' ";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function modifyUserData($id, $username, $phone, $email, $address, $gender, $birthday) {
        $sql = "UPDATE user SET username=?, phone=?, email=?, address=?, gender=?, birthday=? WHERE id=?";
        $params = array($username, $phone, $email, $address, $gender, $birthday, $id);
        $result = dml($sql, $params);
        return ($result > 0);
    }
    

    //修改密码
    // function modifyPassword($id,$password,$salt){
    //     $sql="update user set password='$password',salt='$salt' where id='$id' ";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function modifyPassword($id, $password, $salt) {
        $sql = "UPDATE user SET password=?, salt=? WHERE id=?";
        $params = array($password, $salt, $id);
        $result = dml($sql, $params);
        return ($result > 0);
    }    

    //检查用户名是否重复函数 4000
    // function checkUsernameById($username,$id){
    //     $sql="select * from user where username='$username' and id!='$id' ";
    //     $result=total($sql);
    //     if($result>0){
    //         return false;
    //     }
    //     return true;
    // }
    function checkUsernameById($username, $id) {
        $sql = "SELECT * FROM user WHERE username=? AND id!=?";
        $params = array($username, $id);
        $result = total($sql, $params);
        return ($result == 0);
    }
    

    //检测邮箱是否重复 4001
    // function checkEmailById($email,$id){
    //     $sql="select * from user where email='$email'and id!='$id' ";
    //     $result=total($sql);
    //     if($result>0){
    //         return false;
    //     }
    //     return true;
    // }
    function checkEmailById($email, $id) {
        $sql = "SELECT * FROM user WHERE email=? AND id!=?";
        $params = array($email, $id);
        $result = total($sql, $params);
        return ($result == 0);
    }
    

    //检测手机号是否重复 4002
    // function checkPhoneById($phone,$id){
    //     $sql="select * from user where phone='$phone' and id!='$id' ";
    //     $result=total($sql);
    //     if($result>0){
    //         return false;
    //     }
    //     return true;
    // }
    function checkPhoneById($phone, $id) {
        $sql = "SELECT * FROM user WHERE phone=? AND id!=?";
        $params = array($phone, $id);
        $result = total($sql, $params);
        return ($result == 0);
    }
    

    //获取最新发布的艺术品 
    function getNewestArtworks(){
        $sql="select * from artwork order by issueTime desc limit 10";
        return select($sql);
    }

    //修改购物车中艺术品状态
    // function modifySoldStateInShoppinglist($artworkId,$businessState){
    //     $sql="update shoppinglist set businessState='$businessState' where artworkId='$artworkId' ";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function modifySoldStateInShoppinglist($artworkId, $businessState) {
        $sql = "UPDATE shoppinglist SET businessState=? WHERE artworkId=?";
        $params=array($businessState, $artworkId);
        $result = dml($sql, $params);
        return ($result > 0);
    }
    

    //添加已下单艺术品
    // function insertOrders($userId,$artworkId,$workname,$price,$orderTime){
    //     $sql="insert into orders (userId,artworkId,workname,price,orderTime) values ('$userId','$artworkId','$workname','$price','$orderTime')";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function insertOrders($userId, $artworkId, $workname, $price, $orderTime) {
        $sql = "INSERT INTO orders (userId, artworkId, workname, price, orderTime) VALUES (?, ?, ?, ?, ?)";
        $params = array($userId, $artworkId, $workname, $price, $orderTime);
        $result = dml($sql, $params);
        return ($result > 0);
    }
    

    //根据艺术品名字搜索
    // function searchByArtworkName($content){
    //     $sql="select * from artwork where workname like '%$content%' ";
    //     return select($sql);
    // }
    function searchByArtworkName($content) {
        $sql = "SELECT * FROM artwork WHERE workname LIKE ?";
        $params = array("%$content%");
        return select($sql, $params);
    }    
    
     //根据艺术品名字搜索
    //  function searchByAuthorName($content){
    //     $sql="select * from artwork where author like '%$content%' ";
    //     return select($sql);
    // }
    function searchByAuthorName($content) {
        $sql = "SELECT * FROM artwork WHERE author LIKE ?";
        $params = array("%$content%");
        return select($sql, $params);
    }
    
    
     //根据艺术品名字搜索
    //  function searchByArtworkStyle($content){
    //     $sql="select * from artwork where style like '%$content%' ";
    //     return select($sql);
    // }
    function searchByArtworkStyle($content) {
        $sql = "SELECT * FROM artwork WHERE style LIKE ?";
        $params = array("%$content%");
        return select($sql, $params);
    }
    

    //获取所有艺术品
    function getAllArtworks(){
        $sql="select * from artwork";
        return select($sql);
    }

    //获取访问记录数量
    // function getVisitRecorderTotal($userId,$artworkId){
    //     $sql="select * from visitrecorder where userId='$userId' and artworkId='$artworkId' ";
    //     return total($sql);
    // }
    function getVisitRecorderTotal($userId, $artworkId) {
        $sql = "SELECT * FROM visitrecorder WHERE userId = ? AND artworkId = ?";
        $params = array($userId, $artworkId);
        return total($sql, $params);
    }    

    //修改艺术品访问量
    // function updateArtworkVisited($artworkId,$visited){
    //     $sql="update artwork set visited='$visited' where id='$artworkId' ";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function updateArtworkVisited($artworkId, $visited) {
        $sql = "UPDATE artwork SET visited = ? WHERE id = ?";
        $params = array($visited, $artworkId);
        $result = dml($sql, $params);
        return ($result > 0);
    }
    
    
    //添加访问记录
    // function insertVisitRecorder($userId,$artworkId,$workname,$visitTime){
    //     $sql="insert into visitrecorder (userId,artworkId,workname,visitTime) values ('$userId','$artworkId','$workname','$visitTime')";
    //     $result=dml($sql);
    //     if($result==0){
    //         return false;
    //     }
    //     return true;
    // }
    function insertVisitRecorder($userId, $artworkId, $workname, $visitTime) {
        $sql = "INSERT INTO visitrecorder (userId, artworkId, workname, visitTime) VALUES (?, ?, ?, ?)";
        $params = array($userId, $artworkId, $workname, $visitTime);
        $result = dml($sql, $params);
        return ($result > 0);
    }
    

    //获取最新的访问记录
    // function getNewestVisitRecorder($userId,$artworkId){
    //     $sql="select * from visitrecorder where userId='$userId' and artworkId='$artworkId' order by visitTime desc limit 1";
    //     return get($sql);
    // }
    function getNewestVisitRecorder($userId, $artworkId) {
        $sql = "SELECT * FROM visitrecorder WHERE userId = ? AND artworkId = ? ORDER BY visitTime DESC LIMIT 1";
        $params = array($userId, $artworkId);
        return get($sql, $params);
    }    

    //获取最近五条访问记录
    // function getNewestVisitRecorderLimit($userId){
    //     $sql="select * from visitrecorder where userId='$userId' order by visitTime desc limit 5";
    //     return select($sql);
    // }
    function getNewestVisitRecorderLimit($userId) {
        $sql = "SELECT * FROM visitrecorder WHERE userId = ? ORDER BY visitTime DESC LIMIT 5";
        $params = array($userId);
        return select($sql, $params);
    }    

    //获取全部访问记录
    // function getVisitRecorders($userId,$artworkId){
    //     $sql="select * from visitrecorder where userId='$userId' and artworkId='$artworkId' ";
    //     return select($sql);
    // }
    function getVisitRecorders($userId, $artworkId) {
        $sql = "SELECT * FROM visitrecorder WHERE userId = ? AND artworkId = ?";
        $params = array($userId, $artworkId);
        return select($sql, $params);
    }
    