<?php

$ser = !empty($_POST) ? $_POST : $_GET;

$where = array();
$param = "";
$title = "";

if (!empty($ser["faultid"])) {
    $where[] = "faultid like '%{$ser["faultid"]}%'";
    $param .= "&faultid={$ser["faultid"]}";
    $title .= '测试点编号中包含"' . $ser["faultid"] . '"的';
}

if (!empty($ser["netname"])) {
    $where[] = "netname like '%{$ser["netname"]}%'";
    $param .= "&netname={$ser["netname"]}";
    $title .= '信号名称中包含"' . $ser["netname"] . '"的';
}


if (!empty($ser["testitem"])) {
    $where[] = "testitem like '%{$ser["testitem"]}%'";
    $param .= "&testitem={$ser["testitem"]}";
    $title .= '测试项名称中包含"' . $ser["testitem"] . '"的';
}


if (!empty($ser["teststatus"])) {
    $where[] = "teststatus like '%{$ser["teststatus"]}%'";
    $param .= "&teststatus={$ser["teststatus"]}";
    $title .= '测试状态中包含"' . $ser["teststatus"] . '"的';
}


if (!empty($where)) {
    $where = "where " . implode("and", $where);
    $title .= "搜索：" . $title;
} else {
    $where = "";
    $title = "测试点列表";
}
echo '<h3>' . $title . '</h3>';
?>


<head>

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/jquery/dist/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

</head>

<body>

<!--范例-->
<!---->
<!--<table class="table">-->
<!--    <caption>基本的表格布局</caption>-->
<!--    <thead>-->
<!--    <tr>-->
<!--        <th>名称</th>-->
<!--        <th>城市</th>-->
<!--    </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
<!--    <tr>-->
<!--        <td>Tanmay</td>-->
<!--        <td>Bangalore</td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td>Sachin</td>-->
<!--        <td>Mumbai</td>-->
<!--    </tr>-->
<!--    </tbody>-->
<!--</table>-->




<table class="table">
<!--    <caption>基本的表格布局</caption>-->
    <thead>
    <tr >
        <th>ID</th>
        <th>测试编号</th>
        <th>信号名称</th>
        <th>测试项</th>
        <th>测试状态</th>
        <th>错误类型</th>
        <th>测试时间</th>
        <th>测试log</th>
        <th>操作</th>
    </tr>

    </thead>

    <tbody>

    <?php
    include "conn.inc.php";
    include "Tool/page.class.php";
    $sql = "select count(*) from fmea {$where}";
    $result = mysqli_query($link, $sql);
    List($total) = mysqli_fetch_row($result);

    //  $page = new Page($total, 10, $param);
    $page = new Page($total, 40, $param);
    $sql = "select id,faultid,netname,testitem,teststatus,probtype,testlog,uptime,testlog from fmea {$where} order by id desc {$page->limit}";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $i = 0;
        while (list($id, $faultid, $netname,$testitem, $teststatus, $probtype, $testlog, $uptime,$testlog) = mysqli_fetch_row($result)) {
            if ($i++ % 2 == 0)
                echo '<tr bgcolor="#eeeeee">';
            else
                echo '<tr>';
            echo '<td>' . $id . '</td>';
            echo '<td>' . $faultid . '</td>';
            echo '<td>' . $netname . '</td>';
            echo '<td>' . $testitem . '</td>';
            echo '<td>' . $teststatus . '</td>';
            echo '<td>' . $probtype . '</td>';
            echo '<td>' . date("Y/m/d H:m:s", $uptime) . '</td>';
//          echo  '<td><a href="uploads/'.$testlog.'">'.$faultid."_".$probtype.
//              "_".date("Ymd").'</a></td>';

            echo  '<td><a href="uploads/'.$testlog.'">'.$testlog.'</a></td>';
            // echo '<td>' . $testlog . '</td>';
            //  echo '<td>' . $testlog . '</td>';
            echo '<td><a href="index.php?action=mod&id=' . $id . '">修改</a>/<a onclick="return 
            confirm(\'你确定要删除该点' . $faultid . '吗？\')" href="index.php?action=del&id=' . $id .
                '&testlog=' . $testlog . '">删除</a> </td>';
            echo '</tr>';

        }

        echo '<tr><td colspan="6">' . $page->fpage() . '</td>';

    } else {
        echo '<tr><td colspan="6" align="center">没有测试点被找到</td></tr>';
    }

    mysqli_free_result($result);
    mysqli_close($link);


    ?>

    </tbody>
</table>

</body>








