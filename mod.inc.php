<?php
include "conn.inc.php";

$sql="select id,faultid,netname,testitem,teststatus,probtype,testlog from fmea where id ='{$_GET["id"]}'";
$reuslt=mysqli_query($link,$sql);

if($reuslt && mysqli_num_rows($reuslt)>0){
    list($id,$faultid,$netname,$testitem,$teststatus,$probtype,$testlog)=mysqli_fetch_row($reuslt);
}else{
    die("没有找到需要修改的测试点");
}

mysqli_free_result($reuslt);
mysqli_close($link);
?>

<head>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/jquery/dist/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

</head>

<h2>修改测试点</h2>
<form enctype="multipart/form-data" action="index.php?action=update" method="POST" role="form">

    <div class="form-group">

        <input type="hidden" name="id" value="<?php echo $id?>"/>

        <label for="name">测试编号：</label>
        <input type="text" class="form-control" name="faultid" value="<?php echo $faultid ?>"/>
        <label for="name">信号名称：</label>
        <input type="text" class="form-control" name="netname" value="<?php echo $netname ?>"/>
        <label for="name">测试项名：</label>
        <input type="text" class="form-control" name="testitem" value="<?php echo $testitem ?>"/>
        <label for="name">测试状态：</label>
        <input type="text" class="form-control" name="teststatus" value="<?php echo $teststatus ?>"/>
        <label for="name">探针类型：</label>
        <input type="text" class="form-control" name="probtype" value="<?php echo $probtype ?>"/>

        <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
        <input type="hidden" name="testlogname" value="<?php echo $testlog ?>"/>

        <label for="inputfile">测试日志：</label>
        <input type="file" name="testlog" value="<?php echo $testlog ?>"/><br>

        <button type="submit" name="add" >修改</button>
<!--        <input type="submit" class="btn btn-default" name="add" value="修改测试点"/>-->


    </div>


</form>



<!--<input type="hidden" name="id" value="--><?php //echo $id?><!--"/>-->
<!--测试编号：<input type="text" name="faultid" value="--><?php //echo $faultid ?><!--"/><br>-->
<!--信号名称：<input type="text" name="netname" value="--><?php //echo $netname ?><!--"/><br>-->
<!--测试项名：<input type="text" name="testitem" value="--><?php //echo $testitem ?><!--"/><br>-->
<!--测试状态：<input type="text" name="teststatus" value="--><?php //echo $teststatus ?><!--"/><br>-->
<!--探针类型：<input type="text" name="probtype" value="--><?php //echo $probtype ?><!--"/><br>-->
<!--<input type="hidden" name="MAX_FILE_SIZE" value="1000000"/><br>-->
<!--<input type="hidden" name="testlogname" value="--><?php //echo $testlog ?><!--"/>-->
<!--测试日志：<input type="file" name="testlog" value="--><?php //echo $testlog ?><!--"/><br>-->
<!--<input type="submit" name="add" value="修改测试点"/>-->


