<html>
<head>
    <title>测试点列表</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/jquery/dist/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <style>
        body, td {
            font-size: 12px;
        }

        p {
            font-size: 16px;
        }

        .wrapper{

            height: 50px;
        }
    </style>
</head>
<body>
<!--<h1>FMEA/FIT测试</h1>-->
<!--<p>-->
<!--    <a href="index.php?action=add">添加测试点</a>||-->
<!--    <a href="index.php?action=list">测试点列表</a>||-->
<!--    <a href="index.php?action=set">搜索测试点</a>||-->
<!--    <a href="index.php?action=test">FIT测试</a>-->
<!--<hr>-->
<!--</p>-->



<div class="wrapper" style="margin-bottom:0">
    <h1>FMEA/FIT测试</h1>
    <!-- <p>重置浏览器窗口大小查看效果！</p>  -->
</div>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php?action=add">添加测试点</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php?action=list">测试点列表</a></li>
                <li><a href="index.php?action=set">搜索测试点</a></li>
                <li><a href="index.php?action=test">FIT测试</a></li>
            </ul>
        </div>
    </div>
</nav>



<?php

include "func.inc.php";
//include "conn.inc.php";


if ($_GET["action"] == "add") {
    include "add.inc.php";
} elseif ($_GET["action"] == "insert") {
    $up = upload();
    if (!$up[0])
        die($up[1]);
    include "conn.inc.php";
//    $sql = "insert into fmea(faultid,netname,teststatus,probtype,uptime,testlog,detail)
//values('{$_POST["faultid"]}','{$_POST["netname"]}','{$_POST["teststatus"]}','{$_POST["probtype"]}',
//'" . time() . "','{$up[1]}','{$_POST["detail"]}')";

//   @ $hz=array_pop(explode('/',$up[1]));
//    $newfileName=$_POST["faultid"]."_".$_POST["probtype"]."_".date("Ymd").$hz;

//    $sql = "insert into fmea(faultid,netname,testitem,teststatus,probtype,uptime,testlog)
//values('{$_POST["faultid"]}','{$_POST["netname"]}','{$_POST["testitem"]}','{$_POST["teststatus"]}','{$_POST["probtype"]}',
//'" . time() . "','{$up[1]}')";
    $sql = "insert into fmea(faultid,netname,testitem,teststatus,probtype,uptime,testlog)
values('{$_POST["faultid"]}','{$_POST["netname"]}','{$_POST["testitem"]}','{$_POST["teststatus"]}','{$_POST["probtype"]}',
'" . time() . "','{$up[1]}')";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_affected_rows($link) > 0) {
        echo "插入一条数据成功!";
       // include "list.inc.php";
    } else {
        echo "数据录入失败!".mysqli_error($link);
    }

    mysqli_close($link);

} elseif ($_GET["action"]=="mod"){
    echo '动作为：'.$_GET["action"];
    include "mod.inc.php";

}elseif ($_GET["action"]=="update"){
    if($_FILES["testlog"]["error"]=="0"){
        $up=upload();
        if($up[0])
            $testlog=$up[1];
        else
            die($up[1]);
    }else{
        $testlog=$_POST["testlogname"];
    }

    include "conn.inc.php";
    $sql="update fmea set faultid='{$_POST["faultid"]}',netname='{$_POST["netname"]}',testitem='{$_POST["testitem"]}',teststatus='{$_POST["teststatus"]}',
probtype='{$_POST["probtype"]}',testlog='{$testlog}' where id='{$_POST["id"]}'";
    $result=mysqli_query($link,$sql);

    if($result && mysqli_affected_rows($link)>0){
        if($up[0]){
            dellog($_POST["testlogname"]);
            echo "日志修改成功";
        }else{
            echo "日志修改失败";
        }
        mysqli_close($link);
    }

}elseif ($_GET["action"] == "del") {
    include "conn.inc.php";
    $result = mysqli_query($link, "delete from fmea where id ='{$_GET["id"]}'");
    if ($result && mysqli_affected_rows($link) > 0) {

        dellog($_GET["testlog"]);
        echo "<script>window.location=" . $_SERVER["HTTP_REFERER"] . "</script>";

    } else {

        echo "数据删除失败!";
    }
    mysqli_close($link);
} elseif ($_GET["action"] == "set") {

    include "ser.inc.php";

}elseif ($_GET["action"] == "test") {

    include "test.inc.php";

} else {

    include "list.inc.php";
}


?>
</body>
</html>
