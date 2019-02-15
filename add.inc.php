<head>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/jquery/dist/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

</head>



<h2>添加测试点</h2>
<form enctype="multipart/form-data" action="index.php?action=insert" method="POST" role="form">
    <div class="form-group">

        <label for="name">测试编号：</label>
        <input type="text" class="form-control" name="faultid" value=""/>
        <label for="name">信号名称：</label>
        <input type="text" class="form-control" name="netname" value=""/>
        <label for="name">测试项名：</label>
        <input type="text" class="form-control" name="testitem" value=""/>
        <label for="name">测试状态：</label>
        <input type="text" class="form-control" name="teststatus" value=""/>
        <label for="name">错误类型：</label>
        <input type="text" class="form-control" name="probtype" value=""/>

        <label for="inputfile">测试日志：</label>
        <input type="file" name="testlog" value=""/>
        <label for="name">导入表格：</label>
        <input type="file" name="excelfile" value=""/>
        <button type="submit" class="btn btn-default">添加</button>
    </div>
<!--    测试编号：<input type="text" name="faultid" value=""/><br>-->
<!--    信号名称：<input type="text" name="netname" value=""/><br>-->
<!--    测试项名：<input type="text" name="testitem" value=""/><br>-->
<!--    测试状态：<input type="text" name="teststatus" value=""/><br>-->
<!--    错误类型：<input type="text" name="probtype" value=""/><br>-->
<!--    <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>-->
<!--    测试日志：<input type="file" name="testlog" value=""/><br>-->
<!--    导入表格：<input type="file" name="excelfile" value=""/><br>-->

<!--    <input type="submit" name="add" value="添加"/>-->

</form>




<!--    <form role="form">-->
<!--        <div class="form-group">-->
<!--            <label for="name">名称</label>-->
<!--            <input type="text" class="form-control" id="name"-->
<!--                   placeholder="请输入名称">-->
<!--        </div>-->
<!--        <div class="form-group">-->
<!--            <label for="inputfile">文件输入</label>-->
<!--            <input type="file" id="inputfile">-->
<!--            <p class="help-block">这里是块级帮助文本的实例。</p>-->
<!--        </div>-->
<!--        <div class="checkbox">-->
<!--            <label>-->
<!--                <input type="checkbox"> 请打勾-->
<!--            </label>-->
<!--        </div>-->
<!--        <button type="submit" class="btn btn-default">提交</button>-->
<!--    </form>-->