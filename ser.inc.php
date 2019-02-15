<head>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/jquery/dist/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

</head>


<h2>测试点搜索：</h2>
<form action="index.php?action=list" method="POST" role="form">

    <div class="form-group">

        <label for="name">测试编号：</label>
        <input type="text" class="form-control" name="faultid"/>
        <label for="name">信号名称：</label>
        <input type="text" class="form-control" name="netname"/><br>
        <label for="name">测试项名：</label>
        <input type="text" class="form-control" name="testitem"/><br>
        <label for="name">测试状态：</label>
        <input type="text"  class="form-control" name="teststatus" /><br>
        <label for="name">错误类型：</label>
        <input type="text" class="form-control" name="probtype"/><br>

        <button type="submit" name="add" class="btn btn-default">搜索</button>
<!--        <input type="submit" name="add" value="搜索测试点"/>-->
    </div>

</form>



<!--测试编号：<input type="text" name="faultid"/><br>-->
<!--信号名称：<input type="text" name="netname"/><br>-->
<!--测试项名：<input type="text" name="testitem"/><br>-->
<!--测试状态：<input type="text" name="teststatus" /><br>-->
<!--错误类型：<input type="text" name="probtype"/><br>-->
<!---->
<!--<input type="submit" name="add" value="搜索测试点"/>-->


